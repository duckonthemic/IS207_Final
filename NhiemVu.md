# 📋 Phân Công Nhiệm Vụ - PC Parts E-Store

**Dự án**: PC Parts E-Store  
**Thời gian**: Tuần 1-3 (Tháng 11-12, 2025)  
**Tổng cộng**: 17 task, chia cho 6 thành viên

---

## 👥 Thành Viên Dự Án

1. **Hoàng Bảo Long** (Team Lead + Backend)
2. **Ngụy Công Vũ Trung** (Backend)
3. **Lương Tuấn Vỹ** (Backend + Database)
4. **Nguyễn Duy Phương** (Frontend)
5. **Trần Thanh Huy** (Frontend + Testing)
6. **TrầnTrần Tuấn Minh** (Frontend + Admin)

---

## 📅 Lộ trình thực hiện

```
TUẦN 1 (11/11 - 17/11):    Xây dựng tính năng cơ bản
TUẦN 2 (18/11 - 24/11):    Hoàn thiện chức năng cao cấp
TUẦN 3 (25/11 - 01/12):    Testing, tối ưu hóa, bug fix
```

---

## 🎯 Phân Công Chi Tiết

### TUẦN 1: Xây dựng Tính Năng Cơ Bản

#### 1️⃣ **Hoàng Bảo Long** (Team Lead)
**Vai trò**: Quản lý dự án + Backend chính

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 1.1 | **Cài đặt Laravel Breeze (Authentication)** | 🔴 CAO | 12/11 | ⏳ |
| 1.2 | Fix routes và uncomment auth section | 🔴 CAO | 12/11 | ⏳ |
| 1.3 | Cấu hình session + cache settings | 🟡 TRUNG | 12/11 | ⏳ |
| 1.4 | Review code + merge pull requests | 🔴 CAO | 17/11 | ⏳ |

**Chi tiết:**
- Cài `composer require laravel/breeze --dev`
- Chạy `php artisan breeze:install blade`
- Uncomment `require __DIR__.'/auth.php';` trong routes/web.php
- Uncomment auth buttons trong header.blade.php
- Đảm bảo `/login`, `/register`, `/forgot-password` hoạt động

---

#### 2️⃣ **Ngụy Công Vũ Trung**
**Vai trò**: Backend - API Routes + Controllers

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 2.1 | **Hoàn thiện ProductController** | 🔴 CAO | 13/11 | ⏳ |
| 2.2 | Tạo CategoryController | 🟡 TRUNG | 13/11 | ⏳ |
| 2.3 | Tạo CartController + logic | 🔴 CAO | 14/11 | ⏳ |
| 2.4 | Unit tests cho Controllers | 🟡 TRUNG | 15/11 | ⏳ |

**Chi tiết:**
- ProductController: index (với search/filter), show
- CategoryController: index, show
- CartController: index, add, update, remove, clear
- Tất cả methods phải có test coverage ≥ 80%

---

#### 3️⃣ **Lương Tuấn Vỹ**
**Vai trò**: Backend - Database + Models

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 3.1 | **Tạo ProductSeeder** | 🔴 CAO | 12/11 | ⏳ |
| 3.2 | Tạo CategorySeeder | 🟡 TRUNG | 12/11 | ⏳ |
| 3.3 | Tạo AdminUserSeeder | 🔴 CAO | 12/11 | ⏳ |
| 3.4 | Chạy migrations + seeds | 🔴 CAO | 12/11 | ⏳ |
| 3.5 | Thêm model relationships + scopes | 🟡 TRUNG | 13/11 | ⏳ |

**Chi tiết:**
```php
// ProductSeeder: Tạo ≥5 CPU, ≥5 GPU, ≥5 RAM
// CategorySeeder: CPU, GPU, RAM, SSD, Motherboard, PSU
// AdminUserSeeder: 1 admin user (role='admin')
// Relationships: Product->Category, User->Orders, Order->OrderItems
```

---

#### 4️⃣ **Nguyễn Duy Phương**
**Vai trò**: Frontend - Views (Products)

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 4.1 | **Tạo `resources/views/products/index.blade.php`** | 🔴 CAO | 13/11 | ⏳ |
| 4.2 | Tạo `resources/views/products/show.blade.php` | 🔴 CAO | 14/11 | ⏳ |
| 4.3 | Thêm search & filter UI | 🟡 TRUNG | 15/11 | ⏳ |
| 4.4 | Styling responsive (mobile/tablet/desktop) | 🟡 TRUNG | 16/11 | ⏳ |

