<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpec;
use App\Models\Category;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display list of products (Admin)
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');

        $query = Product::with('category', 'manufacturer', 'images');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->latest('id')->paginate($perPage);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show create product form
     */
    public function create(): View
    {
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::get();

        return view('admin.products.create', compact('categories', 'manufacturers'));
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products|max:255',
            'status' => 'required|boolean',
            'specs' => 'nullable|array',
            'specs.*.key' => 'required_with:specs.*|string|max:100',
            'specs.*.value' => 'required_with:specs.*|string|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $product = Product::create($validated);

        // Add images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'url' => 'storage/' . $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        // Add specs
        if (isset($validated['specs']) && is_array($validated['specs'])) {
            foreach ($validated['specs'] as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $product->specs()->create([
                        'spec_key' => $spec['key'],
                        'spec_value' => $spec['value'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Sản phẩm đã được tạo thành công');
    }

    /**
     * Show product details
     */
    public function show(Product $product): View
    {
        $product->load('category', 'manufacturer', 'images', 'specs');

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show edit product form
     */
    public function edit(Product $product): View
    {
        $product->load('category', 'manufacturer', 'images', 'specs');
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::get();

        return view('admin.products.edit', compact('product', 'categories', 'manufacturers'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'status' => 'required|boolean',
            'specs' => 'nullable|array',
            'specs.*.key' => 'required_with:specs.*|string|max:100',
            'specs.*.value' => 'required_with:specs.*|string|max:255',
        ]);

        $product->update($validated);

        // Update specs
        $product->specs()->delete();
        if (isset($validated['specs']) && is_array($validated['specs'])) {
            foreach ($validated['specs'] as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $product->specs()->create([
                        'spec_key' => $spec['key'],
                        'spec_value' => $spec['value'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Sản phẩm đã được cập nhật');
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa');
    }
}
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'string'],
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Đã xoá sản phẩm.');
    }
}
