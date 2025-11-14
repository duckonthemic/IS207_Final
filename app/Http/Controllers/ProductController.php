<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by category (supports both ID and slug)
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->string('category'))
                ->orWhere('id', $request->input('category'))
                ->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        } elseif ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        // Price range filter
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->string('price_range'));
            $query->whereBetween('price', [(float)$min, (float)$max]);
        } elseif ($request->filled('min_price') || $request->filled('max_price')) {
            // Individual min/max price filters
            if ($request->filled('min_price')) {
                $query->where('price', '>=', (float) $request->input('min_price'));
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', (float) $request->input('max_price'));
            }
        }

        // Brand filter (for VGA, CPU, Monitor, etc.)
        if ($request->filled('brand')) {
            $brands = $request->input('brand');
            $query->where(function($q) use ($brands) {
                foreach ((array)$brands as $brand) {
                    $q->orWhere('name', 'like', "%{$brand}%")
                      ->orWhere('brand', 'like', "%{$brand}%")
                      ->orWhere('specifications', 'like', "%{$brand}%");
                }
            });
        }

        // Socket filter (for CPU)
        if ($request->filled('socket')) {
            $sockets = $request->input('socket');
            $query->where(function($q) use ($sockets) {
                foreach ((array)$sockets as $socket) {
                    $q->orWhere('name', 'like', "%{$socket}%")
                      ->orWhere('specifications', 'like', "%{$socket}%");
                }
            });
        }

        // Series filter (for VGA)
        if ($request->filled('series')) {
            $series = $request->input('series');
            $query->where(function($q) use ($series) {
                foreach ((array)$series as $serie) {
                    $q->orWhere('name', 'like', "%{$serie}%")
                      ->orWhere('specifications', 'like', "%{$serie}%");
                }
            });
        }

        // VRAM filter (for VGA)
        if ($request->filled('vram')) {
            $vrams = $request->input('vram');
            $query->where(function($q) use ($vrams) {
                foreach ((array)$vrams as $vram) {
                    $q->orWhere('name', 'like', "%{$vram}%")
                      ->orWhere('specifications', 'like', "%{$vram}%");
                }
            });
        }

        // Size filter (for Monitor)
        if ($request->filled('size')) {
            $sizes = $request->input('size');
            $query->where(function($q) use ($sizes) {
                foreach ((array)$sizes as $size) {
                    $q->orWhere('name', 'like', "%{$size}%")
                      ->orWhere('specifications', 'like', "%{$size}%");
                }
            });
        }

        // Resolution filter (for Monitor)
        if ($request->filled('resolution')) {
            $resolutions = $request->input('resolution');
            $query->where(function($q) use ($resolutions) {
                foreach ((array)$resolutions as $resolution) {
                    $q->orWhere('name', 'like', "%{$resolution}%")
                      ->orWhere('specifications', 'like', "%{$resolution}%");
                }
            });
        }

        // Refresh rate filter (for Monitor)
        if ($request->filled('refresh')) {
            $refreshRates = $request->input('refresh');
            $query->where(function($q) use ($refreshRates) {
                foreach ((array)$refreshRates as $refresh) {
                    $q->orWhere('name', 'like', "%{$refresh}%")
                      ->orWhere('specifications', 'like', "%{$refresh}%");
                }
            });
        }

        // RAM type filter (DDR4/DDR5)
        if ($request->filled('type')) {
            $types = $request->input('type');
            $query->where(function($q) use ($types) {
                foreach ((array)$types as $type) {
                    $q->orWhere('name', 'like', "%{$type}%")
                      ->orWhere('specifications', 'like', "%{$type}%");
                }
            });
        }

        // Capacity filter (for RAM, SSD)
        if ($request->filled('capacity')) {
            $capacities = $request->input('capacity');
            $query->where(function($q) use ($capacities) {
                foreach ((array)$capacities as $capacity) {
                    $q->orWhere('name', 'like', "%{$capacity}%")
                      ->orWhere('specifications', 'like', "%{$capacity}%");
                }
            });
        }

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

        $products = $query->paginate($perPage)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a single product detail page
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'approvedReviews.user']);

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
}
