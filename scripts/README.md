# Product Image Scraper Tool

Công cụ standalone để tự động tải hình ảnh sản phẩm từ website nhà sản xuất.

> ⚠️ **Lưu ý**: Đây là tool riêng biệt, KHÔNG phải một phần của web application.

## Cài đặt

```bash
cd scripts
pip install -r requirements.txt
```

## Sử dụng

```bash
python scrape_product_images.py
```

## Cách hoạt động

1. Đọc danh sách sản phẩm từ `product.json`
2. Tìm kiếm ảnh theo thứ tự ưu tiên:
   - Website nhà sản xuất (ASUS, Intel, AMD, etc.)
   - DuckDuckGo Images
   - Bing Images (fallback)
3. Tải và lưu ảnh vào `public/images/products/{product-id}/`
4. Xuất kết quả ra `product_images.json`

## Output

- **Ảnh**: `public/images/products/{product-id}/1.jpg`, `2.jpg`, etc.
- **JSON**: `scripts/product_images.json` - chứa thông tin source URLs và paths

## Cấu hình

Trong file `scrape_product_images.py`:

```python
MIN_IMAGES = 2     # Số ảnh tối thiểu cần tải
MAX_IMAGES = 6     # Số ảnh tối đa per product
MIN_IMAGE_SIZE = (200, 200)  # Kích thước ảnh tối thiểu
```

## Lưu ý

- Script có rate limiting (1 giây giữa mỗi sản phẩm) để tránh bị block
- Một số website có anti-bot protection, có thể cần điều chỉnh headers
- Kết quả phụ thuộc vào khả năng truy cập các website
