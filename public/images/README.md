# Hướng dẫn đặt logo UITech

## Cấu trúc thư mục hình ảnh

```
public/
└── images/
    ├── logo/
    │   └── uitech-logo.png (Đặt logo UITech vào đây)
    ├── products/
    │   └── (Hình ảnh sản phẩm)
    └── banners/
        └── (Hình banner quảng cáo)
```

## Cách thêm logo

1. **Lưu logo UITech** (ảnh đã cung cấp) vào:
   ```
   public/images/logo/uitech-logo.png
   ```

2. **Kích thước đề xuất cho logo:**
   - Chiều cao: 48-60px
   - Format: PNG với nền trong suốt
   - Tên file: `uitech-logo.png`

3. **Logo sẽ tự động hiển thị** trên header của website

## Thay đổi đã thực hiện

### ✅ Font chữ
- **Heading font**: Rajdhani (Bold, Modern - giống logo "DANH MỤC NỔI BẬT")
- **Body font**: Inter (Clean, Modern)

### ✅ Logo header
- Logo UITech với image + fallback
- Nếu không có ảnh logo, hiển thị logo text backup với:
  - Icon gradient xanh-tím
  - Text "UITech" với font Rajdhani
  - Tagline "Innovation & Technology"

### ✅ Loại bỏ icons không cần thiết
- ❌ Xóa icon wishlist (trái tim)
- ❌ Xóa emoji icons trong category navigation (⚡🎮🔧📊💾💿🔌📦❄️🖥️)
- ✅ Giữ lại: Cart icon, User icon, Search icon (cần thiết cho chức năng)
- ✅ Category navigation giờ chỉ dùng text với font Rajdhani bold

### ✅ UI Improvements
- Modern sans-serif font thay vì emoji
- Button màu xanh dương thay vì đen
- Cart badge màu xanh dương thay vì đen
- Category navigation hiển thị 8 danh mục thay vì 6
- Spacing và padding được tối ưu hóa

## Cách sử dụng các folder khác

### Products Images
```
public/images/products/
├── cpu-intel-i9-14900k.jpg
├── gpu-rtx-4090.jpg
└── ...
```

### Banners
```
public/images/banners/
├── home-banner-1.jpg
├── sale-banner.jpg
└── ...
```

## Lưu ý
- Tất cả hình ảnh nên được tối ưu hóa (compress) trước khi upload
- Sử dụng format WebP nếu có thể để tải nhanh hơn
- Logo nên có nền trong suốt (PNG)
