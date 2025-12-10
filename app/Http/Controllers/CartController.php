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
        $cart->load('items.product.images');

        return view('cart.index', compact('cart'));
    }

    /**
     * Add product to cart (AJAX or form)
     */
    public function add(Request $request, Product $product): mixed
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if (!$product || !$product->is_active) {
            return $this->errorResponse('Sản phẩm không tồn tại hoặc ngừng kinh doanh', 404);
        }

        $cart = auth()->user()->getOrCreateActiveCart();
        $qty = $request->integer('quantity', 1);

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

        // If action is "buy_now", redirect to checkout instead of cart
        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout.index')->with('success', 'Đã thêm vào giỏ hàng');
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem): mixed
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:100',
        ]);

        if ($cartItem->cart->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        // Check product stock
        if ($request->integer('qty') > $cartItem->product->stock) {
            return $this->errorResponse('Số lượng vượt quá tồn kho (còn ' . $cartItem->product->stock . ')', 400);
        }

        $cartItem->update(['qty' => $request->integer('qty')]);

        $cart = auth()->user()->getActiveCart();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng',
                'cart_total' => $cart->getTotal(),
                'item_count' => $cart->getItemCount(),
                'subtotal' => $cartItem->subtotal,
            ]);
        }

        return back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove product from cart
     */
    public function destroy(Request $request, CartItem $cartItem): mixed
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $cartItem->delete();

        $cart = auth()->user()->getActiveCart();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa khỏi giỏ hàng',
                'cart_total' => $cart ? $cart->getTotal() : 0,
                'item_count' => $cart ? $cart->getItemCount() : 0,
            ]);
        }

        return back()->with('success', 'Đã xóa khỏi giỏ hàng');
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request): mixed
    {
        $cart = auth()->user()->getActiveCart();
        if ($cart) {
            $cart->items()->delete();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa toàn bộ giỏ hàng',
            ]);
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
