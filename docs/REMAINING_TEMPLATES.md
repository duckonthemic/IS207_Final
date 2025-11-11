# Remaining Templates - Implementation Checklist

## 5 Quick-Win Templates (Est. 30 mins total)

### 1. `resources/views/orders/show.blade.php`
**Purpose**: Show user's individual order details with items and tracking
**Dependencies**: Order model with items relationship

```blade
@extends('layouts.app')
@section('title', 'Đơn hàng ' . $order->order_code)

<div class="container mx-auto px-4 py-8">
    <a href="{{ route('orders.index') }}" class="text-cyber-accent mb-8">← Quay lại</a>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            {{-- Order Header --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold text-cyber-text mb-4">{{ $order->order_code }}</h1>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-cyber-muted text-sm">Ngày đặt</p>
                        <p class="text-cyber-text font-semibold">{{ $order->placed_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-cyber-muted text-sm">Trạng thái</p>
                        <span class="px-3 py-1 rounded text-xs font-bold @if($order->status === 'pending') bg-cyber-muted/20 text-cyber-muted @elseif($order->status === 'paid') bg-cyber-success/20 text-cyber-success @elseif($order->status === 'shipped') bg-cyber-accent/20 text-cyber-accent @elseif($order->status === 'delivered') bg-cyber-success/20 text-cyber-success @else bg-cyber-error/20 text-cyber-error @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-cyber-muted text-sm">Thanh toán</p>
                        <span class="px-3 py-1 rounded text-xs font-bold @if($order->payment_status === 'pending') bg-cyber-muted/20 text-cyber-muted @else bg-cyber-success/20 text-cyber-success @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Sản phẩm</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-cyber-border/30 last:border-0">
                            <img src="{{ $item->product->images->first()?->url ?? '#' }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <p class="font-semibold text-cyber-text">{{ $item->product->name }}</p>
                                <p class="text-cyber-muted text-sm">x{{ $item->qty }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-cyber-accent font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}₫</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Địa chỉ giao hàng</h2>
                <p class="text-cyber-text font-semibold">{{ $order->address->full_name }}</p>
                <p class="text-cyber-muted">{{ $order->address->phone_number }}</p>
                <p class="text-cyber-muted">{{ $order->address->street }} {{ $order->address->ward }}</p>
                <p class="text-cyber-muted">{{ $order->address->district }}, {{ $order->address->province }}</p>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 sticky top-20">
                <h3 class="font-bold text-cyber-text mb-4">Tóm tắt</h3>
                <div class="space-y-3 mb-4 pb-4 border-b border-cyber-border">
                    <div class="flex justify-between text-cyber-muted">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}₫</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-cyber-success">
                            <span>Giảm giá:</span>
                            <span>-{{ number_format($order->discount, 0, ',', '.') }}₫</span>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between font-bold text-cyber-accent mb-6">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($order->total - $order->discount, 0, ',', '.') }}₫</span>
                </div>

                @if($order->status !== 'cancelled' && $order->status !== 'delivered')
                    <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-4 py-2 border border-cyber-error text-cyber-error rounded hover:bg-cyber-error/10">
                            Hủy đơn hàng
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
```

---

### 2. `resources/views/admin/products/index.blade.php`
**Purpose**: Admin product list with search, pagination, CRUD actions
**Dependencies**: Product model, Admin/ProductController

```blade
@extends('layouts.app')
@section('title', 'Quản lý sản phẩm - Admin')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-cyber-text">Quản lý sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded-lg font-bold hover:shadow-glow-cyan">
            + Thêm sản phẩm
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-cyber-card border border-cyber-border rounded-lg p-4 mb-6">
        <form method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." value="{{ request('search') }}" class="flex-1 px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text">
            <select name="category" class="px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded font-bold">Tìm</button>
        </form>
    </div>

    {{-- Products Table --}}
    <div class="bg-cyber-card border border-cyber-border rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-cyber-darker/50 border-b border-cyber-border">
                <tr>
                    <th class="text-left px-6 py-3 text-cyber-muted">Tên</th>
                    <th class="text-left px-6 py-3 text-cyber-muted">SKU</th>
                    <th class="text-left px-6 py-3 text-cyber-muted">Danh mục</th>
                    <th class="text-right px-6 py-3 text-cyber-muted">Giá</th>
                    <th class="text-center px-6 py-3 text-cyber-muted">Trạng thái</th>
                    <th class="text-center px-6 py-3 text-cyber-muted">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-cyber-border/30 hover:bg-cyber-darker/30">
                        <td class="px-6 py-4 text-cyber-text">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-cyber-muted">{{ $product->sku }}</td>
                        <td class="px-6 py-4 text-cyber-muted">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-right text-cyber-accent font-semibold">{{ number_format($product->price, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $product->status ? 'bg-cyber-success/20 text-cyber-success' : 'bg-cyber-error/20 text-cyber-error' }}">
                                {{ $product->status ? 'Kích hoạt' : 'Tắt' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-cyber-accent hover:text-cyber-glow text-sm">Sửa</a>
                            <span class="mx-2 text-cyber-border">|</span>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Bạn chắc chắn?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-cyber-error hover:text-cyber-error/80 text-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-cyber-muted">Không tìm thấy sản phẩm</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links('pagination::tailwind') }}
    </div>
</div>
@endsection
```

