# KẾ HOẠCH CẢI THIỆN HỆ THỐNG (IMPROVEMENT PLAN)

Tài liệu này đề xuất lộ trình cải thiện hệ thống Tech Parts E-Commerce dựa trên phân tích hiện trạng ngày 27/11/2025.

---

## 📊 PHÂN TÍCH HIỆN TRẠNG

### Điểm mạnh
- **Cấu trúc:** Tuân thủ tốt mô hình MVC của Laravel.
- **Tính năng:** Đã hoàn thành các chức năng cốt lõi (Auth, Product, Cart, Checkout, Admin).
- **Tài liệu:** Hệ thống tài liệu (Docs) rất chi tiết và đầy đủ.

### Điểm cần cải thiện
- **Frontend Architecture:** Đang sử dụng lẫn lộn giữa Vite build system và Tailwind CDN (với config inline). Điều này gây khó khăn cho việc maintain và tối ưu hiệu năng.
- **Tính năng còn thiếu:** Thanh toán online, Email notification, Reviews chưa hoàn thiện UI.
- **UX/UI:** Cần đồng bộ hóa theme, cải thiện phản hồi người dùng (loading states, toast notifications).

---

## 🚀 LỘ TRÌNH CẢI THIỆN (ROADMAP)

### GIAI ĐOẠN 1: CHUẨN HÓA & NỀN TẢNG (Standardization & Foundation)
**Mục tiêu:** Đưa dự án về chuẩn development, tối ưu quy trình build và thiết lập Design System mới.

