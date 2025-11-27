<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đơn hàng</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #000; color: #fff; padding: 20px; text-align: center; }
        .order-details { margin: 20px 0; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { font-weight: bold; text-align: right; margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cảm ơn bạn đã đặt hàng!</h1>
        </div>
        
        <p>Xin chào {{ $order->shipping_name }},</p>
        <p>Đơn hàng #{{ $order->id }} của bạn đã được đặt thành công.</p>
        
        <div class="order-details">
            <h3>Chi tiết đơn hàng</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="total">
                <p>Tổng tiền: {{ number_format($order->total, 0, ',', '.') }}₫</p>
            </div>
        </div>
        
        <div class="shipping-info">
            <h3>Thông tin giao hàng</h3>
            <p>
                <strong>Người nhận:</strong> {{ $order->shipping_name }}<br>
                <strong>Điện thoại:</strong> {{ $order->shipping_phone }}<br>
                <strong>Địa chỉ:</strong> {{ $order->shipping_address }}
            </p>
        </div>
        
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            <p>&copy; {{ date('Y') }} Tech Parts E-Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
