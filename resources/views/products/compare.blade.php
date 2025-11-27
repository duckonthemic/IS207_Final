@extends('layouts.app')

@section('title', 'So sánh sản phẩm - UITech')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">So sánh sản phẩm</h1>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Quay lại danh sách
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr>
                        <th class="p-6 text-left w-1/4 bg-gray-50 border-b border-r border-gray-100">Thông số</th>
                        @foreach($products as $product)
                            <th class="p-6 text-left w-1/4 border-b border-r border-gray-100 last:border-r-0 align-top">
                                <div class="relative group">
                                    <a href="{{ route('products.show', $product) }}" class="block">
                                        <img src="{{ $product->image_url ?? asset('images/no-image.png') }}" alt="{{ $product->name }}" class="w-32 h-32 object-contain mx-auto mb-4">
                                        <h3 class="font-bold text-gray-900 text-lg mb-2 hover:text-blue-600 transition-colors line-clamp-2 h-14">{{ $product->name }}</h3>
                                    </a>
                                    <div class="text-xl font-bold text-blue-600 mb-4">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </div>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full bg-black text-white font-bold py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                            Thêm vào giỏ
                                        </button>
                                    </form>
                                    
                                    <button @click="$dispatch('toggle-compare', { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', image: '{{ $product->image_url ?? asset('images/no-image.png') }}', category: '{{ $product->category->slug }}' }); window.location.reload()" 
                                            class="absolute top-0 right-0 text-gray-400 hover:text-red-500 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </th>
                        @endforeach
                        {{-- Fill empty columns if less than 3 products --}}
                        @for($i = $products->count(); $i < 3; $i++)
                            <th class="p-6 text-center w-1/4 border-b border-r border-gray-100 last:border-r-0 bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <div class="w-16 h-16 border-2 border-dashed border-gray-300 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <p class="text-sm">Thêm sản phẩm</p>
                                    <a href="{{ route('products.index') }}" class="mt-2 text-blue-600 hover:underline text-sm">Chọn sản phẩm</a>
                                </div>
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($specDefinitions as $specDef)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 font-medium text-gray-600 border-b border-r border-gray-100 bg-gray-50/30">
                                {{ $specDef->name }}
                            </td>
                            @foreach($products as $product)
                                @php
                                    $spec = $product->specs->firstWhere('spec_definition_id', $specDef->id);
                                @endphp
                                <td class="p-4 text-gray-900 border-b border-r border-gray-100 last:border-r-0">
                                    {{ $spec ? $spec->value . ($specDef->unit ? ' ' . $specDef->unit : '') : '-' }}
                                </td>
                            @endforeach
                            @for($i = $products->count(); $i < 3; $i++)
                                <td class="p-4 border-b border-r border-gray-100 last:border-r-0 bg-gray-50/50"></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