1.  **Thiết lập Design System (Black & White Cyber):**
    -   **Phong cách:** Minimalist Cyber (Tối giản, Hiện đại).
    -   **Màu sắc chủ đạo:** Đen (#000000) và Trắng (#FFFFFF).
    -   **Accent:** Sử dụng màu xám nhạt cho border/nền phụ. Hạn chế tối đa màu neon, chỉ dùng cho các trạng thái đặc biệt (nếu cần).
    -   **Typography:** Font chữ hiện đại, đậm nét (Bold) cho tiêu đề, sạch sẽ cho nội dung.
    -   **Component Style:** Button đen góc vuông hoặc bo nhẹ, Card sản phẩm nền trắng sạch sẽ.

2.  **Migrate Tailwind Config:**
    -   **Vấn đề:** Hiện tại `app.blade.php` đang khai báo config Tailwind trực tiếp trong thẻ `<script>`, trong khi `tailwind.config.js` lại dùng cấu hình mặc định.
    -   **Giải pháp:** Chuyển toàn bộ cấu hình màu sắc (`cyber-dark`, `cyber-accent`...), font chữ (`Barlow`) từ file blade vào `tailwind.config.js`.
    -   **Hành động:** Loại bỏ CDN Tailwind trong `app.blade.php`, sử dụng `@vite(['resources/css/app.css', 'resources/js/app.js'])`.

3.  **Code Refactoring:**
    -   Kiểm tra và xử lý lỗi N+1 Query trong các trang danh sách (Products, Orders).
    -   Sử dụng Eager Loading (`with()`) cho các relationships.

### GIAI ĐOẠN 2: HOÀN THIỆN TÍNH NĂNG (Feature Completion)
**Mục tiêu:** Hoàn tất các tính năng còn thiếu và nâng cấp logic nghiệp vụ.

1.  **Nâng cấp PC Builder (Quan trọng):**
    -   Thêm logic kiểm tra tương thích (Compatibility Check): Socket CPU vs Mainboard, Loại RAM (DDR4/DDR5).
    -   Tính toán tổng công suất tiêu thụ (TDP) để gợi ý nguồn phù hợp.
    -   Cải thiện UI chọn linh kiện: Sử dụng Modal/Popup thay vì chuyển trang.

2.  **Thanh toán (Payment):**
    -   Tích hợp cổng thanh toán (Stripe hoặc PayOS Sandbox).
    -   Xử lý Webhook để cập nhật trạng thái đơn hàng tự động.

3.  **Email Notifications:**
    -   Tạo Mailable classes: `OrderPlaced`, `OrderShipped`.
    -   Cấu hình Queue để gửi email không đồng bộ (tránh làm chậm checkout).

4.  **Đánh giá sản phẩm (Reviews):**
    -   Hoàn thiện UI form đánh giá (Star rating).
    -   Hiển thị trung bình sao và danh sách đánh giá chi tiết tại trang Product Detail.

### GIAI ĐOẠN 3: NÂNG CẤP UX/UI (UX/UI Polish)
**Mục tiêu:** Tăng trải nghiệm người dùng, giao diện chuyên nghiệp theo phong cách Black & White Cyber.

1.  **Đồng bộ Theme (Black & White):**
    -   Áp dụng theme mới cho toàn bộ các trang (Home, Product, Cart, Checkout).
    -   Đảm bảo tính nhất quán về màu sắc, font chữ và style của các component (Button, Input, Card).

2.  **Feedback System:**
    -   Thay thế flash message hiện tại bằng Toast Notification chuyên nghiệp.
    -   Thêm Loading State (skeleton loader) khi chuyển trang hoặc load dữ liệu AJAX.

3.  **Mobile Responsiveness:**
    -   Chuyển bộ lọc sản phẩm sang dạng Off-canvas Sidebar (Drawer) trên mobile.
    -   Tối ưu menu navigation trên mobile (Hamburger menu).

### GIAI ĐOẠN 4: TỐI ƯU & MỞ RỘNG (Optimization & Advanced)
**Mục tiêu:** Chuẩn bị cho Production và mở rộng quy mô.

1.  **Performance:**
    -   Cấu hình Caching (Redis) cho các query nặng (Menu, Categories, Homepage products).
    -   Tối ưu hình ảnh (WebP format).

2.  **Advanced Search:**
    -   Cải thiện bộ lọc sản phẩm (Filter by specs dynamic).
    -   Full-text search cho tên sản phẩm.

3.  **Security:**
    -   Review lại các quyền truy cập (Authorization policies).
    -   Rate limiting cho các API và Login route.

---

## ✅ MASTER CHECKLIST (TỔNG HỢP TỪ CÁC TÀI LIỆU CŨ)

### 1. Tính năng cốt lõi (Core Features)
- [x] **Authentication:** Đăng ký, Đăng nhập, Quên mật khẩu, Email verification.
- [x] **Sản phẩm:** Danh sách, Tìm kiếm, Lọc, Chi tiết, Specs, Multiple images.
- [x] **Giỏ hàng:** Thêm/Sửa/Xóa, Tính tổng tiền.
- [x] **Checkout:** Quy trình 3 bước (Shipping -> Payment -> Confirm).
- [x] **Admin Panel:** Dashboard, CRUD Sản phẩm, Quản lý đơn hàng.
- [x] **Build PC:** Giao diện chọn linh kiện, Lưu cấu hình (LocalStorage).

### 2. Tính năng cần hoàn thiện (Pending Features)
- [ ] **Thanh toán Online:** Tích hợp Stripe hoặc PayOS.
- [ ] **Email Notifications:** Gửi email xác nhận đơn hàng, cập nhật trạng thái.
- [ ] **Reviews:** Form đánh giá, Hiển thị sao trung bình, Admin duyệt đánh giá.
- [ ] **PC Builder Nâng cao:** Check tương thích (Socket, RAM type), Tính công suất nguồn.
- [ ] **So sánh sản phẩm:** Chọn 2-3 sản phẩm để so sánh specs.
- [ ] **Wishlist:** Lưu sản phẩm yêu thích.

### 3. UX/UI & Frontend
- [ ] **Theme:** Chuyển đổi toàn bộ sang **Black & White Cyber Theme**.
- [ ] **Mobile:** Chuyển bộ lọc sang dạng Drawer/Off-canvas.
- [ ] **Feedback:** Thay thế alert/flash message bằng Toast Notification.
- [ ] **Loading States:** Thêm Skeleton loader khi tải dữ liệu.

### 4. Testing & Optimization
- [ ] **E2E Testing:** Viết test cho luồng mua hàng hoàn chỉnh (Laravel Dusk).
- [ ] **Performance:** Cấu hình Cache (Redis), Tối ưu query (N+1), Nén ảnh.
- [ ] **Security:** Review lại Authorization (Policies), Rate limiting.

---

## 📝 KẾ HOẠCH CHI TIẾT TUẦN TỚI (NEXT STEPS)

1.  **Ngày 1:** Thực hiện **Giai đoạn 1** - Fix Tailwind Config & Vite Build.
2.  **Ngày 2:** Review code Controller & Models, fix N+1 Queries.
3.  **Ngày 3:** Bắt đầu **Giai đoạn 2** - Tích hợp Email Notification cơ bản.