**Chi tiết:**
- Products index: Grid layout 4 cột trên desktop, 2 cột trên tablet, 1 cột mobile
- Products show: 2 cột (ảnh + info)
- Dùng Tailwind CSS + Alpine.js cho interactivity
- Pagination: 12 sản phẩm/trang

---

#### 5️⃣ **Trần Thanh Huy**
**Vai trò**: Frontend - Views (Cart)

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 5.1 | **Tạo `resources/views/cart/index.blade.php`** | 🔴 CAO | 14/11 | ⏳ |
| 5.2 | Thêm "Add to Cart" button trên product pages | 🔴 CAO | 14/11 | ⏳ |
| 5.3 | Cart toast notifications (Alpine.js) | 🟡 TRUNG | 15/11 | ⏳ |
| 5.4 | Bắt đầu Selenium tests | 🟡 TRUNG | 16/11 | ⏳ |

**Chi tiết:**
- Cart view: Hiển thị danh sách items với qty, price, total
- Buttons: Update qty, Remove item, Clear cart, Checkout
- Toast: "Thêm vào giỏ hàng thành công", "Xóa khỏi giỏ hàng"
- Tests: Add to cart, Update qty, Remove item scenarios

---

#### 6️⃣ **Trần Tuấn Minh**
**Vai trò**: Frontend - Views (Admin Dashboard)

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 6.1 | **Tạo admin dashboard layout** | 🟡 TRUNG | 13/11 | ⏳ |
| 6.2 | Dashboard stats (Sales, Orders, Users) | 🟡 TRUNG | 14/11 | ⏳ |
| 6.3 | Sidebar navigation + menu | 🟡 TRUNG | 15/11 | ⏳ |
| 6.4 | Styling admin theme | 🟡 TRUNG | 16/11 | ⏳ |

**Chi tiết:**
- Admin layout: Sidebar + top navbar
- Dashboard: 4 stat cards (Total Revenue, Total Orders, Total Users, Total Products)
- Navigation: Products, Orders, Users, Categories, Reports
- Color scheme: Dark theme với accent colors (blue, green, red)

---

### TUẦN 2: Hoàn Thiện Chức Năng Cao Cấp

#### 7️⃣ **Hoàng Bảo Long**
**Vai trò**: Backend - Checkout + Orders

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 7.1 | **Tạo CheckoutController** | 🔴 CAO | 19/11 | ⏳ |
| 7.2 | Tạo OrderController | 🔴 CAO | 19/11 | ⏳ |
| 7.3 | Thêm order status workflow | 🟡 TRUNG | 20/11 | ⏳ |
| 7.4 | Tạo Order + OrderItem models | 🔴 CAO | 19/11 | ⏳ |

