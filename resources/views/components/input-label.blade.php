@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs text-cyber-text-muted uppercase tracking-wider mb-1']) }}>
    {{ $value ?? $slot }}
</label>
