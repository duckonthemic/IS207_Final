<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Đăng nhập</h2>
        <p class="text-sm text-gray-500 mt-2">Chào mừng bạn quay trở lại!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" :value="__('Mật khẩu')" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-900 hover:text-gray-700 font-medium transition-colors"
                        href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password"
                class="block w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900" name="remember">
                <span
                    class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Ghi nhớ đăng nhập') }}</span>
            </label>
        </div>

        <div>
            <x-primary-button
                class="w-full justify-center py-3 text-base font-bold rounded-xl bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:ring-gray-900/30 transition-all shadow-lg hover:shadow-gray-900/20">
                {{ __('Đăng nhập') }}
            </x-primary-button>
        </div>

        <div class="text-center text-sm text-gray-500">
            Chưa có tài khoản?
            <a href="{{ route('register') }}" class="text-gray-900 hover:text-gray-700 font-bold transition-colors">
                Đăng ký ngay
            </a>
        </div>
    </form>
</x-guest-layout>