**Chi tiết:**
- Checkout: Form 3 steps (Shipping, Payment, Confirmation)
- OrderController: index (user's orders), show (order detail), cancel
- Order statuses: pending → processing → shipped → delivered
- Tests: Create order, Update status, Cancel order

---

#### 8️⃣ **Ngụy Công Vũ Trung**
**Vai trò**: Backend - Admin CRUD

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 8.1 | **Tạo AdminProductController (CRUD)** | 🔴 CAO | 19/11 | ⏳ |
| 8.2 | Tạo AdminOrderController | 🟡 TRUNG | 20/11 | ⏳ |
| 8.3 | Tạo AdminMiddleware + policies | 🔴 CAO | 19/11 | ⏳ |
| 8.4 | Thêm product image upload | 🟡 TRUNG | 21/11 | ⏳ |

**Chi tiết:**
- AdminProductController: index, create, store, edit, update, destroy
- AdminOrderController: index, show, updateStatus
- AdminMiddleware: Kiểm tra role='admin'
- Image upload: Lưu vào `storage/app/public/products/`

---

#### 9️⃣ **Lương Tuấn Vỹ**
**Vai trò**: Backend - Migrations + Factories

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 9.1 | **Kiểm tra tất cả migrations** | 🟡 TRUNG | 18/11 | ⏳ |
| 9.2 | Tạo ProductFactory | 🟡 TRUNG | 19/11 | ⏳ |
| 9.3 | Tạo OrderFactory | 🟡 TRUNG | 19/11 | ⏳ |
| 9.4 | Tối ưu hóa queries (N+1 problem) | 🟡 TRUNG | 21/11 | ⏳ |

**Chi tiết:**
- ProductFactory: Tạo random products cho testing
- OrderFactory: Tạo random orders + items
- Eager load relationships: Product::with('category'), Order::with('items')
- Thêm indices cho performance

---

#### 🔟 **Nguyễn Duy Phương**
**Vai trò**: Frontend - Checkout + User Pages

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 10.1 | **Tạo `resources/views/checkout/index.blade.php`** | 🔴 CAO | 19/11 | ⏳ |
| 10.2 | Tạo `resources/views/orders/index.blade.php` | 🟡 TRUNG | 20/11 | ⏳ |
| 10.3 | Tạo `resources/views/orders/show.blade.php` | 🟡 TRUNG | 20/11 | ⏳ |
| 10.4 | Tạo payment form (mock payment) | 🟡 TRUNG | 21/11 | ⏳ |

**Chi tiết:**
- Checkout: 3-step form (Shipping info → Payment → Confirmation)
- Orders index: Bảng danh sách orders (date, status, total)
- Orders show: Chi tiết order + items, có nút cancel (nếu pending)
- Payment: Form mock payment (không thực sự lấy tiền)

---

#### 1️⃣1️⃣ **Trần Thanh Huy**
**Vai trò**: Frontend + Testing

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 11.1 | **Tạo Order notification toasts** | 🟡 TRUNG | 19/11 | ⏳ |
| 11.2 | Error handling + validation messages | 🟡 TRUNG | 20/11 | ⏳ |
| 11.3 | Feature tests: Checkout flow | 🟡 TRUNG | 21/11 | ⏳ |
| 11.4 | Integration tests: End-to-end | 🟡 TRUNG | 22/11 | ⏳ |

**Chi tiết:**
- Notifications: Order created, Order shipped, Order delivered, Payment failed
- Validation: Email, phone, address fields
- Tests: Browse products → Add to cart → Checkout → Confirmation
- E2E tests: Complete user journey

---

#### 1️⃣2️⃣ **Nguyễn Tuấn Minh**
**Vai trò**: Admin Dashboard CRUD Views

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 12.1 | **Tạo admin product list view** | 🔴 CAO | 19/11 | ⏳ |
| 12.2 | Tạo product create/edit forms | 🔴 CAO | 20/11 | ⏳ |
| 12.3 | Tạo admin orders management view | 🟡 TRUNG | 21/11 | ⏳ |
| 12.4 | Tạo admin order status update form | 🟡 TRUNG | 21/11 | ⏳ |

**Chi tiết:**
- Products table: Name, Price, Stock, Category, Actions (Edit/Delete)
- Create/Edit form: Name, Desc, Price, Stock, Category, Image upload
- Orders table: ID, Customer, Total, Status, Date
- Status dropdown: pending → processing → shipped → delivered

---

### TUẦN 3: Testing, Tối Ưu & Bug Fix

#### 1️⃣3️⃣ **Hoàng Bảo Long**
**Vai trò**: Code review + Performance

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 13.1 | **Code review tất cả pull requests** | 🔴 CAO | 25/11 | ⏳ |
| 13.2 | Tối ưu hóa database queries | 🟡 TRUNG | 26/11 | ⏳ |
| 13.3 | Kiểm tra security (CSRF, XSS, SQL injection) | 🔴 CAO | 27/11 | ⏳ |
| 13.4 | Chuẩn bị release notes | 🟡 TRUNG | 28/11 | ⏳ |

---

#### 1️⃣4️⃣ **Ngụy Công Vũ Trung**
**Vai trò**: Unit Testing

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 14.1 | **Unit tests cho Models** | 🟡 TRUNG | 25/11 | ⏳ |
| 14.2 | Unit tests cho Controllers | 🟡 TRUNG | 26/11 | ⏳ |
| 14.3 | Coverage report (≥80%) | 🔴 CAO | 27/11 | ⏳ |
| 14.4 | Fix bugs từ testing | 🔴 CAO | 28/11 | ⏳ |

---

#### 1️⃣5️⃣ **Lương Tuấn Vỹ**
**Vai trò**: Database + Seeding

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 15.1 | **Kiểm tra data consistency** | 🟡 TRUNG | 25/11 | ⏳ |
| 15.2 | Tạo comprehensive seed data | 🟡 TRUNG | 26/11 | ⏳ |
| 15.3 | Backup + restore testing | 🟡 TRUNG | 27/11 | ⏳ |
| 15.4 | Documentation: DB schema | 🟡 TRUNG | 28/11 | ⏳ |

---

#### 1️⃣6️⃣ **Nguyễn Duy Phương**
**Vai trò**: Frontend Polish

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 16.1 | **Responsive design fixes** | 🟡 TRUNG | 25/11 | ⏳ |
| 16.2 | Accessibility check (WCAG 2.1)** | 🟡 TRUNG | 26/11 | ⏳ |
| 16.3 | Browser compatibility testing | 🟡 TRUNG | 27/11 | ⏳ |
| 16.4 | Performance optimization (Lighthouse)** | 🟡 TRUNG | 28/11 | ⏳ |

---

#### 1️⃣7️⃣ **Trần Thanh Huy**
**Vai trò**: QA + Integration Testing

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 17.1 | **Browser compatibility tests** | 🟡 TRUNG | 25/11 | ⏳ |
| 17.2 | Load testing (≥100 concurrent users)** | 🟡 TRUNG | 26/11 | ⏳ |
| 17.3 | Full regression testing | 🔴 CAO | 27/11 | ⏳ |
| 17.4 | Bug report + fixes | 🔴 CAO | 28/11 | ⏳ |

---

#### 1️⃣8️⃣ **Nguyễn Tuấn Minh**
**Vai trò**: Final Polish + Deployment

| Task | Mô tả | Ưu tiên | Deadline | Status |
|------|-------|---------|----------|--------|
| 18.1 | **Final UI/UX review** | 🟡 TRUNG | 25/11 | ⏳ |
| 18.2 | Admin panel final testing | 🟡 TRUNG | 26/11 | ⏳ |
| 18.3 | User feedback implementation | 🟡 TRUNG | 27/11 | ⏳ |
| 18.4 | Prepare deployment documentation | 🟡 TRUNG | 28/11 | ⏳ |

---

## 🚀 Quy Trình Git & Collaboration

### Branch Naming Convention
```
feature/[task-id]-[description]
bugfix/[task-id]-[description]
docs/[description]
```

**Ví dụ:**
```
feature/1.1-authentication-breeze
feature/2.1-product-controller
bugfix/17.4-checkout-payment-issue
```

### Pull Request Workflow
1. Tạo branch từ `main`: `git checkout -b feature/...`
2. Commit với prefix: `feat:`, `fix:`, `docs:`, `test:`
3. Push lên GitHub
4. Tạo Pull Request với description
5. Hoàng Bảo Long review code
6. Merge khi approved
7. Delete branch sau khi merge

### Daily Standup
- **Giờ**: 9:00 AM hàng ngày
- **Thời lượng**: 15 phút
- **Nội dung**: Công việc hôm qua → Công việc hôm nay → Blockers

### Communication
- **Chat**: Zalo/Telegram group
- **Issues**: GitHub Issues cho bugs
- **PRs**: GitHub Pull Requests cho code review
- **Docs**: Wiki/README.md cho documentation

---

## 📊 Trạng Thái Dự Án

### Tuần 1 Progress
```
□ Task 1.1-6.4: Cơ bản (16 tasks)
```

### Tuần 2 Progress
```
□ Task 7.1-12.4: Cao cấp (24 tasks)
```

### Tuần 3 Progress
```
□ Task 13.1-18.4: Testing & Release (24 tasks)
```

**Total**: 64 sub-tasks từ 18 main tasks

---

## ✅ Định nghĩa "Done"

Một task được coi là **HOÀN THÀNH** khi:

1. ✅ Code được viết đúng theo specifications
2. ✅ Có ≥ 80% test coverage
3. ✅ Passed code review (Hoàng Bảo Long)
4. ✅ Merged vào `main` branch
5. ✅ Documentation được cập nhật
6. ✅ Tested trên ≥2 browsers (Chrome, Firefox)
7. ✅ Performance: Page load ≤ 2 seconds

---

## 📚 Resources & Documentation

### Links
- **Repository**: https://github.com/duckonthemic/IS207_Final
- **Laravel Docs**: https://laravel.com/docs/10
- **Tailwind Docs**: https://tailwindcss.com/docs
- **Alpine.js**: https://alpinejs.dev/

### Local Setup
```bash
# Clone project
git clone https://github.com/duckonthemic/IS207_Final.git
cd IS207_Final

# Setup
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Run
php artisan serve
npm run dev

# Test
php artisan test
```

---

## 📞 Contact & Support

### Team Leads
- **Backend Lead**: Hoàng Bảo Long
- **Frontend Lead**: Nguyễn Duy Phương
- **QA Lead**: Trần Thanh Huy

### Issues & Questions
- Post lên Zalo group
- Hoặc create GitHub Issue
- Hoặc email: [project-email]

---

## 🎉 Deadline Cuối Cùng

**Submission**: 01/12/2025 23:59

Tất cả code phải merge vào `main` trước deadline này.

---

**Last Updated**: 11/11/2025  
**Version**: 1.0
