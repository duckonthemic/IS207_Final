@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-2 border-gray-300 bg-white text-black focus:border-black focus:ring-0 rounded-none shadow-sm transition-colors']) !!}>
