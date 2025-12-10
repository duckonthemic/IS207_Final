<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Tạo tài khoản mới</h2>
        <p class="text-sm text-gray-500 mt-2">Tham gia cộng đồng UITech Store ngay hôm nay</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="registerForm()">
        @csrf

        <!-- Row 1: Name & Phone -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Họ và
                    tên</label>
                <div class="neu-input-group">
                    <span class="neu-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <input id="name"
                        class="neu-inset block w-full py-4 px-4 pl-12 text-gray-700 placeholder-gray-400 focus:ring-0 transition-all duration-300"
                        type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Nguyễn Văn A" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Số điện
                    thoại</label>
                <div class="neu-input-group">
                    <span class="neu-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </span>
                    <input id="phone"
                        class="neu-inset block w-full py-4 px-4 pl-12 text-gray-700 placeholder-gray-400 focus:ring-0 transition-all duration-300"
                        type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                        placeholder="0912 345 678" />
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

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
                    type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Row 2: Password & Confirm Password -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Mật
                    khẩu</label>
                <div class="neu-input-group">
                    <span class="neu-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input id="password"
                        class="neu-inset block w-full py-4 px-4 pl-12 text-gray-700 placeholder-gray-400 focus:ring-0 transition-all duration-300"
                        type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                        x-model="password" @input="checkPasswordStrength()" />
                </div>
                <!-- Password Strength Indicator -->
                <div class="password-strength mt-2">
                    <div class="password-strength-bar"
                        :class="{ 'active': strengthLevel >= 1, 'weak': strengthLevel === 1, 'medium': strengthLevel === 2, 'strong': strengthLevel >= 3 }">
                    </div>
                    <div class="password-strength-bar"
                        :class="{ 'active': strengthLevel >= 2, 'medium': strengthLevel === 2, 'strong': strengthLevel >= 3 }">
                    </div>
                    <div class="password-strength-bar"
                        :class="{ 'active': strengthLevel >= 3, 'strong': strengthLevel >= 3 }"></div>
                    <div class="password-strength-bar"
                        :class="{ 'active': strengthLevel >= 4, 'strong': strengthLevel >= 4 }"></div>
                </div>
                <p class="text-xs mt-1"
                    :class="{ 'text-red-500': strengthLevel === 1, 'text-yellow-600': strengthLevel === 2, 'text-green-600': strengthLevel >= 3 }"
                    x-text="strengthText"></p>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation"
                    class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Xác nhận mật
                    khẩu</label>
                <div class="neu-input-group">
                    <span class="neu-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <input id="password_confirmation"
                        class="neu-inset block w-full py-4 px-4 pl-12 text-gray-700 placeholder-gray-400 focus:ring-0 transition-all duration-300"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Terms Checkbox -->
        <div class="flex items-start">
            <label for="terms" class="inline-flex items-start cursor-pointer group">
                <input id="terms" type="checkbox" class="neu-checkbox mt-0.5" name="terms" required>
                <span class="ms-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                    Tôi đồng ý với
                    <a href="{{ route('terms') }}" target="_blank" class="text-gray-900 font-bold hover:underline">Điều
                        khoản sử dụng</a>
                    và
                    <a href="{{ route('privacy') }}" target="_blank"
                        class="text-gray-900 font-bold hover:underline">Chính sách bảo mật</a>
                </span>
            </label>
        </div>
        <x-input-error :messages="$errors->get('terms')" class="mt-1" />

        <!-- Submit Button -->
        <div>
            <button type="submit" class="neu-btn w-full text-center uppercase tracking-wider">
                {{ __('Đăng ký') }}
            </button>
        </div>

        <!-- Divider -->
        <div class="neu-divider">
            <span>hoặc đăng ký với</span>
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

        <!-- Login Link -->
        <div class="text-center text-sm text-gray-500 pt-4">
            Đã có tài khoản?
            <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-700 font-bold transition-colors">
                Đăng nhập ngay
            </a>
        </div>
    </form>

    <script>
        function registerForm() {
            return {
                password: '',
                strengthLevel: 0,
                strengthText: '',
                checkPasswordStrength() {
                    const pwd = this.password;
                    let level = 0;

                    if (pwd.length === 0) {
                        this.strengthLevel = 0;
                        this.strengthText = '';
                        return;
                    }

                    // Length check
                    if (pwd.length >= 8) level++;
                    if (pwd.length >= 12) level++;

                    // Contains lowercase and uppercase
                    if (/[a-z]/.test(pwd) && /[A-Z]/.test(pwd)) level++;

                    // Contains numbers
                    if (/\d/.test(pwd)) level++;

                    // Contains special characters
                    if (/[!@#$%^&*(),.?":{}|<>]/.test(pwd)) level++;

                    // Normalize to max 4
                    this.strengthLevel = Math.min(level, 4);

                    if (this.strengthLevel <= 1) {
                        this.strengthText = 'Yếu - Cần thêm ký tự đặc biệt và số';
                    } else if (this.strengthLevel === 2) {
                        this.strengthText = 'Trung bình - Thêm độ dài hoặc ký tự đặc biệt';
                    } else if (this.strengthLevel === 3) {
                        this.strengthText = 'Mạnh - Mật khẩu tốt';
                    } else {
                        this.strengthText = 'Rất mạnh - Mật khẩu an toàn';
                    }
                }
            }
        }
    </script>
</x-guest-layout>