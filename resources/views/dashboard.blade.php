<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-cyber-white uppercase tracking-wider leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-cyber-gray border border-cyber-border rounded-none overflow-hidden">
                <div class="p-6 text-cyber-white">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
