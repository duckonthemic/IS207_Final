@extends('layouts.app')

@section('title', 'Build PC - Tự lắp ráp PC theo sở thích')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-gray-900 font-bold">Build PC</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Build PC - Tự Lắp Ráp PC Theo Sở Thích</h1>
            <p class="text-gray-500">Chọn từng linh kiện để tạo nên bộ PC hoàn hảo cho riêng bạn</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="pcBuilder()">
            <!-- Build List -->
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <!-- CPU -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">CPU - Bộ Xử Lý</h3>
                            <span class="text-red-500 text-xs font-bold uppercase">*Bắt buộc</span>
                        </div>
                        @if(isset($products['cpu-processor']) && $products['cpu-processor']->count() > 0)
                            <select x-model="selectedComponents.cpu" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- GPU -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">VGA - Card Màn Hình</h3>
                            <span class="text-red-500 text-xs font-bold uppercase">*Bắt buộc</span>
                        </div>
                        @if(isset($products['vga-card-man-hinh']) && $products['vga-card-man-hinh']->count() > 0)
                            <select x-model="selectedComponents.gpu" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- RAM -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">RAM - Bộ Nhớ</h3>
                            <span class="text-red-500 text-xs font-bold uppercase">*Bắt buộc</span>
                        </div>
                        @if(isset($products['ram-bo-nho']) && $products['ram-bo-nho']->count() > 0)
                            <select x-model="selectedComponents.ram" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- SSD -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">SSD - Ổ Cứng</h3>
                            <span class="text-red-500 text-xs font-bold uppercase">*Bắt buộc</span>
                        </div>
                        @if(isset($products['ssd-o-cung']) && $products['ssd-o-cung']->count() > 0)
                            <select x-model="selectedComponents.ssd" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- Mainboard -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">Mainboard</h3>
                            <span class="text-gray-400 text-xs font-bold uppercase">Tùy chọn</span>
                        </div>
                        @if(isset($products['mainboard-mainboard']) && $products['mainboard-mainboard']->count() > 0)
                            <select x-model="selectedComponents.mainboard" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- PSU -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">PSU - Nguồn</h3>
                            <span class="text-gray-400 text-xs font-bold uppercase">Tùy chọn</span>
                        </div>
                        @if(isset($products['psu-nguon']) && $products['psu-nguon']->count() > 0)
                            <select x-model="selectedComponents.psu" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- Case -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">Case - Vỏ Máy</h3>
                            <span class="text-gray-400 text-xs font-bold uppercase">Tùy chọn</span>
                        </div>
                        @if(isset($products['case-vo-may']) && $products['case-vo-may']->count() > 0)
                            <select x-model="selectedComponents.case" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- Cooler -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-lg text-gray-900">Fan & Cooler</h3>
                            <span class="text-gray-400 text-xs font-bold uppercase">Tùy chọn</span>
                        </div>
                        @if(isset($products['fan-cooler-quat-tan-nhiet']) && $products['fan-cooler-quat-tan-nhiet']->count() > 0)
                            <select x-model="selectedComponents.cooler" @change="updateTotal()" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm cursor-pointer">
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
                            <p class="text-gray-500 italic">Chưa có sản phẩm</p>
                        @endif
                    </div>

                    <!-- Summary Card (sticky on desktop) -->
                    <div class="lg:hidden bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-bold text-lg text-gray-900 uppercase tracking-wider">Tổng cộng:</span>
                            <span class="text-blue-600 font-bold text-2xl" x-text="formatPrice(totalPrice)"></span>
                        </div>
                        <button @click="addAllToCart()" 
                            :disabled="!canCheckout()"
                            :class="canCheckout() ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                            class="w-full py-4 font-bold uppercase tracking-widest text-sm transition-all rounded-xl">
                            Thêm tất cả vào giỏ hàng
                        </button>
                        <p class="text-xs text-red-500 mt-2 text-center font-bold uppercase" x-show="!canCheckout()">
                            Vui lòng chọn CPU, VGA, RAM và SSD
                        </p>
                    </div>
                </div>
            </div>

            <!-- Summary Sidebar (Desktop) -->
            <div class="hidden lg:block">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-lg text-gray-900 mb-6 uppercase tracking-wider border-b border-gray-100 pb-4">Tổng Quan Cấu Hình</h3>
                    
                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">CPU:</span>
                            <span x-text="selectedComponents.cpu ? 'Đã chọn' : 'Chưa chọn'" 
                                :class="selectedComponents.cpu ? 'text-green-600 font-bold' : 'text-gray-400'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">VGA:</span>
                            <span x-text="selectedComponents.gpu ? 'Đã chọn' : 'Chưa chọn'"
                                :class="selectedComponents.gpu ? 'text-green-600 font-bold' : 'text-gray-400'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">RAM:</span>
                            <span x-text="selectedComponents.ram ? 'Đã chọn' : 'Chưa chọn'"
                                :class="selectedComponents.ram ? 'text-green-600 font-bold' : 'text-gray-400'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">SSD:</span>
                            <span x-text="selectedComponents.ssd ? 'Đã chọn' : 'Chưa chọn'"
                                :class="selectedComponents.ssd ? 'text-green-600 font-bold' : 'text-gray-400'"></span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-lg text-gray-900 uppercase tracking-wider">Tổng cộng:</span>
                            <span class="text-blue-600 font-bold text-2xl" x-text="formatPrice(totalPrice)"></span>
                        </div>
                    </div>

                    <button @click="addAllToCart()" 
                        :disabled="!canCheckout()"
                        :class="canCheckout() ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                        class="w-full py-4 font-bold uppercase tracking-widest text-sm transition-all mb-2 rounded-xl">
                        Thêm tất cả vào giỏ hàng
                    </button>
                    
                    <p class="text-xs text-red-500 text-center font-bold uppercase" x-show="!canCheckout()">
                        Vui lòng chọn CPU, VGA, RAM và SSD
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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
@endpush
@endsection
