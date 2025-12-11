<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Shipping methods configuration
     */
    protected $shippingMethods = [
        'standard' => [
            'name' => 'Giao hàng tiêu chuẩn',
            'description' => '3-5 ngày làm việc',
            'fee_hcm_hn' => 30000,
            'fee_other' => 50000,
        ],
        'express' => [
            'name' => 'Giao hàng nhanh',
            'description' => '1-2 ngày làm việc',
            'fee_hcm_hn' => 50000,
            'fee_other' => 80000,
        ],
        'same_day' => [
            'name' => 'Giao trong ngày',
            'description' => 'Nhận hàng trong ngày (trước 15h)',
            'fee_hcm_hn' => 100000,
            'fee_other' => null, // Not available
        ],
    ];

    protected $freeShippingThreshold = 2000000;

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

        // Get coupon from session
        $coupon = null;
        $discount = 0;
        if (session()->has('coupon_code')) {
            $coupon = Promotion::where('code', session('coupon_code'))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                session()->forget(['coupon_code', 'coupon_discount']);
            }
        }

        // Shipping - default to standard for HCM
        $shippingFee = 0;
        $selectedShipping = session('shipping_method', 'standard');
        $selectedCity = session('shipping_city', 'Hồ Chí Minh');

        // Check if free shipping applies
        $freeShipping = $subtotal >= $this->freeShippingThreshold;

        if (!$freeShipping) {
            $shippingFee = $this->calculateShippingFee($selectedShipping, $selectedCity);
        }

        $total = $subtotal - $discount + $shippingFee;

        // Get shipping methods for display
        $shippingMethods = $this->getShippingMethodsForCity($selectedCity, $subtotal);

        return view('checkout.index', compact(
            'cart',
            'user',
            'addresses',
            'defaultAddress',
            'subtotal',
            'shippingFee',
            'total',
            'coupon',
            'discount',
            'shippingMethods',
            'selectedShipping',
            'freeShipping'
        ));
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->coupon_code));
        $coupon = Promotion::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại'
            ], 404);
        }

        if (!$coupon->isValid()) {
            $status = $coupon->status;
            $messages = [
                'expired' => 'Mã giảm giá đã hết hạn',
                'exhausted' => 'Mã giảm giá đã hết lượt sử dụng',
                'inactive' => 'Mã giảm giá không hoạt động',
                'scheduled' => 'Mã giảm giá chưa có hiệu lực',
            ];
            return response()->json([
                'success' => false,
                'message' => $messages[$status] ?? 'Mã giảm giá không hợp lệ'
            ], 400);
        }

        // Check if user can use this coupon
        if (!$coupon->canBeUsedBy(Auth::id())) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng hết lượt cho mã này'
            ], 400);
        }

        // Calculate discount
        $cart = Auth::user()->getActiveCart();
        $subtotal = $cart ? $cart->getTotal() : 0;

        if ($coupon->min_order_value && $subtotal < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng tối thiểu ' . number_format((float) $coupon->min_order_value, 0, ',', '.') . '₫ để sử dụng mã này'
            ], 400);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        // Store in session
        session([
            'coupon_code' => $coupon->code,
            'coupon_discount' => $discount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'coupon' => [
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'formatted_value' => $coupon->formatted_value,
            ],
            'discount' => $discount,
            'formatted_discount' => number_format($discount, 0, ',', '.') . '₫',
        ]);
    }

    /**
     * Remove coupon code
     */
    public function removeCoupon()
    {
        session()->forget(['coupon_code', 'coupon_discount']);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa mã giảm giá'
        ]);
    }

    /**
     * Get shipping methods based on city
     */
    public function getShippingMethodsApi(Request $request)
    {
        $city = $request->input('city', 'Hồ Chí Minh');
        $cart = Auth::user()->getActiveCart();
        $subtotal = $cart ? $cart->getTotal() : 0;

        session(['shipping_city' => $city]);

        $methods = $this->getShippingMethodsForCity($city, $subtotal);
        $freeShipping = $subtotal >= $this->freeShippingThreshold;

        return response()->json([
            'success' => true,
            'methods' => $methods,
            'free_shipping' => $freeShipping,
            'free_shipping_threshold' => $this->freeShippingThreshold,
        ]);
    }

    /**
     * Update selected shipping method
     */
    public function updateShipping(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|in:standard,express,same_day',
        ]);

        session(['shipping_method' => $request->shipping_method]);

        $cart = Auth::user()->getActiveCart();
        $subtotal = $cart ? $cart->getTotal() : 0;
        $city = session('shipping_city', 'Hồ Chí Minh');

        $freeShipping = $subtotal >= $this->freeShippingThreshold;
        $shippingFee = $freeShipping ? 0 : $this->calculateShippingFee($request->shipping_method, $city);

        return response()->json([
            'success' => true,
            'shipping_fee' => $shippingFee,
            'formatted_shipping_fee' => $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . '₫' : 'Miễn phí',
        ]);
    }

    protected function getShippingMethodsForCity($city, $subtotal)
    {
        $isMainCity = in_array($city, ['Hồ Chí Minh', 'Hà Nội']);
        $freeShipping = $subtotal >= $this->freeShippingThreshold;

        $methods = [];
        foreach ($this->shippingMethods as $key => $method) {
            $fee = $isMainCity ? $method['fee_hcm_hn'] : $method['fee_other'];

            // Skip if not available for this city
            if ($fee === null)
                continue;

            $methods[] = [
                'id' => $key,
                'name' => $method['name'],
                'description' => $method['description'],
                'fee' => $freeShipping ? 0 : $fee,
                'original_fee' => $fee,
                'formatted_fee' => $freeShipping ? 'Miễn phí' : number_format($fee, 0, ',', '.') . '₫',
            ];
        }

        return $methods;
    }

    protected function calculateShippingFee($method, $city)
    {
        $isMainCity = in_array($city, ['Hồ Chí Minh', 'Hà Nội']);
        $shippingMethod = $this->shippingMethods[$method] ?? $this->shippingMethods['standard'];

        return $isMainCity ? $shippingMethod['fee_hcm_hn'] : ($shippingMethod['fee_other'] ?? $shippingMethod['fee_hcm_hn']);
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
            'shipping_method' => 'required|in:standard,express,same_day',
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
            $subtotal = $cart->getTotal();

            // Calculate shipping fee
            $freeShipping = $subtotal >= $this->freeShippingThreshold;
            $shippingFee = $freeShipping ? 0 : $this->calculateShippingFee($request->shipping_method, $request->city);

            // Apply coupon if exists
            $discount = 0;
            $coupon = null;
            if (session()->has('coupon_code')) {
                $coupon = Promotion::where('code', session('coupon_code'))->first();
                if ($coupon && $coupon->isValid() && $coupon->canBeUsedBy(Auth::id())) {
                    $discount = $coupon->calculateDiscount($subtotal);
                }
            }

            $total = $subtotal - $discount + $shippingFee;

            // Determine payment status based on method
            // Online payments (atm, bank_transfer, fundiin) are simulated and marked as paid
            $onlinePaymentMethods = ['atm', 'bank_transfer', 'fundiin'];
            $paymentStatus = in_array($request->payment_method, $onlinePaymentMethods) ? 'paid' : 'pending';

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $this->generateOrderCode(),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'placed_at' => now(),
                'shipping_name' => $request->fullname,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address . ($request->ward ? ', ' . $request->ward : '') . ', ' . $request->district,
                'shipping_city' => $request->city,
                'shipping_method' => $request->shipping_method,
            ]);

            // Attach promotion to order
            if ($coupon) {
                $order->promotions()->attach($coupon->id, [
                    'code' => $coupon->code,
                    'discount_value' => $discount,
                ]);
                $coupon->incrementUsage();
            }

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
            session()->forget(['coupon_code', 'coupon_discount', 'shipping_method', 'shipping_city']);

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
    public function shipping()
    {
        return redirect()->route('checkout.index');
    }
    public function payment()
    {
        return redirect()->route('checkout.index');
    }
    public function review()
    {
        return redirect()->route('checkout.index');
    }
    public function storeShipping()
    {
        return redirect()->route('checkout.index');
    }
    public function storePayment()
    {
        return redirect()->route('checkout.index');
    }
}
