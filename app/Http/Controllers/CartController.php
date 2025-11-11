<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index(): View
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    /**
     * Add product to cart (AJAX or form)
     */
    public function add(Request $request): mixed
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1|max:100',
        ]);

        $product = Product::find($request->product_id);
        if (!$product || $product->status !== 1) {
            return $this->errorResponse('Sản phẩm không tồn tại', 404);
        }

        $cart = auth()->user()->getOrCreateActiveCart();
        $qty = $request->integer('qty', 1);

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQty = $cartItem->qty + $qty;
            $cartItem->update(['qty' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'price' => $product->getDisplayPrice(),
                'qty' => $qty,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_total' => $cart->getTotal(),
                'item_count' => $cart->getItemCount(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request): mixed
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'qty' => 'required|integer|min:1|max:100',
        ]);

        $cartItem = CartItem::find($request->cart_item_id);
        if ($cartItem->cart->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $cartItem->update(['qty' => $request->integer('qty')]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'subtotal' => $cartItem->subtotal,
            ]);
        }

        return back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove product from cart
     */
    public function remove(Request $request): mixed
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        $cartItem = CartItem::find($request->cart_item_id);
        if ($cartItem->cart->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $cartItem->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Đã xóa khỏi giỏ hàng');
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request): RedirectResponse
    {
        $cart = auth()->user()->getActiveCart();
        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with('success', 'Đã xóa giỏ hàng');
    }

    private function errorResponse($message, $status = 400)
    {
        if (request()->expectsJson()) {
            return response()->json(['error' => $message], $status);
        }
        return back()->withErrors(['error' => $message]);
    }
}
