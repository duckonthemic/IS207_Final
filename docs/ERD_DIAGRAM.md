# 📊 Mô Hình ERD (Entity Relationship Diagram)

**UITech - Hệ Thống E-Commerce Bán Linh Kiện Máy Tính**

---

## 🗺️ Sơ Đồ Tổng Quan (Overview)

```
┌─────────────────────────────────────────────────────────────────┐
│                      USER MANAGEMENT                             │
│  ┌──────────────┐                                                │
│  │   USERS      │ (role: user/admin)                             │
│  │   - id PK    │ 1 ──────────┐                                  │
│  │   - name     │             │                                  │
│  │   - email    │             M                                  │
│  │   - role     │             │                                  │
│  └──────────────┘             │                                  │
└─────────────────────────────────────────────────────────────────┘
           │                     │                    
           │ 1                   │                    
           ├─────────────────────┼──────────────────┬──────┐
           │                     │                  │      │
        (owns)              (owns)              (owns) (places)
           │                     │                  │      │
           M                     M                  M      M
           │                     │                  │      │
    ┌──────▼──────┐      ┌───────▼───────┐  ┌─────▼───┐  ┌────────────┐
    │    CARTS     │      │   ORDERS      │  │ REVIEWS │  │ USER_INFO  │
    │  - id PK     │      │  - id PK      │  │ - id PK │  │ - id PK    │
    │  - user_id FK│──────│  - user_id FK │  │ (future)│  │ - user_id FK
    │  - status    │      │  - order_code │  └────────┘  │ - phone    │
    │  - timestamps│      │  - total      │              │ - address  │
    └──────┬───────┘      │  - status     │              │ - city     │
           │              │  - timestamps │              └────────────┘
           │              └───────┬───────┘
           │                      │
           │ 1                    │ 1
           │                      │
           M                      M
           │                      │
    ┌──────▼─────────────┐  ┌─────▼──────────────┐
    │  CART_ITEMS        │  │  ORDER_ITEMS       │
    │  - id PK           │  │  - id PK           │
    │  - cart_id FK      │  │  - order_id FK     │
    │  - product_id FK   │  │  - product_id FK   │
    │  - qty             │  │  - qty             │
    │  - price           │  │  - price           │
    └─────┬──────────────┘  └──────┬─────────────┘
          │                        │
          └────────────┬───────────┘
                       │ (references)
                       │ 1
                       │
                 ┌─────▼────────────┐
                 │   PRODUCTS       │
                 │  - id PK         │
                 │  - name          │
                 │  - slug          │
                 │  - price         │
                 │  - sale_price    │
                 │  - sku           │
                 │  - stock         │
                 │  - brand         │
                 │  - description   │
                 │  - specifications│ (JSON)
                 │  - image         │
                 │  - category_id FK│
                 └─────▲────────────┘
                       │ 1
                       │
                       │ (has many images)
                       │ 1
          ┌────────────┴─────────────┐
          │                          │
          M                          M
          │                          │
   ┌──────▼───────────┐    ┌────────▼────────┐
   │PRODUCT_IMAGES    │    │  CATEGORIES     │
   │ - id PK          │    │  - id PK        │
   │ - product_id FK  │    │  - parent_id FK │
   │ - url            │    │  - name         │
   │ - is_primary     │    │  - slug         │
   │ - sort_order     │    │  - depth        │
   └──────────────────┘    │  - description  │
                           │  - image        │
                           │  - status       │
                           └─────────────────┘
```

---

## 📋 Chi Tiết Từng Bảng

### 1️⃣ **USERS** (Người Dùng)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `name` | VARCHAR(255) | Tên người dùng |
| `email` | VARCHAR(255) | Email (unique) |
| `email_verified_at` | TIMESTAMP | Xác minh email |
| `password` | VARCHAR(255) | Mật khẩu (hash) |
| `role` | ENUM (user/admin) | Quyền hạn |
| `remember_token` | VARCHAR(100) | Token nhớ đăng nhập |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- 1 User → N Carts (giỏ hàng)
- 1 User → N Orders (đơn hàng)
- 1 User → 1 UserInfo (thông tin cá nhân)

---

### 2️⃣ **CATEGORIES** (Danh Mục)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `parent_id` | BIGINT (FK) | Danh mục cha (tree structure) |
| `name` | VARCHAR(255) | Tên danh mục |
| `slug` | VARCHAR(255) | Slug URL (unique) |
| `depth` | TINYINT | Độ sâu trong cây danh mục |
| `description` | TEXT | Mô tả |
| `image` | VARCHAR(255) | Hình ảnh |
| `status` | TINYINT | Trạng thái (0/1) |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- 1 Category → N Products
- 1 Category → N Categories (cây danh mục)

---

