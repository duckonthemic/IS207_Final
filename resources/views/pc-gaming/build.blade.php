@extends('layouts.app')

@section('title', 'Build PC - Tự lắp ráp PC theo sở thích')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                    Trang chủ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-500">Build PC</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Build PC - Tự Lắp Ráp PC Theo Sở Thích</h1>
        <p class="text-gray-600">Chọn từng linh kiện để tạo nên bộ PC hoàn hảo cho riêng bạn</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Build List -->
        <div class="lg:col-span-2 space-y-4">
            <div x-data="pcBuilder()">
                <!-- CPU -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">CPU - Bộ Xử Lý</h3>
                        <span class="text-red-600 text-sm">*Bắt buộc</span>
                    </div>
                    @if(isset($products['cpu-processor']) && $products['cpu-processor']->count() > 0)
                        <select x-model="selectedComponents.cpu" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn CPU --</option>
                            @foreach($products['cpu-processor'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- GPU -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">VGA - Card Màn Hình</h3>
                        <span class="text-red-600 text-sm">*Bắt buộc</span>
                    </div>
                    @if(isset($products['vga-card-man-hinh']) && $products['vga-card-man-hinh']->count() > 0)
                        <select x-model="selectedComponents.gpu" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn VGA --</option>
                            @foreach($products['vga-card-man-hinh'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- RAM -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">RAM - Bộ Nhớ</h3>
                        <span class="text-red-600 text-sm">*Bắt buộc</span>
                    </div>
                    @if(isset($products['ram-bo-nho']) && $products['ram-bo-nho']->count() > 0)
                        <select x-model="selectedComponents.ram" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn RAM --</option>
                            @foreach($products['ram-bo-nho'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- SSD -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">SSD - Ổ Cứng</h3>
                        <span class="text-red-600 text-sm">*Bắt buộc</span>
                    </div>
                    @if(isset($products['ssd-o-cung']) && $products['ssd-o-cung']->count() > 0)
                        <select x-model="selectedComponents.ssd" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn SSD --</option>
                            @foreach($products['ssd-o-cung'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- Mainboard -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">Mainboard</h3>
                        <span class="text-gray-500 text-sm">Tùy chọn</span>
                    </div>
                    @if(isset($products['mainboard-mainboard']) && $products['mainboard-mainboard']->count() > 0)
                        <select x-model="selectedComponents.mainboard" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn Mainboard --</option>
                            @foreach($products['mainboard-mainboard'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- PSU -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">PSU - Nguồn</h3>
                        <span class="text-gray-500 text-sm">Tùy chọn</span>
                    </div>
                    @if(isset($products['psu-nguon']) && $products['psu-nguon']->count() > 0)
                        <select x-model="selectedComponents.psu" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn Nguồn --</option>
                            @foreach($products['psu-nguon'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- Case -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">Case - Vỏ Máy</h3>
                        <span class="text-gray-500 text-sm">Tùy chọn</span>
                    </div>
                    @if(isset($products['case-vo-may']) && $products['case-vo-may']->count() > 0)
                        <select x-model="selectedComponents.case" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn Case --</option>
                            @foreach($products['case-vo-may'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- Cooler -->
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-lg">Fan & Cooler</h3>
                        <span class="text-gray-500 text-sm">Tùy chọn</span>
                    </div>
                    @if(isset($products['fan-cooler-quat-tan-nhiet']) && $products['fan-cooler-quat-tan-nhiet']->count() > 0)
                        <select x-model="selectedComponents.cooler" @change="updateTotal()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">-- Chọn Cooler --</option>
                            @foreach($products['fan-cooler-quat-tan-nhiet'] as $product)
                                <option value='@json([
                                    "id" => $product->id,
                                    "name" => $product->name,
                                    "price" => $product->sale_price ?? $product->price,
                                    "image" => $product->images->first()?->url
                                ])'>
                                    {{ $product->name }} - {{ number_format($product->sale_price ?? $product->price) }}₫
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm</p>
                    @endif
                </div>

                <!-- Summary Card (sticky on desktop) -->
                <div class="lg:hidden bg-blue-50 rounded-lg p-4 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold text-lg">Tổng cộng:</span>
                        <span class="text-red-600 font-bold text-2xl" x-text="formatPrice(totalPrice)"></span>
                    </div>
                    <button @click="addAllToCart()" 
                        :disabled="!canCheckout()"
                        :class="canCheckout() ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-300 cursor-not-allowed'"
                        class="w-full text-white py-3 rounded-lg font-semibold">
                        Thêm tất cả vào giỏ hàng
                    </button>
                    <p class="text-xs text-gray-500 mt-2 text-center" x-show="!canCheckout()">
                        Vui lòng chọn CPU, VGA, RAM và SSD
                    </p>
                </div>

                <script>
                    function pcBuilder() {
                        return {
                            selectedComponents: {
                                cpu: '',
                                gpu: '',
                                ram: '',
                                ssd: '',
                                mainboard: '',
                                psu: '',
                                case: '',
                                cooler: ''
                            },
                            totalPrice: 0,
                            
                            updateTotal() {
                                this.totalPrice = 0;
                                for (let key in this.selectedComponents) {
                                    if (this.selectedComponents[key]) {
                                        try {
                                            const component = JSON.parse(this.selectedComponents[key]);
                                            this.totalPrice += component.price;
                                        } catch (e) {}
                                    }
                                }
                            },
                            
                            formatPrice(price) {
                                return new Intl.NumberFormat('vi-VN', { 
                                    style: 'currency', 
                                    currency: 'VND' 
                                }).format(price);
                            },
                            
                            canCheckout() {
                                return this.selectedComponents.cpu && 
                                       this.selectedComponents.gpu && 
                                       this.selectedComponents.ram && 
                                       this.selectedComponents.ssd;
                            },
                            
                            addAllToCart() {
                                if (!this.canCheckout()) {
                                    alert('Vui lòng chọn ít nhất CPU, VGA, RAM và SSD');
                                    return;
                                }
                                
                                const productIds = [];
                                for (let key in this.selectedComponents) {
                                    if (this.selectedComponents[key]) {
                                        try {
                                            const component = JSON.parse(this.selectedComponents[key]);
                                            productIds.push(component.id);
                                        } catch (e) {}
                                    }
                                }
                                
                                // Add all to cart sequentially
                                alert(`Đang thêm ${productIds.length} sản phẩm vào giỏ hàng...`);
                                // In production, this would make actual API calls
                                console.log('Adding to cart:', productIds);
                            }
                        }
                    }
                </script>
            </div>
        </div>

        <!-- Summary Sidebar (Desktop) -->
        <div class="hidden lg:block">
            <div class="bg-blue-50 rounded-lg p-4 sticky top-4" x-data="pcBuilder()">
                <h3 class="font-bold text-lg mb-4">Tổng Quan Cấu Hình</h3>
                
                <div class="space-y-3 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">CPU:</span>
                        <span x-text="selectedComponents.cpu ? 'Đã chọn' : 'Chưa chọn'" 
                            :class="selectedComponents.cpu ? 'text-green-600' : 'text-gray-400'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">VGA:</span>
                        <span x-text="selectedComponents.gpu ? 'Đã chọn' : 'Chưa chọn'"
                            :class="selectedComponents.gpu ? 'text-green-600' : 'text-gray-400'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">RAM:</span>
                        <span x-text="selectedComponents.ram ? 'Đã chọn' : 'Chưa chọn'"
                            :class="selectedComponents.ram ? 'text-green-600' : 'text-gray-400'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">SSD:</span>
                        <span x-text="selectedComponents.ssd ? 'Đã chọn' : 'Chưa chọn'"
                            :class="selectedComponents.ssd ? 'text-green-600' : 'text-gray-400'"></span>
                    </div>
                </div>

                <div class="border-t pt-4 mb-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">Tổng cộng:</span>
                        <span class="text-red-600 font-bold text-2xl" x-text="formatPrice(totalPrice)"></span>
                    </div>
                </div>

                <button @click="addAllToCart()" 
                    :disabled="!canCheckout()"
                    :class="canCheckout() ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-300 cursor-not-allowed'"
                    class="w-full text-white py-3 rounded-lg font-semibold mb-2">
                    Thêm tất cả vào giỏ hàng
                </button>
                
                <p class="text-xs text-gray-500 text-center" x-show="!canCheckout()">
                    Vui lòng chọn CPU, VGA, RAM và SSD
                </p>

                <script>
                    function pcBuilder() {
                        return {
                            selectedComponents: {
                                cpu: '',
                                gpu: '',
                                ram: '',
                                ssd: '',
                                mainboard: '',
                                psu: '',
                                case: '',
                                cooler: ''
                            },
                            totalPrice: 0,
                            
                            updateTotal() {
                                this.totalPrice = 0;
                                for (let key in this.selectedComponents) {
                                    if (this.selectedComponents[key]) {
                                        try {
                                            const component = JSON.parse(this.selectedComponents[key]);
                                            this.totalPrice += component.price;
                                        } catch (e) {}
                                    }
                                }
                            },
                            
                            formatPrice(price) {
                                return new Intl.NumberFormat('vi-VN', { 
                                    style: 'currency', 
                                    currency: 'VND' 
                                }).format(price);
                            },
                            
                            canCheckout() {
                                return this.selectedComponents.cpu && 
                                       this.selectedComponents.gpu && 
                                       this.selectedComponents.ram && 
                                       this.selectedComponents.ssd;
                            },
                            
                            addAllToCart() {
                                if (!this.canCheckout()) {
                                    alert('Vui lòng chọn ít nhất CPU, VGA, RAM và SSD');
                                    return;
                                }
                                
                                const productIds = [];
                                for (let key in this.selectedComponents) {
                                    if (this.selectedComponents[key]) {
                                        try {
                                            const component = JSON.parse(this.selectedComponents[key]);
                                            productIds.push(component.id);
                                        } catch (e) {}
                                    }
                                }
                                
                                alert(`Đang thêm ${productIds.length} sản phẩm vào giỏ hàng...`);
                                console.log('Adding to cart:', productIds);
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
