<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    /**
     * Display a listing of products (PLP - Product Listing Page)
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 12);
        $sort = $request->input('sort', 'latest');

        $query = Product::query()
            ->active()
            ->with(['category', 'manufacturer', 'images']);

        // Filter by category
        if ($request->filled('category')) {
            $category = $request->string('category');
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        // Filter by manufacturer
        if ($request->filled('manufacturer')) {
            $manufacturer = $request->string('manufacturer');
            $query->whereHas('manufacturer', fn ($q) => $q->where('slug', $manufacturer));
        }

        // Search
        if ($request->filled('q')) {
            $searchTerm = $request->string('q');
            // Use fulltext search if available
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        // Sorting
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

        $products = $query->paginate($perPage)->withQueryString();
        $categories = Category::active()->root()->orderBy('name')->get();
        $manufacturers = Manufacturer::orderBy('name')->get();

        $minPrice = Product::active()->min('price') ?? 0;
        $maxPrice = Product::active()->max('price') ?? 100000000;

        return view('products.index', compact(
            'products',
            'categories',
            'manufacturers',
            'minPrice',
            'maxPrice'
        ));
    }

    /**
     * Display a single product (PDP - Product Detail Page)
     */
    public function show(Product $product): View
    {
        if ($product->status !== 1) {
            abort(404);
        }

        $product->load(['category', 'manufacturer', 'images', 'specs']);

        // Get related products (same category)
        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->limit(6)
            ->get();

        return view('products.show', compact('product', 'related'));
    }

    /**
     * API endpoint for search (AJAX)
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
            'limit' => 'integer|min:1|max:50',
        ]);

        $term = $request->string('q');
        $limit = $request->integer('limit', 10);

        $products = Product::active()
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            })
            ->with('images')
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $product->images->where('is_primary', true)->first()?->url,
                ];
            });

        return response()->json($products);
    }
}