---

### 3. `resources/views/admin/products/edit.blade.php`
**Purpose**: Edit existing product
**Dependencies**: Same as create + product instance pre-filled

```blade
@extends('layouts.app')
@section('title', 'Sửa sản phẩm - Admin')

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">Sửa sản phẩm</h1>
        <a href="{{ route('admin.products.index') }}" class="text-cyber-accent hover:text-cyber-glow">← Quay lại danh sách</a>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="max-w-2xl">
        @csrf
        @method('PATCH')

        {{-- Name --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
            @error('name') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
            @error('slug') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Category & Manufacturer --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-cyber-text font-semibold mb-2">Danh mục</label>
                <select name="category_id" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-cyber-text font-semibold mb-2">Nhà sản xuất</label>
                <select name="manufacturer_id" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                    <option value="">-- Chọn nhà sản xuất --</option>
                    @foreach($manufacturers as $mfr)
                        <option value="{{ $mfr->id }}" {{ old('manufacturer_id', $product->manufacturer_id) == $mfr->id ? 'selected' : '' }}>{{ $mfr->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Price --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-cyber-text font-semibold mb-2">Giá</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none" required>
            </div>
            <div>
                <label class="block text-cyber-text font-semibold mb-2">Giá sale</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
            </div>
        </div>

        {{-- Current Images --}}
        @if($product->images->isNotEmpty())
            <div class="mb-6">
                <label class="block text-cyber-text font-semibold mb-2">Hình ảnh hiện tại</label>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                        <div class="relative">
                            <img src="{{ $image->url }}" class="w-full aspect-square object-cover rounded border border-cyber-border">
                            <form method="POST" action="{{ route('admin.products.remove-image', $image) }}" class="absolute top-1 right-1">
                                @csrf
                                <button type="submit" class="p-1 bg-cyber-error text-cyber-darker rounded text-xs">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- New Images --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Thêm hình ảnh</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text">
            @error('images') <span class="text-cyber-error text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Description --}}
        <div class="mb-6">
            <label class="block text-cyber-text font-semibold mb-2">Mô tả</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 bg-cyber-card border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Status --}}
        <div class="mb-8">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }} class="rounded">
                <span class="text-cyber-text font-semibold">Kích hoạt</span>
            </label>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded-lg font-bold hover:shadow-glow-cyan transition-all">
                Cập nhật
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border border-cyber-border text-cyber-text rounded-lg hover:border-cyber-accent transition-all">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
```

---

### 4. `resources/views/admin/orders/index.blade.php`
**Purpose**: Admin order management list
**Dependencies**: Order model, Admin/OrderController

```blade
@extends('layouts.app')
@section('title', 'Quản lý đơn hàng - Admin')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-cyber-text mb-8">Quản lý đơn hàng</h1>

    {{-- Filters --}}
    <div class="bg-cyber-card border border-cyber-border rounded-lg p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" placeholder="Tìm mã đơn..." value="{{ request('search') }}" class="px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text">
            
            <select name="status" class="px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Đã gửi</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Đã giao</option>
            </select>

            <button type="submit" class="px-6 py-2 bg-cyber-accent text-cyber-darker rounded font-bold">Tìm</button>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-cyber-card border border-cyber-border rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-cyber-darker/50 border-b border-cyber-border">
                <tr>
                    <th class="text-left px-6 py-3 text-cyber-muted">Mã đơn</th>
                    <th class="text-left px-6 py-3 text-cyber-muted">Khách hàng</th>
                    <th class="text-right px-6 py-3 text-cyber-muted">Tổng tiền</th>
                    <th class="text-center px-6 py-3 text-cyber-muted">Thanh toán</th>
                    <th class="text-center px-6 py-3 text-cyber-muted">Trạng thái</th>
                    <th class="text-center px-6 py-3 text-cyber-muted">Ngày</th>
                    <th class="text-center px-6 py-3 text-cyber-muted">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-cyber-border/30 hover:bg-cyber-darker/30">
                        <td class="px-6 py-4 text-cyber-accent font-semibold">{{ $order->order_code }}</td>
                        <td class="px-6 py-4 text-cyber-text">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 text-right text-cyber-accent font-semibold">{{ number_format($order->total, 0, ',', '.') }}₫</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-cyber-success/20 text-cyber-success' : 'bg-cyber-muted/20 text-cyber-muted' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded text-xs font-bold @if($order->status === 'pending') bg-cyber-muted/20 text-cyber-muted @elseif($order->status === 'paid') bg-cyber-success/20 text-cyber-success @elseif($order->status === 'shipped') bg-cyber-accent/20 text-cyber-accent @else bg-cyber-error/20 text-cyber-error @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-cyber-muted">{{ $order->placed_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-cyber-accent hover:text-cyber-glow text-sm">Chi tiết</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-cyber-muted">Không có đơn hàng</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $orders->links('pagination::tailwind') }}
    </div>
</div>
@endsection
```

