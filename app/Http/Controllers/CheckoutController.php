<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index()
    {
        $cart = Auth::user()->getActiveCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cart->load('items.product.images');
        $user = Auth::user();
        $addresses = $user->addresses()->get();
        $defaultAddress = $addresses->where('is_default', true)->first();
        
        // Calculate totals
        $subtotal = $cart->getTotal();
        $shippingFee = 0; // Free shipping as per image "Báo phí sau" or logic
        
        $total = $subtotal + $shippingFee;

        return view('checkout.index', compact('cart', 'user', 'addresses', 'defaultAddress', 'subtotal', 'shippingFee', 'total'));
    }

    /**
     * Place the order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cod,bank_transfer,atm,fundiin,payoo',
        ]);

        $cart = Auth::user()->getActiveCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cart->load('items.product');

        // Verify stock
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->qty) {
                return back()->with('error', "Sản phẩm {$item->product->name} không đủ hàng trong kho");
            }
        }

        DB::beginTransaction();
        
        try {
            $shippingFee = 0; 
            $subtotal = $cart->getTotal();
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $this->generateOrderCode(),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'total' => $subtotal + $shippingFee,
                'placed_at' => now(),
                'shipping_name' => $request->fullname,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address . ($request->ward ? ', ' . $request->ward : '') . ', ' . $request->district,
                'shipping_city' => $request->city,
            ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'qty' => $item->qty,
                ]);

                // Reduce product stock
                $item->product->decrement('stock', $item->qty);
            }

            // Mark cart as ordered
            $cart->update(['status' => 'ordered']);

            DB::commit();

            // Send email
            try {
                Mail::to(Auth::user()->email)->send(new OrderPlaced($order));
            } catch (\Exception $e) {
                Log::error('Failed to send order email: ' . $e->getMessage());
            }

            return redirect()->route('orders.show', $order)->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->order_code);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại. ' . $e->getMessage());
        }
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . date('Ymd') . '-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }

    // Redirect legacy routes to index
    public function shipping() { return redirect()->route('checkout.index'); }
    public function payment() { return redirect()->route('checkout.index'); }
    public function review() { return redirect()->route('checkout.index'); }
    public function storeShipping() { return redirect()->route('checkout.index'); }
    public function storePayment() { return redirect()->route('checkout.index'); }
}
