<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-black border-2 border-black rounded-none font-bold text-xs text-white uppercase tracking-widest hover:bg-white hover:text-black focus:bg-gray-800 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
