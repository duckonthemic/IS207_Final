<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart.items', []);

        $total = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0.0);

        return view('cart.index', [
            'items' => $cart,
            'total' => $total,
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $qty = (int) ($validated['quantity'] ?? 1);

        $cart = $request->session()->get('cart.items', []);
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => (float) $product->price,
                'quantity'   => $qty,
                'image'      => $product->image,
                'slug'       => $product->slug,
            ];
        }

        $request->session()->put('cart.items', $cart);

        return back()->with('success', 'Đã thêm vào giỏ hàng.');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:0'],
        ]);

        $cart = $request->session()->get('cart.items', []);
        $key = (string) $validated['product_id'];

        if (isset($cart[$key])) {
            if ((int) $validated['quantity'] === 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = (int) $validated['quantity'];
            }
            $request->session()->put('cart.items', $cart);
        }

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $cart = $request->session()->get('cart.items', []);
        $key = (string) $validated['product_id'];

        if (isset($cart[$key])) {
            unset($cart[$key]);
            $request->session()->put('cart.items', $cart);
        }

        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ.');
    }
}
