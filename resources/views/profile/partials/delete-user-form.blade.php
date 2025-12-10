<section class="space-y-6">
    <div class="p-4 bg-red-50 rounded-xl border border-red-100">
        <p class="text-sm text-red-700 flex items-start gap-2">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                </path>
            </svg>
            <span>Khi tài khoản bị xóa, tất cả dữ liệu và thông tin liên quan sẽ bị xóa vĩnh viễn. Trước khi xóa, vui
                lòng tải xuống bất kỳ dữ liệu nào bạn muốn giữ lại.</span>
        </p>
    </div>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all">
        Xóa tài khoản
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white">
            @csrf
            @method('delete')

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Xác nhận xóa tài khoản</h2>
                <p class="text-sm text-gray-500 mt-2">Hành động này không thể hoàn tác. Vui lòng nhập mật khẩu để xác
                    nhận.</p>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Mật khẩu</label>
                <input id="password" name="password" type="password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    placeholder="Nhập mật khẩu của bạn" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="flex-1 px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-all">
                    Hủy bỏ
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all">
                    Xác nhận xóa
                </button>
            </div>
        </form>
    </x-modal>
</section>