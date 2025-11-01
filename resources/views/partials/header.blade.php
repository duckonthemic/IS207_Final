<header class="bg-white border-b">
  <div class="container mx-auto px-4 py-4 flex items-center justify-between">
    <a href="{{ route('home') }}" class="font-bold">PC Parts E‑Store</a>
    <nav class="space-x-4">
      <a href="{{ route('products.index') }}" class="hover:underline">Sản phẩm</a>
      <a href="{{ route('blog.index') }}" class="hover:underline">Blog</a>
      <a href="{{ route('about') }}" class="hover:underline">Giới thiệu</a>
      <a href="{{ route('contact') }}" class="hover:underline">Liên hệ</a>
      @auth
        <a href="{{ route('cart.index') }}" class="hover:underline">Giỏ hàng</a>
      @endauth
    </nav>
  </div>
</header>