### 3️⃣ **PRODUCTS** (Sản Phẩm)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `category_id` | BIGINT (FK) | Danh mục |
| `name` | VARCHAR(255) | Tên sản phẩm |
| `slug` | VARCHAR(255) | Slug URL (unique) |
| `description` | TEXT | Mô tả chi tiết |
| `price` | DECIMAL(12,2) | Giá gốc |
| `sale_price` | DECIMAL(12,2) | Giá khuyến mãi (nullable) |
| `sku` | VARCHAR(255) | Mã SKU (unique) |
| `stock` | INT | Tồn kho |
| `brand` | VARCHAR(255) | Nhãn hiệu |
| `specifications` | JSON | Thông số kỹ thuật |
| `image` | VARCHAR(255) | Hình ảnh chính |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- N Products → 1 Category
- 1 Product → N ProductImages
- 1 Product → N CartItems
- 1 Product → N OrderItems

---

### 4️⃣ **PRODUCT_IMAGES** (Hình Ảnh Sản Phẩm)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `product_id` | BIGINT (FK) | Sản phẩm |
| `url` | VARCHAR(255) | Đường dẫn hình ảnh |
| `is_primary` | BOOLEAN | Ảnh chính |
| `sort_order` | SMALLINT | Thứ tự sắp xếp |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- N ProductImages → 1 Product

---

### 5️⃣ **CARTS** (Giỏ Hàng)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `user_id` | BIGINT (FK) | Người dùng |
| `status` | ENUM (active/ordered) | Trạng thái |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- N Carts → 1 User
- 1 Cart → N CartItems

---

### 6️⃣ **CART_ITEMS** (Chi Tiết Giỏ Hàng)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `cart_id` | BIGINT (FK) | Giỏ hàng |
| `product_id` | BIGINT (FK) | Sản phẩm |
| `price` | DECIMAL(12,2) | Giá lúc thêm |
| `qty` | INT | Số lượng |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- N CartItems → 1 Cart
- N CartItems → 1 Product
- **Unique Constraint**: (cart_id, product_id)

---

### 7️⃣ **ORDERS** (Đơn Hàng)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `user_id` | BIGINT (FK) | Người dùng |
| `order_code` | VARCHAR(50) | Mã đơn hàng (unique) |
| `payment_status` | ENUM | Trạng thái thanh toán: pending/paid/failed/refunded |
| `status` | ENUM | Trạng thái đơn: pending/paid/picking/shipped/delivered/cancelled/refunded |
| `total` | DECIMAL(12,2) | Tổng tiền |
| `placed_at` | TIMESTAMP | Thời gian đặt hàng |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- N Orders → 1 User
- 1 Order → N OrderItems

---

### 8️⃣ **ORDER_ITEMS** (Chi Tiết Đơn Hàng)
| Trường | Kiểu | Mô Tả |
|--------|------|-------|
| `id` | BIGINT (PK) | Khóa chính |
| `order_id` | BIGINT (FK) | Đơn hàng |
| `product_id` | BIGINT (FK) | Sản phẩm |
| `price` | DECIMAL(12,2) | Giá lúc mua |
| `qty` | INT | Số lượng |
| `created_at` | TIMESTAMP | Ngày tạo |
| `updated_at` | TIMESTAMP | Ngày cập nhật |

**Quan hệ**:
- N OrderItems → 1 Order
- N OrderItems → 1 Product
- **Unique Constraint**: (order_id, product_id)

---

## 📊 Mô Hình Quan Hệ (Relationship)

### Cardinality Notation:
- `1` = One
- `N` / `M` = Many

### Relationship Types:

#### 1. **One-to-Many (1-N)**
```
User (1) ─────────→ (N) Orders
         ─────────→ (N) Carts
         
Category (1) ─────→ (N) Products

Order (1) ──────→ (N) OrderItems

Cart (1) ───────→ (N) CartItems

Product (1) ────→ (N) ProductImages
        ────────→ (N) CartItems
        ────────→ (N) OrderItems
```

#### 2. **Self-Referencing**
```
Category (1) ─────→ (N) Categories
         ↑           (parent-child hierarchy)
         └─── parent_id FK
```

#### 3. **Many-to-Many (implicit)**
```
User ─── (through Order) ─── Product
         ─── (through Cart) ─── Product
```

---

## 🔑 Foreign Key Constraints

| FK | References | Action |
|----|-----------|--------|
| `products.category_id` | categories.id | CASCADE DELETE |
| `product_images.product_id` | products.id | CASCADE DELETE |
| `cart_items.cart_id` | carts.id | CASCADE DELETE |
| `cart_items.product_id` | products.id | CASCADE DELETE |
| `carts.user_id` | users.id | CASCADE DELETE |
| `order_items.order_id` | orders.id | CASCADE DELETE |
| `order_items.product_id` | products.id | CASCADE DELETE |
| `orders.user_id` | users.id | CASCADE DELETE |
| `categories.parent_id` | categories.id | CASCADE DELETE |

---

## 📑 Indexes (Hiệu Năng)

### Single Column Indexes:
```sql
INDEX idx_email (users.email)
INDEX idx_slug (products.slug)
INDEX idx_role (users.role)
INDEX idx_status (carts.status)
```

