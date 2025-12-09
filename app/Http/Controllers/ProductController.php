<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SpecDefinition;
use App\Models\ComponentType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search, filter, and sort
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 12);

        $query = Product::with(['category', 'images']);

        // Search
        if ($request->filled('q') || $request->filled('search')) {
            $searchTerm = $request->string('q') ?: $request->string('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by category (supports both ID and slug) - including subcategories
        $currentCategory = null;
        $categoryIds = [];
        if ($request->filled('category')) {
            $currentCategory = Category::where('slug', $request->string('category'))
                ->orWhere('id', $request->input('category'))
                ->first();
            if ($currentCategory) {
                // Get category and all its children IDs
                $categoryIds = $this->getCategoryAndChildrenIds($currentCategory);
                $query->whereIn('category_id', $categoryIds);
            }
        } elseif ($request->filled('category_id')) {
            $currentCategory = Category::find($request->integer('category_id'));
            if ($currentCategory) {
                $categoryIds = $this->getCategoryAndChildrenIds($currentCategory);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Price range filter
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->string('price_range'));
            $query->whereBetween('price', [(float) $min, (float) $max]);
        } elseif ($request->filled('min_price') || $request->filled('max_price')) {
            if ($request->filled('min_price')) {
                $query->where('price', '>=', (float) $request->input('min_price'));
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', (float) $request->input('max_price'));
            }
        }

        // Spec-based filtering using product_specs table
        $this->applySpecFilters($query, $request);

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $query->latest('created_at');
                break;
        }

        $products = $query->paginate($perPage)->withQueryString()->fragment('product-list');

        // Use cached categories to reduce database load
        $categories = Category::getRootWithChildrenCached();

        // Get available filter options based on current category
        $filterOptions = $this->getFilterOptions($currentCategory, $categoryIds);

        // Get subcategories if viewing a parent category
        $subcategories = [];
        if ($currentCategory) {
            $subcategories = $this->getSubcategoriesWithCounts($currentCategory, $request);
        }

        // Get main categories with counts
        $mainCategoriesWithCounts = $this->getMainCategoriesWithCounts();

        return view('products.index', compact('products', 'categories', 'filterOptions', 'currentCategory', 'subcategories', 'mainCategoriesWithCounts'));
    }

    /**
     * Get category and all its children IDs recursively using a single query
     */
    private function getCategoryAndChildrenIds($category): array
    {
        // Use a more efficient approach - collect all IDs in a single query with recursive loading
        $ids = [$category->id];
        
        // Load all descendants at once
        $category->loadMissing('recursiveChildren');
        
        // Recursively collect IDs
        $collectIds = function($cat) use (&$collectIds, &$ids) {
            foreach ($cat->recursiveChildren as $child) {
                $ids[] = $child->id;
                $collectIds($child);
            }
        };
        
        $collectIds($category);

        return $ids;
    }

    /**
     * Get subcategories with product counts using optimized query
     */
    private function getSubcategoriesWithCounts($category, Request $request): array
    {
        if ($category->children->isEmpty()) {
            return [];
        }

        // Get all child category IDs
        $childIds = $category->children->pluck('id')->toArray();
        
        // Build base query for counting
        $baseQuery = Product::query();
        
        // Apply spec filters to the base query
        $this->applySpecFilters($baseQuery, $request);
        
        // Get counts for all children in a single query using groupBy
        $counts = (clone $baseQuery)
            ->select('category_id', DB::raw('COUNT(*) as count'))
            ->whereIn('category_id', $childIds)
            ->groupBy('category_id')
            ->pluck('count', 'category_id');

        $subcategories = [];
        
        foreach ($category->children as $child) {
            $count = $counts->get($child->id, 0);
            
            if ($count > 0) {
                $subcategories[] = [
                    'id' => $child->id,
                    'name' => $child->name,
                    'slug' => $child->slug,
                    'count' => $count,
                ];
            }
        }

        return $subcategories;
    }

    /**
     * Apply specification-based filters to the query
     */
    private function applySpecFilters($query, Request $request): void
    {
        // Get all filter parameters from request (excluding system params)
        $excludeParams = ['category', 'category_id', 'q', 'search', 'price_range', 'min_price', 'max_price', 'sort', 'page', 'per_page'];
        $filterParams = array_diff_key($request->all(), array_flip($excludeParams));

        foreach ($filterParams as $filterParam => $values) {
            if (!empty($values)) {
                $values = (array) $values;

                // Special handling for 'brand' filter - search in product name
                if ($filterParam === 'brand') {
                    $query->where(function ($nameQuery) use ($values) {
                        foreach ($values as $value) {
                            $nameQuery->orWhere('name', 'like', "%{$value}%");
                        }
                    });
                } else {
                    // Find the spec definition to know the type
                    $specDef = SpecDefinition::where('code', $filterParam)->first();

                    if ($specDef) {
                        $query->whereHas('specs', function ($q) use ($specDef, $values) {
                            $q->where('spec_definition_id', $specDef->id);

                            if ($specDef->input_type === 'range') {
                                // Handle range filter: expect "min-max" string
                                $rangeValue = $values[0] ?? '';
                                $parts = explode('-', $rangeValue);
                                if (count($parts) === 2) {
                                    $min = (float) $parts[0];
                                    $max = (float) $parts[1];
                                    // Cast value to decimal for numeric comparison
                                    $q->whereRaw('CAST(value AS DECIMAL(10,2)) BETWEEN ? AND ?', [$min, $max]);
                                }
                            } else {
                                // Default behavior (checkboxes, etc)
                                $q->where(function ($valueQuery) use ($values) {
                                    foreach ($values as $value) {
                                        $valueQuery->orWhere('value', 'like', "%{$value}%");
                                    }
                                });
                            }
                        });
                    }
                }
            }
        }
    }

    /**
     * Get available filter options based on current category with product counts
     */
    private function getFilterOptions($currentCategory, $categoryIds = []): array
    {
        $options = [];

        if (!$currentCategory || empty($categoryIds)) {
            return $options;
        }

        // Get component type from products in this category
        $componentTypeId = Product::whereIn('category_id', $categoryIds)
            ->whereNotNull('component_type_id')
            ->value('component_type_id');

        if (!$componentTypeId) {
            return $options;
        }

        // Get filterable spec definitions for this component type
        $specDefinitions = SpecDefinition::where('component_type_id', $componentTypeId)
            ->where('is_filterable', true)
            ->orderBy('sort_order')
            ->get();

        // Get unique values for each filterable spec with product counts
        foreach ($specDefinitions as $specDef) {
            $rawValues = DB::table('product_specs')
                ->join('products', 'product_specs.product_id', '=', 'products.id')
                ->whereIn('products.category_id', $categoryIds)
                ->where('product_specs.spec_definition_id', $specDef->id)
                ->whereNotNull('product_specs.value')
                ->where('product_specs.value', '!=', '')
                ->select('product_specs.value', DB::raw('COUNT(DISTINCT products.id) as count'))
                ->groupBy('product_specs.value')
                ->orderBy('product_specs.value')
                ->get();

            // Merge similar values (case-insensitive, whitespace)
            $mergedValues = [];
            foreach ($rawValues as $item) {
                $value = trim($item->value);
                // Normalize: lowercase and remove extra spaces
                $normalized = strtolower(preg_replace('/\s+/', ' ', $value));

                // Skip invalid values
                if (empty($value) || in_array($normalized, ['desktop', 'undefined', 'null', 'n/a'])) {
                    continue;
                }

                if (!isset($mergedValues[$normalized])) {
                    $mergedValues[$normalized] = [
                        'value' => $value, // Keep the first encountered casing
                        'count' => 0
                    ];
                }
                $mergedValues[$normalized]['count'] += $item->count;
            }

            $valuesWithCounts = array_values($mergedValues);

            // Sort by value for display
            usort($valuesWithCounts, function ($a, $b) {
                return strnatcasecmp($a['value'], $b['value']);
            });

            if (!empty($valuesWithCounts)) {
                $options[$specDef->code] = [
                    'name' => $specDef->name,
                    'code' => $specDef->code,
                    'unit' => $specDef->unit,
                    'values' => $valuesWithCounts,
                    'spec_code' => $specDef->code,
                    'input_type' => $specDef->input_type,
                    'meta_data' => $specDef->meta_data,
                ];
            }
        }

        return $options;
    }

    /**
     * Display a single product detail page
     */
    public function show(Product $product): View
    {
        // Optimize eager loading with specific constraints
        $product->load([
            'category:id,name,slug',
            'images' => function($query) {
                $query->orderBy('is_primary', 'desc');
            },
            'approvedReviews' => function($query) {
                $query->latest()->limit(10);
            },
            'approvedReviews.user:id,name',
            'specs.specDefinition' => function ($query) {
                $query->orderBy('sort_order');
            }
        ]);

        // Get related products (same category) with minimal data
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => function($query) {
                $query->where('is_primary', true)->limit(1);
            }])
            ->limit(4)
            ->get(['id', 'name', 'slug', 'price', 'sale_price', 'category_id']);

        // Check if current user can review (has purchased and not reviewed yet)
        $canReview = false;
        $userReview = null;

        if (auth()->check()) {
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();

            if (!$userReview) {
                // Optimize the purchase check query
                $canReview = \App\Models\OrderItem::query()
                    ->whereHas('order', function ($query) {
                        $query->where('user_id', auth()->id())
                            ->whereIn('status', ['delivered', 'completed']);
                    })
                    ->where('product_id', $product->id)
                    ->exists();
            }
        }

        return view('products.show', compact('product', 'relatedProducts', 'canReview', 'userReview'));
    }

    /**
     * Get product details as JSON for PC Builder
     */
    public function getJson(Product $product)
    {
        $product->load(['specs.specDefinition', 'category']);

        $specs = $product->specs->mapWithKeys(function ($spec) {
            return [$spec->specDefinition->code => $spec->value];
        });

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image_url ?? asset('images/no-image.png'),
            'specs' => $specs,
            'category_slug' => $product->category->slug,
        ]);
    }

    /**
     * Compare products
     */
    public function compare(Request $request)
    {
        $ids = explode(',', $request->query('ids', ''));
        $products = Product::with(['specs.specDefinition', 'category'])
            ->whereIn('id', $ids)
            ->get();

        if ($products->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Vui lòng chọn sản phẩm để so sánh');
        }

        // Get all unique spec definitions from these products
        $specDefinitions = collect();
        foreach ($products as $product) {
            foreach ($product->specs as $spec) {
                if (!$specDefinitions->contains('id', $spec->specDefinition->id)) {
                    $specDefinitions->push($spec->specDefinition);
                }
            }
        }

        // Sort specs by sort_order
        $specDefinitions = $specDefinitions->sortBy('sort_order');

        return view('products.compare', compact('products', 'specDefinitions'));
    }

    /**
     * Get main categories with product counts using optimized query
     */
    private function getMainCategoriesWithCounts(): array
    {
        $mainCategories = [
            'CPU' => ['cpu'],
            'VGA' => ['vga'],
            'RAM' => ['ram'],
            'SSD' => ['ssd'],
            'Mainboard' => ['mainboard'],
            'HDD' => ['hdd'],
            'Case' => ['case'],
            'PSU' => ['psu'],
            'Monitor' => ['monitor'],
        ];

        // Get all categories at once
        $allSlugs = array_merge(...array_values($mainCategories));
        $categoriesCollection = Category::whereIn('slug', $allSlugs)
            ->with('recursiveChildren')
            ->get()
            ->keyBy('slug');

        // Build category ID to slug mapping for all categories and their children
        $categoryIdToSlug = [];
        foreach ($categoriesCollection as $slug => $category) {
            $ids = $this->getCategoryAndChildrenIds($category);
            foreach ($ids as $id) {
                $categoryIdToSlug[$id] = $slug;
            }
        }

        // Get all product counts in a single query
        $counts = Product::select('category_id', DB::raw('COUNT(*) as count'))
            ->whereIn('category_id', array_keys($categoryIdToSlug))
            ->groupBy('category_id')
            ->pluck('count', 'category_id');

        // Aggregate counts by category slug
        $slugCounts = [];
        foreach ($counts as $categoryId => $count) {
            $slug = $categoryIdToSlug[$categoryId] ?? null;
            if ($slug) {
                if (!isset($slugCounts[$slug])) {
                    $slugCounts[$slug] = 0;
                }
                $slugCounts[$slug] += $count;
            }
        }

        $result = [];
        foreach ($mainCategories as $name => $slugs) {
            $result[] = [
                'name' => $name,
                'slug' => $slugs[0],
                'count' => $slugCounts[$slugs[0]] ?? 0
            ];
        }

        return $result;
    }

    /**
     * Search suggestions API for smart search bar
     */
    public function searchSuggestions(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'products' => [],
                'categories' => [],
                'brands' => []
            ]);
        }

        // Search products (limit to 5) with optimized eager loading
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->with([
                'images' => function($q) {
                    $q->where('is_primary', true)->limit(1);
                },
                'category:id,name'
            ])
            ->limit(5)
            ->get(['id', 'name', 'slug', 'price', 'sale_price', 'category_id'])
            ->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->sale_price ?? $product->price,
                'original_price' => $product->sale_price ? $product->price : null,
                'formatted_price' => number_format($product->sale_price ?? $product->price, 0, ',', '.') . '₫',
                'image' => $product->images->first()?->url ?? asset('images/placeholder.png'),
                'category' => $product->category?->name,
                'url' => route('products.show', $product->slug)
            ]);

        // Search categories (limit to 3) with product counts
        $categories = Category::where('name', 'like', "%{$query}%")
            ->withCount('products')
            ->limit(3)
            ->get(['id', 'name', 'slug'])
            ->map(fn($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
                'product_count' => $cat->products_count,
                'url' => route('products.index', ['category' => $cat->slug])
            ]);

        // Get unique brands matching query
        $brands = Product::select('brand')
            ->where('brand', 'like', "%{$query}%")
            ->whereNotNull('brand')
            ->distinct()
            ->limit(5)
            ->pluck('brand')
            ->map(fn($brand) => [
                'name' => $brand,
                'url' => route('products.index', ['brand' => [$brand]])
            ]);

        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
}
