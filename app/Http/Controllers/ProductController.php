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
            $query->whereBetween('price', [(float)$min, (float)$max]);
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
        $categories = Category::root()->with('children')->orderBy('name')->get();

        // Get available filter options based on current category
        $filterOptions = $this->getFilterOptions($currentCategory, $categoryIds);
        
        // Get subcategories if viewing a parent category
        $subcategories = [];
        if ($currentCategory) {
            $subcategories = $this->getSubcategoriesWithCounts($currentCategory, $request);
        }

        return view('products.index', compact('products', 'categories', 'filterOptions', 'currentCategory', 'subcategories'));
    }

    /**
     * Get category and all its children IDs recursively
     */
    private function getCategoryAndChildrenIds($category): array
    {
        $ids = [$category->id];
        
        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getCategoryAndChildrenIds($child));
        }
        
        return $ids;
    }

    /**
     * Get subcategories with product counts
     */
    private function getSubcategoriesWithCounts($category, Request $request): array
    {
        $subcategories = [];
        
        foreach ($category->children as $child) {
            // Clone the base query for counting
            $countQuery = Product::query();
            
            // Apply same filters as main query
            $categoryIds = $this->getCategoryAndChildrenIds($child);
            $countQuery->whereIn('category_id', $categoryIds);
            
            // Apply spec filters
            $this->applySpecFilters($countQuery, $request);
            
            $count = $countQuery->count();
            
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
                    $query->where(function($nameQuery) use ($values) {
                        foreach ($values as $value) {
                            $nameQuery->orWhere('name', 'like', "%{$value}%");
                        }
                    });
                } else {
                    // For other filters, use spec-based filtering
                    $query->whereHas('specs', function ($q) use ($filterParam, $values) {
                        $q->whereHas('specDefinition', function ($sq) use ($filterParam) {
                            // Match exact spec code
                            $sq->where('code', $filterParam);
                        })->where(function ($valueQuery) use ($values) {
                            foreach ($values as $value) {
                                $valueQuery->orWhere('value', 'like', "%{$value}%");
                            }
                        });
                    });
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
            $valuesWithCounts = DB::table('product_specs')
                ->join('products', 'product_specs.product_id', '=', 'products.id')
                ->whereIn('products.category_id', $categoryIds)
                ->where('product_specs.spec_definition_id', $specDef->id)
                ->whereNotNull('product_specs.value')
                ->where('product_specs.value', '!=', '')
                ->select('product_specs.value', DB::raw('COUNT(DISTINCT products.id) as count'))
                ->groupBy('product_specs.value')
                ->orderBy('product_specs.value')
                ->get()
                ->map(function ($item) {
                    return [
                        'value' => trim($item->value),
                        'count' => $item->count,
                    ];
                })
                ->filter(function ($item) {
                    // Filter out unwanted values
                    $value = strtolower($item['value']);
                    $blacklist = ['desktop', 'undefined', 'null', 'n/a', ''];
                    return !empty($item['value']) && $item['count'] > 0 && !in_array($value, $blacklist);
                })
                ->unique('value') // Remove duplicates
                ->values()
                ->toArray();

            if (!empty($valuesWithCounts)) {
                // Extract the base code without component prefix for form field name
                $baseCode = preg_replace('/^[a-z]+_/', '', $specDef->code);
                
                $options[$baseCode] = [
                    'name' => $specDef->name,
                    'code' => $baseCode,
                    'unit' => $specDef->unit,
                    'values' => $valuesWithCounts,
                    'spec_code' => $specDef->code,
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
        $product->load([
            'category', 
            'images', 
            'approvedReviews.user',
            'specs.specDefinition' => function($query) {
                $query->orderBy('sort_order');
            }
        ]);

        // Get related products (same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        // Check if current user can review (has purchased and not reviewed yet)
        $canReview = false;
        $userReview = null;
        
        if (auth()->check()) {
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();
            
            if (!$userReview) {
                $canReview = \App\Models\OrderItem::whereHas('order', function($query) {
                    $query->where('user_id', auth()->id())
                          ->whereIn('status', ['delivered', 'completed']);
                })->where('product_id', $product->id)->exists();
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
}
