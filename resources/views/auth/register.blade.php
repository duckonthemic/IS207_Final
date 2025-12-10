<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Tạo tài khoản mới</h2>
        <p class="text-sm text-gray-500 mt-2">Tham gia cộng đồng UITech Store ngay hôm nay</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Họ và tên')" />
            <x-text-input id="name"
                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Nguyễn Văn A" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mật khẩu')" />

            <x-text-input id="password"
                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />

            <x-text-input id="password_confirmation"
                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button
                class="w-full justify-center py-3 text-base font-bold rounded-xl bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:ring-gray-900/30 transition-all shadow-lg hover:shadow-gray-900/20">
                {{ __('Đăng ký') }}
            </x-primary-button>
        </div>

        <div class="text-center text-sm text-gray-500">
            Đã có tài khoản?
            <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-700 font-bold transition-colors">
                Đăng nhập ngay
            </a>
        </div>
    </form>
</x-guest-layout>