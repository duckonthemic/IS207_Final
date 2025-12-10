<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SpecDefinition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PcGamingController extends Controller
{
    /**
     * Display PC Gaming listing page
     */
    public function index(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-gaming', 'PC Gaming - Bộ PC Gaming Lắp Sẵn', 'Bộ máy tính gaming được lựa chọn kỹ lưỡng, tối ưu hiệu năng và giá thành');
    }

    /**
     * Display build PC configurator
     */
    public function buildPc()
    {
        return view('build-pc');
    }

    /**
     * Display PC AI listing page
     */
    public function pcAI(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-ai-workstation', 'PC AI Workstation', 'Hệ thống PC tối ưu cho Machine Learning, Deep Learning và xử lý AI');
    }

    /**
     * Display PC Office listing page
     */
    public function pcOffice(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-office', 'PC Office', 'Hệ thống PC cho văn phòng, làm việc hiệu quả');
    }

    /**
     * Display PC Design listing page
     */
    public function pcDesign(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-design', 'PC Design & Creative', 'Hệ thống PC chuyên dụng cho thiết kế đồ họa, render 3D, video editing');
    }

    private function getProductsByCategory(Request $request, $categorySlug, $title, $description)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $query = Product::where('category_id', $category->id)
            ->with(['category', 'images', 'specs.specDefinition'])
            ->withCount(['approvedReviews as approved_reviews_count']);

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Apply spec filters
        $this->applySpecFilters($query, $request);

        // Sort
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $builds = $query->paginate(12)->withQueryString();
        $filterOptions = $this->getFilterOptions($category->id);

        return view('pc-gaming.index', [
            'builds' => $builds,
            'pageTitle' => $title,
            'pageDescription' => $description,
            'filterOptions' => $filterOptions
        ]);
    }

    private function applySpecFilters($query, Request $request): void
    {
        $excludeParams = ['min_price', 'max_price', 'sort', 'page'];
        $filterParams = array_diff_key($request->all(), array_flip($excludeParams));

        foreach ($filterParams as $filterParam => $values) {
            if (!empty($values)) {
                $values = (array) $values;
                $query->whereHas('specs', function ($q) use ($filterParam, $values) {
                    $q->whereHas('specDefinition', function ($sq) use ($filterParam) {
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

    private function getFilterOptions($categoryId): array
    {
        $options = [];

        // Get component type
        $componentTypeId = Product::where('category_id', $categoryId)
            ->whereNotNull('component_type_id')
            ->value('component_type_id');

        if (!$componentTypeId) {
            return $options;
        }

        $specDefinitions = SpecDefinition::where('component_type_id', $componentTypeId)
            ->where('is_filterable', true)
            ->orderBy('sort_order')
            ->get();

        foreach ($specDefinitions as $specDef) {
            $rawValues = DB::table('product_specs')
                ->join('products', 'product_specs.product_id', '=', 'products.id')
                ->where('products.category_id', $categoryId)
                ->where('product_specs.spec_definition_id', $specDef->id)
                ->whereNotNull('product_specs.value')
                ->where('product_specs.value', '!=', '')
                ->select('product_specs.value', DB::raw('COUNT(DISTINCT products.id) as count'))
                ->groupBy('product_specs.value')
                ->orderBy('product_specs.value')
                ->get();

            $mergedValues = [];
            foreach ($rawValues as $item) {
                $value = trim($item->value);
                $normalized = strtolower(preg_replace('/\s+/', ' ', $value));

                if (empty($value) || in_array($normalized, ['desktop', 'undefined', 'null', 'n/a'])) {
                    continue;
                }

                if (!isset($mergedValues[$normalized])) {
                    $mergedValues[$normalized] = [
                        'value' => $value,
                        'count' => 0
                    ];
                }
                $mergedValues[$normalized]['count'] += $item->count;
            }

            $valuesWithCounts = array_values($mergedValues);
            usort($valuesWithCounts, function ($a, $b) {
                return strnatcasecmp($a['value'], $b['value']);
            });

            if (!empty($valuesWithCounts)) {
                $options[$specDef->code] = [
                    'name' => $specDef->name,
                    'code' => $specDef->code,
                    'values' => $valuesWithCounts,
                ];
            }
        }

        return $options;
    }
}
