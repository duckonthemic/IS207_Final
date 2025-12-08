<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $request->input('email');

        // Check if already subscribed
        $existing = NewsletterSubscriber::where('email', $email)->first();

        if ($existing) {
            if ($existing->is_active) {
                return $this->response($request, 'Email này đã được đăng ký nhận tin.', 'info');
            }

            // Reactivate subscription
            $existing->update([
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);

            return $this->response($request, 'Bạn đã đăng ký lại thành công!', 'success');
        }

        // Create new subscription
        NewsletterSubscriber::create([
            'email' => $email,
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        return $this->response($request, 'Cảm ơn bạn đã đăng ký nhận tin tức từ UITech!', 'success');
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $request->input('email'))->first();

        if (!$subscriber || !$subscriber->is_active) {
            return $this->response($request, 'Email này chưa được đăng ký.', 'error');
        }

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return $this->response($request, 'Bạn đã hủy đăng ký nhận tin thành công.', 'success');
    }

    /**
     * Helper to return response based on request type
     */
    private function response(Request $request, string $message, string $type)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => $type === 'success',
                'message' => $message,
                'type' => $type,
            ]);
        }

        return back()->with($type, $message);
    }
}
