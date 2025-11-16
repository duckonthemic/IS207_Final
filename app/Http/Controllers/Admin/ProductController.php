<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ComponentType;
use App\Models\SpecDefinition;
use App\Models\ProductSpec;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display list of products (Admin)
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');

        $query = Product::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->latest('id')->paginate($perPage);

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show create product form
     */
    public function create(): View
    {
        $categories = Category::all();
        $brands = Brand::ordered()->get();
        $componentTypes = ComponentType::ordered()->get();
        return view('admin.products.create', compact('categories', 'brands', 'componentTypes'));
    }

    /**
     * Store new product
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'component_type_id' => 'nullable|exists:component_types,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products|max:255',
            'stock' => 'required|integer|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'brand' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'specs' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create($validated);

            // Lưu specs nếu có
            if (!empty($validated['specs'])) {
                $this->syncProductSpecs($product, $validated['specs']);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được tạo thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     * Show product details
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show edit product form
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        $brands = Brand::ordered()->get();
        $componentTypes = ComponentType::ordered()->get();
        
        // Load specs với definitions
        $product->load(['specs.specDefinition']);
        
        // Lấy spec definitions cho component_type hiện tại
        $specDefinitions = [];
        if ($product->component_type_id) {
            $specDefinitions = SpecDefinition::where('component_type_id', $product->component_type_id)
                ->ordered()
                ->get();
        }
        
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'componentTypes', 'specDefinitions'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'component_type_id' => 'nullable|exists:component_types,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'stock' => 'required|integer|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'brand' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'specs' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $product->update($validated);

            // Sync specs nếu có
            if (isset($validated['specs'])) {
                $this->syncProductSpecs($product, $validated['specs']);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete product
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa');
    }

    /**
     * Get spec definitions by component type (AJAX)
     */
    public function getSpecDefinitions(Request $request)
    {
        $componentTypeId = $request->input('component_type_id');
        
        if (!$componentTypeId) {
            return response()->json([]);
        }

        $specDefinitions = SpecDefinition::where('component_type_id', $componentTypeId)
            ->ordered()
            ->get();

        return response()->json($specDefinitions);
    }

    /**
     * Sync product specs
     */
    private function syncProductSpecs(Product $product, array $specs): void
    {
        // Xóa các specs không còn trong danh sách
        $specDefinitionIds = array_keys($specs);
        $product->specs()->whereNotIn('spec_definition_id', $specDefinitionIds)->delete();

        // Tạo hoặc cập nhật specs
        foreach ($specs as $specDefinitionId => $value) {
            // Bỏ qua nếu value rỗng
            if (empty($value) && $value !== '0') {
                $product->specs()->where('spec_definition_id', $specDefinitionId)->delete();
                continue;
            }

            $product->specs()->updateOrCreate(
                ['spec_definition_id' => $specDefinitionId],
                ['value' => $value]
            );
        }
    }
}
