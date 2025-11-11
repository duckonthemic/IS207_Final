{{-- Footer --}}
<footer class="bg-cyber-darker border-t border-cyber-border mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            {{-- About --}}
            <div>
                <h3 class="font-bold text-cyber-accent mb-4">Tech Parts</h3>
                <p class="text-cyber-muted text-sm">Cửa hàng linh kiện máy tính hàng đầu với chất lượng và giá cạnh tranh.</p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-bold text-cyber-text mb-4">Danh mục</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('products.index') }}" class="text-cyber-muted hover:text-cyber-accent transition-colors">Sản phẩm</a></li>
                    <li><a href="{{ route('about') }}" class="text-cyber-muted hover:text-cyber-accent transition-colors">Về chúng tôi</a></li>
                    <li><a href="{{ route('contact') }}" class="text-cyber-muted hover:text-cyber-accent transition-colors">Liên hệ</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-cyber-muted hover:text-cyber-accent transition-colors">Blog</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h4 class="font-bold text-cyber-text mb-4">Hỗ trợ</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-cyber-muted hover:text-cyber-accent transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-cyber-muted hover:text-cyber-accent transition-colors">Chính sách đổi trả</a></li>
                    <li><a href="#" class="text-cyber-muted hover:text-cyber-accent transition-colors">Chính sách bảo mật</a></li>
                    <li><a href="#" class="text-cyber-muted hover:text-cyber-accent transition-colors">Điều khoản dịch vụ</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-bold text-cyber-text mb-4">Liên hệ</h4>
                <ul class="space-y-2 text-sm text-cyber-muted">
                    <li>📧 support@techparts.vn</li>
                    <li>📱 0243 123 456</li>
                    <li>📍 Hà Nội, Việt Nam</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-cyber-border pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-cyber-muted text-sm">© {{ date('Y') }} Tech Parts. Bản quyền được bảo lưu.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-cyber-muted hover:text-cyber-accent transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20v-7.34H5.67v-2.7h2.62V7.47c0-2.61 1.59-4.04 3.92-4.04 1.12 0 2.07.084 2.35.122v2.73h-1.61c-1.26 0-1.51.6-1.51 1.48v1.94h3.02l-.39 2.7h-2.63V20"></path></svg>
                    </a>
                    <a href="#" class="text-cyber-muted hover:text-cyber-accent transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.66 10.66 0 01-10 10"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

