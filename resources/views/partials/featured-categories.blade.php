{{-- Featured Categories Section --}}
<section class="bg-cyber-black py-12 border-t border-cyber-border">
    <div class="container mx-auto px-4">
        {{-- Section Title --}}
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-cyber-white mb-2 uppercase tracking-tighter">DANH MỤC NỔI BẬT</h2>
            <p class="text-cyber-text-muted font-mono text-sm">// SELECT_COMPONENT_TYPE</p>
        </div>

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $featuredCategories = [
                    ['name' => 'CPU', 'icon' => 'M12 3v9m4.06-4.06l-6.36 6.36M8 15a7 7 0 1014 0A7 7 0 008 15z', 'color' => 'text-cyber-white'],
                    ['name' => 'GPU', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-cyber-white'],
                    ['name' => 'RAM', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'text-cyber-white'],
                    ['name' => 'SSD', 'icon' => 'M5 12a1 1 0 11-2 0 1 1 0 012 0z M12 12a1 1 0 11-2 0 1 1 0 012 0z M19 12a1 1 0 11-2 0 1 1 0 012 0z', 'color' => 'text-cyber-white'],
                    ['name' => 'PSU', 'icon' => 'M7 11a5 5 0 0110 0v1H7v-1z M7 11V8a5 5 0 0110 0v3', 'color' => 'text-cyber-white'],
                    ['name' => 'Case', 'icon' => 'M8 7h12M8 7a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2m0 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2', 'color' => 'text-cyber-white'],
                ];
            @endphp

            @foreach($featuredCategories as $cat)
                @php
                    $category = \App\Models\Category::where('name', $cat['name'])->first();
                @endphp
                
                @if($category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                       class="group relative overflow-hidden bg-cyber-gray border border-cyber-border hover:border-cyber-white transition-all duration-300">
                        
                        {{-- Content --}}
                        <div class="relative p-6 flex flex-col items-center justify-center h-48 text-center">
                            {{-- Icon --}}
                            <div class="mb-4 p-3 bg-cyber-black border border-cyber-border group-hover:bg-cyber-white group-hover:text-cyber-black transition-colors">
                                <svg class="w-8 h-8 {{ $cat['color'] }} group-hover:text-cyber-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"></path>
                                </svg>
                            </div>
                            
                            {{-- Category Name --}}
                            <h3 class="text-lg font-bold text-cyber-white mb-2 uppercase tracking-wider group-hover:text-cyber-white transition-colors">
                                {{ $cat['name'] }}
                            </h3>
                            
                            {{-- Product Count --}}
                            <p class="text-xs text-cyber-text-muted font-mono group-hover:text-cyber-text-muted">
                                [{{ $category->products()->count() }} ITEMS]
                            </p>
                            
                            {{-- Hover Arrow --}}
                            <div class="mt-auto pt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5 text-cyber-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
               class="inline-block px-8 py-4 bg-cyber-white text-cyber-black font-bold hover:bg-gray-800 transition-all uppercase tracking-widest text-sm">
                Xem Tất Cả Sản Phẩm
            </a>
        </div>
    </div>
</section>