---

### 5. `resources/views/admin/orders/show.blade.php`
**Purpose**: Admin view to update order status
**Dependencies**: Order model, Admin/OrderController update method

```blade
@extends('layouts.app')
@section('title', 'Chi tiết đơn hàng - Admin')

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyber-text mb-2">{{ $order->order_code }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-cyber-accent hover:text-cyber-glow">← Quay lại danh sách</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            {{-- Order Items --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Sản phẩm đã đặt</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-cyber-border">
                            <tr>
                                <th class="text-left px-3 py-2 text-cyber-muted">Sản phẩm</th>
                                <th class="text-center px-3 py-2 text-cyber-muted">Số lượng</th>
                                <th class="text-right px-3 py-2 text-cyber-muted">Giá</th>
                                <th class="text-right px-3 py-2 text-cyber-muted">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="border-b border-cyber-border/30">
                                    <td class="px-3 py-3 text-cyber-text">{{ $item->product->name }}</td>
                                    <td class="text-center px-3 py-3 text-cyber-muted">{{ $item->qty }}</td>
                                    <td class="text-right px-3 py-3 text-cyber-accent">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                    <td class="text-right px-3 py-3 text-cyber-accent font-bold">{{ number_format($item->subtotal, 0, ',', '.') }}₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-cyber-card border border-cyber-border rounded-lg p-6">
                <h2 class="text-xl font-bold text-cyber-text mb-4">Địa chỉ giao hàng</h2>
                <p class="text-cyber-text font-semibold">{{ $order->address->full_name }}</p>
                <p class="text-cyber-muted text-sm">{{ $order->address->phone_number }}</p>
                <p class="text-cyber-muted text-sm">{{ $order->address->street }} {{ $order->address->ward }}</p>
                <p class="text-cyber-muted text-sm">{{ $order->address->district }}, {{ $order->address->province }}</p>
            </div>
        </div>

        {{-- Status Update Form --}}
        <div class="lg:col-span-1">
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="bg-cyber-card border border-cyber-border rounded-lg p-6 space-y-4">
                @csrf
                @method('PATCH')

                {{-- Order Status --}}
                <div>
                    <label class="block text-cyber-text font-semibold mb-2">Trạng thái đơn hàng</label>
                    <select name="status" class="w-full px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Đã gửi</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                {{-- Payment Status --}}
                <div>
                    <label class="block text-cyber-text font-semibold mb-2">Thanh toán</label>
                    <select name="payment_status" class="w-full px-4 py-2 bg-cyber-darker border border-cyber-border rounded text-cyber-text focus:border-cyber-accent outline-none">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Chưa thanh toán</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Thất bại</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                    </select>
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-cyber-accent text-cyber-darker rounded font-bold hover:shadow-glow-cyan">
                    Cập nhật
                </button>

                {{-- Summary --}}
                <div class="border-t border-cyber-border pt-4 mt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-cyber-muted">Tạm tính:</span>
                        <span class="text-cyber-text">{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}₫</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between mb-2">
                            <span class="text-cyber-muted">Giảm giá:</span>
                            <span class="text-cyber-success">-{{ number_format($order->discount, 0, ',', '.') }}₫</span>
                        </div>
                    @endif
                    <div class="flex justify-between font-bold text-cyber-accent border-t border-cyber-border pt-2 mt-2">
                        <span>Tổng:</span>
                        <span>{{ number_format($order->total - $order->discount, 0, ',', '.') }}₫</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
```

---

## Implementation Priority

1. **orders/show.blade.php** - Needed for user to view order details
2. **admin/products/index.blade.php** - Core admin feature
3. **admin/products/edit.blade.php** - Enables product editing
4. **admin/orders/index.blade.php** - Core admin feature
5. **admin/orders/show.blade.php** - Admin status management

All follow same dark cyber design system as completed templates.

Estimated total time to implement: **30-40 minutes** using copy-paste approach.
