{{-- Featured Categories Section --}}
<section class="bg-gradient-to-r from-gray-50 to-blue-50 py-12 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        {{-- Section Title --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl font-heading font-bold text-gray-900 mb-2">DANH MỤC NỔI BẬT</h2>
            <p class="text-gray-600">Chọn loại linh kiện bạn cần</p>
        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $featuredCategories = [
                    ['name' => 'CPU', 'icon' => 'M12 3v9m4.06-4.06l-6.36 6.36M8 15a7 7 0 1014 0A7 7 0 008 15z', 'color' => 'from-blue-500 to-blue-600'],
                    ['name' => 'GPU', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'from-green-500 to-green-600'],
                    ['name' => 'RAM', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'from-yellow-500 to-yellow-600'],
                    ['name' => 'SSD', 'icon' => 'M5 12a1 1 0 11-2 0 1 1 0 012 0z M12 12a1 1 0 11-2 0 1 1 0 012 0z M19 12a1 1 0 11-2 0 1 1 0 012 0z', 'color' => 'from-purple-500 to-purple-600'],
                    ['name' => 'PSU', 'icon' => 'M7 11a5 5 0 0110 0v1H7v-1z M7 11V8a5 5 0 0110 0v3', 'color' => 'from-red-500 to-red-600'],
                    ['name' => 'Case', 'icon' => 'M8 7h12M8 7a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2m0 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2', 'color' => 'from-indigo-500 to-indigo-600'],
                ];
            @endphp

            @foreach($featuredCategories as $cat)
                @php
                    $category = \App\Models\Category::where('name', $cat['name'])->first();
                @endphp
                
                @if($category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                       class="group relative overflow-hidden rounded-lg bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        {{-- Background Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-br {{ $cat['color'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        
                        {{-- Content --}}
                        <div class="relative p-6 flex flex-col items-center justify-center h-48 text-center">
                            {{-- Icon --}}
                            <div class="mb-4 p-3 rounded-full bg-gradient-to-br {{ $cat['color'] }}">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"></path>
                                </svg>
                            </div>
                            
                            {{-- Category Name --}}
                            <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $cat['name'] }}
                            </h3>
                            
                            {{-- Product Count --}}
                            <p class="text-sm text-gray-500">
                                {{ $category->products()->count() }} sản phẩm
                            </p>
                            
                            {{-- Hover Arrow --}}
                            <div class="mt-auto pt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>

        {{-- View All Button --}}
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" 
               class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-heading font-semibold rounded-lg hover:shadow-lg transition-shadow duration-300">
                Xem Tất Cả Sản Phẩm →
            </a>
        </div>
    </div>
</section>
