<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['user', 'product'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, ProductReview $review)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update(['status' => $validated['status']]);

        return back()->with('success', 'Trạng thái đánh giá đã được cập nhật!');
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();
        return back()->with('success', 'Đánh giá đã được xóa!');
    }
}
