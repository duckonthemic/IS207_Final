<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Đăng nhập</h2>
        <p class="text-sm text-gray-500 mt-2">Chào mừng bạn quay trở lại!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Email</label>
            <div class="neu-input-group">
                <span class="neu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <input id="email"
                    class="neu-inset block w-full py-4 px-4 pl-12 text-gray-700 placeholder-gray-400 focus:ring-0 transition-all duration-300"
                    type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-bold text-gray-600 uppercase tracking-wider">Mật
                    khẩu</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-gray-600 hover:text-gray-900 font-medium transition-colors"
                        href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                @endif
            </div>
            <div class="neu-input-group">
                <span class="neu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input id="password"
                    class="neu-inset block w-full py-4 px-4 pl-12 text-gray-700 placeholder-gray-400 focus:ring-0 transition-all duration-300"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="neu-checkbox" name="remember">
                <span class="ms-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                    {{ __('Ghi nhớ đăng nhập') }}
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="neu-btn w-full text-center uppercase tracking-wider">
                {{ __('Đăng nhập') }}
            </button>
        </div>

        <!-- Divider -->
        <div class="neu-divider">
            <span>hoặc đăng nhập với</span>
        </div>

        <!-- Social Login Buttons -->
        <div class="grid grid-cols-2 gap-4">
            <button type="button" class="neu-social-btn w-full">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                <span class="text-sm">Google</span>
            </button>
            <button type="button" class="neu-social-btn w-full">
                <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                    <path
                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                <span class="text-sm">Facebook</span>
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center text-sm text-gray-500 pt-4">
            Chưa có tài khoản?
            <a href="{{ route('register') }}" class="text-gray-900 hover:text-gray-700 font-bold transition-colors">
                Đăng ký ngay
            </a>
        </div>
    </form>
</x-guest-layout>