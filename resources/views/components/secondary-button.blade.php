<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-3 bg-transparent border border-cyber-white rounded-none font-bold text-xs text-cyber-white uppercase tracking-widest hover:bg-cyber-white hover:text-cyber-black focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
