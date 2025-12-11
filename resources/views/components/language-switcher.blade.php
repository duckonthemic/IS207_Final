{{-- Language Switcher Component --}}
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
        {{-- Current Language Flag --}}
        @if(app()->getLocale() === 'vi')
            <span class="text-base">🇻🇳</span>
            <span class="hidden sm:inline">VI</span>
        @else
            <span class="text-base">🇺🇸</span>
            <span class="hidden sm:inline">EN</span>
        @endif
        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Dropdown --}}
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
        style="display: none;">

        {{-- Vietnamese --}}
        <a href="{{ route('language.switch', 'vi') }}"
            class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ app()->getLocale() === 'vi' ? 'text-blue-600 bg-blue-50' : 'text-gray-700' }}">
            <span class="text-base">🇻🇳</span>
            <span>Tiếng Việt</span>
            @if(app()->getLocale() === 'vi')
                <svg class="w-4 h-4 ml-auto text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            @endif
        </a>

        {{-- English --}}
        <a href="{{ route('language.switch', 'en') }}"
            class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ app()->getLocale() === 'en' ? 'text-blue-600 bg-blue-50' : 'text-gray-700' }}">
            <span class="text-base">🇺🇸</span>
            <span>English</span>
            @if(app()->getLocale() === 'en')
                <svg class="w-4 h-4 ml-auto text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            @endif
        </a>
    </div>
</div>