### Composite Indexes:
```sql
INDEX idx_user_created (orders.user_id, orders.created_at)
INDEX idx_status_payment (orders.status, orders.payment_status)
INDEX idx_parent_depth (categories.parent_id, categories.depth)
INDEX idx_product_primary (product_images.product_id, product_images.is_primary)
INDEX idx_user_status (carts.user_id, carts.status)
```

### Unique Constraints:
```sql
UNIQUE KEY uk_product_email (users.email)
UNIQUE KEY uk_category_slug (categories.slug)
UNIQUE KEY uk_product_slug (products.slug)
UNIQUE KEY uk_product_sku (products.sku)
UNIQUE KEY uk_order_code (orders.order_code)
UNIQUE KEY uk_cart_product (carts_items.cart_id, cart_items.product_id)
UNIQUE KEY uk_order_product (order_items.order_id, order_items.product_id)
```

---

## 🎯 Use Cases & Queries

### 1. **Lấy danh sách sản phẩm trong 1 danh mục**
```sql
SELECT p.* FROM products p
WHERE p.category_id = ? 
ORDER BY p.created_at DESC;
```
**Tables**: products → categories

---

### 2. **Lấy giỏ hàng của người dùng**
```sql
SELECT c.id, ci.product_id, p.name, p.price, ci.qty
FROM carts c
JOIN cart_items ci ON c.id = ci.cart_id
JOIN products p ON ci.product_id = p.id
WHERE c.user_id = ? AND c.status = 'active';
```
**Tables**: users → carts → cart_items → products

---

### 3. **Tính tổng tiền giỏ hàng**
```sql
SELECT SUM(ci.price * ci.qty) as total
FROM carts c
JOIN cart_items ci ON c.id = ci.cart_id
WHERE c.user_id = ? AND c.status = 'active';
```
**Tables**: users → carts → cart_items

---

### 4. **Lấy chi tiết đơn hàng**
```sql
SELECT o.*, oi.product_id, p.name, oi.qty, oi.price
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.id = ?;
```
**Tables**: orders → order_items → products

---

### 5. **Lấy tất cả ảnh của 1 sản phẩm**
```sql
SELECT * FROM product_images
WHERE product_id = ?
ORDER BY sort_order ASC;
```
**Tables**: products → product_images

---

### 6. **Tìm sản phẩm liên quan**
```sql
SELECT p.* FROM products p
WHERE p.category_id = ? AND p.id != ?
LIMIT 5;
```
**Tables**: products (filter by category)

---

## 📈 Data Volume Estimate

| Table | Rows | Size | Notes |
|-------|------|------|-------|
| users | ~1,000 | ~100 KB | Người dùng hệ thống |
| categories | ~20-50 | ~10 KB | Danh mục sản phẩm |
| products | ~500-1,000 | ~1 MB | Sản phẩm bán |
| product_images | ~2,000-5,000 | ~5-10 MB | Hình ảnh |
| carts | ~5,000-10,000 | ~1 MB | Giỏ hàng (active) |
| cart_items | ~10,000-50,000 | ~2-5 MB | Items trong giỏ |
| orders | ~1,000-10,000 | ~2 MB | Đơn hàng |
| order_items | ~5,000-50,000 | ~5-10 MB | Items trong đơn |

---

## 🔍 Normalization Level

**3NF (Third Normal Form)**:
- ✅ No repeating groups (1NF)
- ✅ All non-key attributes depend on primary key (2NF)
- ✅ No transitive dependencies (3NF)
- ✅ Separate tables for different entities
- ✅ Minimal data redundancy
- ✅ JSON for flexible product specifications

---

## 📝 Migration Sequence

```
1. users (no dependencies)
2. categories (self-referencing FK)
3. products (FK: category_id)
4. product_images (FK: product_id)
5. carts (FK: user_id)
6. cart_items (FK: cart_id, product_id)
7. orders (FK: user_id)
8. order_items (FK: order_id, product_id)
```

---

## 🎨 Design Notes

### JSON Field: `products.specifications`
```json
{
  "cpu": "Intel Core i9-13900K",
  "ram": "32GB DDR5",
  "storage": "1TB NVMe SSD",
  "gpu": "RTX 4090",
  "power": "1200W",
  "warranty": "3 years"
}
```

### Enum Values

**users.role**:
- `user` - Khách hàng thông thường
- `admin` - Quản trị viên

**carts.status**:
- `active` - Giỏ hàng đang sử dụng
- `ordered` - Đã chuyển thành đơn hàng

**orders.payment_status**:
- `pending` - Chờ thanh toán
- `paid` - Đã thanh toán
- `failed` - Thanh toán thất bại
- `refunded` - Hoàn tiền

**orders.status**:
- `pending` - Đơn mới
- `paid` - Đã thanh toán
- `picking` - Đang chuẩn bị
- `shipped` - Đã gửi hàng
- `delivered` - Đã giao hàng
- `cancelled` - Hủy đơn
- `refunded` - Hoàn tiền

---

## 📞 Support & Contact

**Document**: `docs/ERD_DIAGRAM.md`  
**Last Updated**: 14/11/2025  
**Database Version**: MySQL 8.0+  
**Application**: Laravel 10.x

---

