@extends('layouts.app')

@section('title', 'Địa chỉ giao hàng - UITech')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Sidebar Navigation --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                        {{-- User Avatar & Name --}}
                        <div class="p-6 border-b border-gray-100 text-center">
                            <div
                                class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>

                        {{-- Navigation Links --}}
                        <nav class="p-4 space-y-1">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Thông tin cá nhân
                            </a>
                            <a href="{{ route('addresses.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-gray-100 text-gray-900 font-bold">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Địa chỉ giao hàng
                            </a>
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors font-medium group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Đơn hàng của tôi
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">Địa chỉ giao hàng</h1>
                                <p class="text-sm text-gray-500 mt-1">Quản lý các địa chỉ nhận hàng của bạn</p>
                            </div>
                            <a href="{{ route('addresses.create') }}"
                                class="px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Thêm địa chỉ mới
                            </a>
                        </div>

                        <div class="p-8">
                            {{-- Success Message --}}
                            @if(session('success'))
                                <div
                                    class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($addresses->isEmpty())
                                {{-- Empty State --}}
                                <div class="text-center py-16">
                                    <div
                                        class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có địa chỉ nào</h3>
                                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">Thêm địa chỉ giao hàng để thuận tiện cho việc
                                        đặt hàng và nhận hàng nhanh hơn</p>
                                    <a href="{{ route('addresses.create') }}"
                                        class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Thêm địa chỉ đầu tiên
                                    </a>
                                </div>
                            @else
                                {{-- Address List --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($addresses as $address)
                                        <div
                                            class="relative p-6 border-2 {{ $address->is_default ? 'border-gray-900 bg-gray-50' : 'border-gray-100' }} rounded-2xl group hover:shadow-md transition-all">
                                            @if($address->is_default)
                                                <span
                                                    class="absolute top-4 right-4 px-3 py-1 bg-gray-900 text-white text-xs font-bold rounded-full">
                                                    Mặc định
                                                </span>
                                            @endif

                                            <div class="pr-20">
                                                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $address->fullname }}</h3>
                                                <p class="text-gray-500 text-sm font-medium mb-3">{{ $address->phone }}</p>
                                                <p class="text-sm text-gray-600 leading-relaxed">
                                                    {{ $address->address }}
                                                    @if($address->ward), {{ $address->ward }}@endif
                                                    @if($address->district), {{ $address->district }}@endif
                                                    @if($address->city), {{ $address->city }}@endif
                                                    @if($address->postal_code) - {{ $address->postal_code }}@endif
                                                </p>
                                            </div>

                                            <div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-100">
                                                <a href="{{ route('addresses.edit', $address) }}"
                                                    class="text-sm font-bold text-gray-900 hover:text-gray-700 transition-colors flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Sửa
                                                </a>
                                                @if(!$address->is_default)
                                                    <button onclick="setDefault({{ $address->id }})"
                                                        class="text-sm font-bold text-green-600 hover:text-green-700 transition-colors flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Đặt mặc định
                                                    </button>
                                                @endif
                                                <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa địa chỉ này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-sm font-bold text-red-600 hover:text-red-700 transition-colors flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function setDefault(addressId) {
                if (!confirm('Đặt địa chỉ này làm mặc định?')) return;

                fetch(`/addresses/${addressId}/set-default`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endpush
@endsection