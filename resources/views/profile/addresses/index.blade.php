<x-auth-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Địa Chỉ Giao Hàng') }}
            </h2>
            <a href="{{ route('addresses.create') }}" class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg transition">
                + Thêm Địa Chỉ Mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($addresses->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-12 text-center">
                    <div class="text-6xl mb-4">📍</div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">
                        Chưa có địa chỉ nào
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Thêm địa chỉ giao hàng để thuận tiện cho việc đặt hàng
                    </p>
                    <a href="{{ route('addresses.create') }}" class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-lg transition">
                        Thêm Địa Chỉ Đầu Tiên
                    </a>
                </div>
            @else
                {{-- Address List --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($addresses as $address)
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 relative {{ $address->is_default ? 'border-2 border-cyan-500' : '' }}">
                            @if($address->is_default)
                                <span class="absolute top-4 right-4 bg-cyan-500 text-white text-xs px-3 py-1 rounded-full">
                                    Mặc định
                                </span>
                            @endif

                            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">
                                {{ $address->fullname }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                                📞 {{ $address->phone }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                📍 {{ $address->address }}<br>
                                @if($address->ward) {{ $address->ward }}, @endif
                                @if($address->district) {{ $address->district }}, @endif
                                {{ $address->city }}
                                @if($address->postal_code) - {{ $address->postal_code }} @endif
                            </p>

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('addresses.edit', $address) }}" class="text-sm text-blue-500 hover:text-blue-700">
                                    Sửa
                                </a>
                                @if(!$address->is_default)
                                    <button onclick="setDefault({{ $address->id }})" class="text-sm text-green-500 hover:text-green-700">
                                        Đặt mặc định
                                    </button>
                                @endif
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa địa chỉ này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700">
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
</x-auth-layout>
