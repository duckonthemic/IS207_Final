<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="update_password_current_password" class="block text-sm font-bold text-gray-700 mb-2">Mật
                    khẩu hiện tại</label>
                <input type="password" id="update_password_current_password" name="current_password"
                    autocomplete="current-password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <label for="update_password_password" class="block text-sm font-bold text-gray-700 mb-2">Mật khẩu
                    mới</label>
                <input type="password" id="update_password_password" name="password" autocomplete="new-password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="update_password_password_confirmation"
                    class="block text-sm font-bold text-gray-700 mb-2">Xác nhận mật khẩu</label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="text-sm text-gray-600 flex items-start gap-2">
                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số để đảm bảo an toàn.</span>
            </p>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all shadow-lg hover:shadow-gray-900/20">
                Đổi mật khẩu
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Mật khẩu đã được cập nhật
                </p>
            @endif
        </div>
    </form>
</section>