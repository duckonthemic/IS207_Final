<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        // Check if user has purchased this product
        $hasPurchased = OrderItem::whereHas('order', function($query) {
            $query->where('user_id', Auth::id())
                  ->whereIn('status', ['delivered', 'completed']);
        })->where('product_id', $product->id)->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn cần mua sản phẩm này trước khi đánh giá!');
        }

        // Check if already reviewed
        $existingReview = ProductReview::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        ProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $validated['order_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'pending', // Wait for admin approval
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn sẽ được hiển thị sau khi được duyệt.');
    }

    public function update(Request $request, ProductReview $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Đánh giá đã được cập nhật!');
    }

    public function destroy(ProductReview $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Đánh giá đã được xóa!');
    }
}
