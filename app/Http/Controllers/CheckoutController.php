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
     * Redirect to first checkout step
     */
    public function index()
    {
        $cart = Auth::user()->getActiveCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        return redirect()->route('checkout.shipping');
    }

    /**
     * Shipping address selection
     */
    public function shipping()
    {
        $cart = Auth::user()->getActiveCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cart->load('items.product');
        $addresses = Auth::user()->addresses()->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        return view('checkout.shipping', compact('cart', 'addresses', 'defaultAddress'));
    }

    /**
     * Store shipping address and proceed to payment
     */
    public function storeShipping(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        // Verify address belongs to user
        $address = Auth::user()->addresses()->findOrFail($request->address_id);

        // Store in session
        session(['checkout.address_id' => $address->id]);

        return redirect()->route('checkout.payment');
    }

    /**
     * Payment method selection
     */
    public function payment()
    {
        if (!session('checkout.address_id')) {
            return redirect()->route('checkout.shipping')->with('error', 'Vui lòng chọn địa chỉ giao hàng');
        }

        $cart = Auth::user()->getActiveCart();
        $cart->load('items.product');
        $address = Auth::user()->addresses()->findOrFail(session('checkout.address_id'));

        return view('checkout.payment', compact('cart', 'address'));
    }

    /**
     * Store payment method and proceed to review
     */
    public function storePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,bank_transfer',
        ]);

        session(['checkout.payment_method' => $request->payment_method]);

        return redirect()->route('checkout.review');
    }

    /**
     * Review order before placing
     */
    public function review()
    {
        if (!session('checkout.address_id') || !session('checkout.payment_method')) {
            return redirect()->route('checkout.shipping')->with('error', 'Vui lòng hoàn thành các bước trước');
        }

        $cart = Auth::user()->getActiveCart();
        $cart->load('items.product');
        $address = Auth::user()->addresses()->findOrFail(session('checkout.address_id'));
        $paymentMethod = session('checkout.payment_method');
        
        // Calculate totals
        $subtotal = $cart->getTotal();
        $shippingFee = 30000; // Fixed shipping fee
        $total = $subtotal + $shippingFee;

        return view('checkout.review', compact('cart', 'address', 'paymentMethod', 'subtotal', 'shippingFee', 'total'));
    }

    /**
     * Place the order
     */
    public function placeOrder(Request $request)
    {
        if (!session('checkout.address_id') || !session('checkout.payment_method')) {
            return redirect()->route('checkout.shipping')->with('error', 'Vui lòng hoàn thành các bước trước');
        }

        $cart = Auth::user()->getActiveCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cart->load('items.product');

        // Verify stock for all items
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->qty) {
                return back()->with('error', "Sản phẩm {$item->product->name} không đủ hàng trong kho");
            }
        }

        DB::beginTransaction();
        
        try {
            $address = Auth::user()->addresses()->findOrFail(session('checkout.address_id'));
            $shippingFee = 30000;
            $subtotal = $cart->getTotal();
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $this->generateOrderCode(),
                'status' => 'pending',
                'payment_method' => session('checkout.payment_method'),
                'payment_status' => 'pending',
                'total' => $subtotal + $shippingFee,
                'placed_at' => now(),
                'shipping_name' => $address->fullname,
                'shipping_phone' => $address->phone,
                'shipping_address' => $address->address . ', ' . $address->ward . ', ' . $address->district,
                'shipping_city' => $address->city,
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

            // Clear session
            session()->forget(['checkout.address_id', 'checkout.payment_method']);

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
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . date('Ymd') . '-' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
