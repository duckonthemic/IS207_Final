# THIẾT KẾ HỆ THỐNG

## UITech E-Commerce - Hệ thống bán linh kiện máy tính

---

## Mục Lục

1. [Tổng quan hệ thống](#1-tổng-quan-hệ-thống)
2. [Kiến trúc hệ thống](#2-kiến-trúc-hệ-thống)
3. [Cách hệ thống hoạt động](#3-cách-hệ-thống-hoạt-động)
4. [Activity Diagrams](#4-activity-diagrams)
5. [Sequence Diagrams](#5-sequence-diagrams)
6. [Tổng kết cơ chế hoạt động](#6-tổng-kết-cơ-chế-hoạt-động)

---

## 1. Tổng Quan Hệ Thống

### 1.1 Mô tả dự án

**UITech E-Commerce** là hệ thống thương mại điện tử chuyên bán linh kiện máy tính, PC Gaming và thiết bị công nghệ. 

**Mục đích hoạt động**: Cung cấp nền tảng mua sắm trực tuyến cho khách hàng muốn mua linh kiện máy tính lẻ hoặc xây dựng cấu hình PC hoàn chỉnh.

### 1.2 Hai nhóm người dùng

| Vai trò | Chức năng chính | Trang truy cập |
|---------|-----------------|----------------|
| **Khách hàng (User)** | Duyệt sản phẩm, mua hàng, build PC, đánh giá | `/`, `/products`, `/cart`, `/checkout` |
| **Quản trị viên (Admin)** | Quản lý sản phẩm, đơn hàng, khuyến mãi, audit | `/admin/*` |

### 1.3 Công nghệ sử dụng

| Thành phần | Công nghệ | Vai trò trong hệ thống |
|------------|-----------|------------------------|
| **Backend Framework** | Laravel 10.x | Xử lý logic nghiệp vụ, routing, authentication |
| **Ngôn ngữ** | PHP 8.2+ | Ngôn ngữ chính của backend |
| **Database** | MySQL 8.0 | Lưu trữ dữ liệu chính |
| **Cache/Session** | Redis 7.x | Lưu session, cache queries |
| **Frontend** | Blade + Tailwind CSS + Alpine.js | Render HTML, styling, interactivity |
| **Build Tool** | Vite 4.x | Compile CSS/JS, hot reload |
| **Containerization** | Docker + Docker Compose | Môi trường development đồng nhất |
| **Authentication** | Laravel Breeze | Hệ thống đăng nhập/đăng ký |

**Giải thích lựa chọn công nghệ**:

1. **Laravel**: Framework PHP phổ biến nhất, có Eloquent ORM mạnh mẽ, Blade templating dễ dùng, cộng đồng lớn.

2. **Tailwind CSS**: Utility-first CSS framework, cho phép style trực tiếp trong HTML, không cần viết CSS riêng, tối ưu bundle size.

3. **Alpine.js**: JavaScript nhỏ gọn (15KB), thêm interactivity mà không cần Vue/React, hoạt động trực tiếp với Blade.

4. **Redis**: In-memory store cho session và cache, giảm tải database queries.

5. **Docker**: Đóng gói toàn bộ môi trường, đảm bảo chạy giống nhau trên mọi máy.

---

## 2. Kiến Trúc Hệ Thống

### 2.1 Mô Hình MVC (Model-View-Controller)

**MVC là gì?**

MVC là pattern chia ứng dụng thành 3 thành phần:
- **Model**: Xử lý dữ liệu và business logic
- **View**: Hiển thị giao diện người dùng
- **Controller**: Điều phối giữa Model và View

```mermaid
flowchart TB
    subgraph Client["BROWSER (Client)"]
        User["Người dùng"]
    end
    
    subgraph Laravel["LARAVEL APPLICATION"]
        Router["Routes<br/>(web.php)"]
        Middleware["Middleware<br/>(Auth, Admin, CSRF)"]
        Controller["Controllers<br/>(Xử lý request)"]
        Model["Models<br/>(Eloquent ORM)"]
        View["Views<br/>(Blade Templates)"]
    end
    
    subgraph Data["DATA LAYER"]
        MySQL["MySQL<br/>(24 tables)"]
        Redis["Redis<br/>(Cache/Session)"]
        Storage["Storage<br/>(Product images)"]
    end
    
    User -->|"1. HTTP Request"| Router
    Router -->|"2. Check auth"| Middleware
    Middleware -->|"3. Execute"| Controller
    Controller <-->|"4. Query/Update"| Model
    Model <-->|"5. SQL"| MySQL
    Model <-->|"6. Cache"| Redis
    Controller -->|"7. Pass data"| View
    View -->|"8. HTML Response"| User
```

**Giải thích luồng hoạt động**:

1. **HTTP Request**: User click link hoặc submit form, trình duyệt gửi request đến server

2. **Routes (web.php)**: Laravel match URL với route tương ứng
   ```php
   Route::get('/products/{product}', [ProductController::class, 'show']);
   ```

3. **Middleware**: Kiểm tra các điều kiện trước khi chạy controller
   - `auth`: Yêu cầu đăng nhập
   - `admin`: Yêu cầu role admin
   - `csrf`: Bảo vệ chống tấn công CSRF

4. **Controller**: Xử lý logic nghiệp vụ
   ```php
   public function show(Product $product)
   {
       return view('products.show', compact('product'));
   }
   ```

5. **Model (Eloquent ORM)**: Tương tác với database qua object
   ```php
   $product = Product::with('images', 'category', 'brand')->find($id);
   ```

6. **SQL Query**: Eloquent chuyển đổi thành SQL
   ```sql
   SELECT * FROM products WHERE id = ? AND deleted_at IS NULL
   ```

7. **View (Blade)**: Render HTML với data
   ```blade
   <h1>{{ $product->name }}</h1>
   <p>Giá: {{ number_format($product->price) }}đ</p>
   ```

8. **HTTP Response**: HTML được gửi về trình duyệt

---

### 2.2 Kiến Trúc 3 Tầng (3-Tier Architecture)

```mermaid
flowchart LR
    subgraph Presentation["TẦNG TRÌNH BÀY<br/>(Presentation Tier)"]
        direction TB
        Blade["Blade Templates"]
        Tailwind["Tailwind CSS"]
        Alpine["Alpine.js"]
    end
    
    subgraph Application["TẦNG ỨNG DỤNG<br/>(Application Tier)"]
        direction TB
        Controllers["Controllers"]
        Services["Services"]
        Models["Eloquent Models"]
        Middleware["Middleware"]
    end
    
    subgraph Data["TẦNG DỮ LIỆU<br/>(Data Tier)"]
        direction TB
        MySQL["MySQL 8.0<br/>(24 tables)"]
        Redis["Redis<br/>(Session/Cache)"]
        FileStorage["File Storage<br/>(Images)"]
    end
    
    Presentation <--> Application
    Application <--> Data
```

**Giải thích chi tiết từng tầng**:

#### Tầng 1: Presentation (Trình bày)

| Thành phần | Chức năng | Ví dụ |
|------------|-----------|-------|
| **Blade Templates** | Render HTML với syntax PHP đơn giản | `{{ $product->name }}`, `@foreach`, `@if` |
| **Tailwind CSS** | Styling với utility classes | `class="bg-blue-500 text-white p-4"` |
| **Alpine.js** | Interactivity nhỏ gọn | Dropdown menu, modal, toggle, tabs |

**Ưu điểm**:
- Blade: Syntax quen thuộc với PHP developers
- Tailwind: Không cần rời khỏi HTML để style
- Alpine: Không cần build step, hoạt động ngay trong browser

#### Tầng 2: Application (Ứng dụng)

| Thành phần | Chức năng | Ví dụ |
|------------|-----------|-------|
| **Controllers** | Xử lý requests, điều phối logic | `ProductController`, `OrderController` |
| **Services** | Business logic phức tạp, tái sử dụng | `AuditService` ghi log hoạt động |
| **Models** | ORM mapping với database | `Product::where('is_active', true)->get()` |
| **Middleware** | Filter requests | `->middleware('auth')`, `->middleware('admin')` |

**Eloquent ORM hoạt động thế nào**:

```php
// PHP Code
$products = Product::where('category_id', 1)
    ->where('is_active', true)
    ->with('images')
    ->orderBy('price', 'desc')
    ->paginate(12);

// Eloquent tự động chuyển thành SQL:
SELECT * FROM products 
WHERE category_id = 1 AND is_active = 1 AND deleted_at IS NULL
ORDER BY price DESC
LIMIT 12 OFFSET 0
```

#### Tầng 3: Data (Dữ liệu)

| Thành phần | Chức năng | Cấu hình |
|------------|-----------|----------|
| **MySQL 8.0** | Lưu trữ chính | 24 tables, InnoDB engine, utf8mb4 charset |
| **Redis** | Cache và Session | Session driver, query cache |
| **File Storage** | Lưu ảnh sản phẩm | `storage/app/public/images/products/` |

---

### 2.3 Cấu Trúc Thư Mục Project

```
pc-parts-e-store-boilerplate/
├── app/                           # Code PHP chính
│   ├── Http/
│   │   ├── Controllers/           # Xử lý HTTP requests
│   │   │   ├── Admin/             # Controllers cho admin panel
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── PromotionController.php
│   │   │   │   ├── ReviewController.php
│   │   │   │   └── AuditLogController.php
│   │   │   ├── Auth/              # Controllers cho authentication
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ReviewController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php    # Kiểm tra quyền admin
│   ├── Models/                    # Eloquent Models
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Category.php
│   │   ├── Cart.php
│   │   ├── Promotion.php
│   │   ├── ProductReview.php
│   │   └── AuditLog.php
│   ├── Services/
│   │   └── AuditService.php       # Service ghi audit log
│   └── Providers/
│
├── database/
│   ├── migrations/                # Định nghĩa cấu trúc database
│   └── seeders/                   # Seed data mẫu
│
├── resources/
│   └── views/                     # Blade templates
│       ├── admin/                 # Views cho admin panel
│       ├── checkout/              # Views checkout flow
│       ├── orders/                # Views đơn hàng
│       ├── products/              # Views sản phẩm
│       ├── cart/                  # Views giỏ hàng
│       ├── layouts/               # Layout chung (header, footer)
│       └── components/            # Blade components tái sử dụng
│
├── routes/
│   ├── web.php                    # Routes cho web
│   └── auth.php                   # Routes cho authentication
│
├── public/
│   └── images/products/           # Ảnh sản phẩm
│
└── docker-compose.yml             # Docker configuration
```

---

### 2.4 Request Lifecycle (Vòng đời một Request)

```mermaid
sequenceDiagram
    participant Browser
    participant Nginx
    participant Laravel
    participant Middleware
    participant Router
    participant Controller
    participant Model
    participant MySQL
    participant View
    participant Redis
    
    Browser->>Nginx: GET /products/intel-core-i7
    Nginx->>Laravel: Forward request
    
    Note over Laravel: Bootstrap application
    Laravel->>Redis: Load session
    Redis-->>Laravel: Session data
    
    Laravel->>Middleware: Run global middleware
    Note over Middleware: VerifyCsrfToken<br/>HandleCors<br/>StartSession
    
    Middleware->>Router: Match route
    Note over Router: Route: /products/{product}<br/>Controller: ProductController@show
    
    Router->>Middleware: Run route middleware
    
    Middleware->>Controller: Execute ProductController::show()
    
    Controller->>Model: Product::with('images', 'reviews')->find()
    Model->>MySQL: SELECT * FROM products...
    MySQL-->>Model: Result rows
    Model-->>Controller: Product object
    
    Controller->>View: return view('products.show', $product)
    Note over View: Render Blade template<br/>Apply Tailwind CSS
    View-->>Controller: HTML string
    
    Controller-->>Browser: HTTP 200 + HTML
    
    Note over Browser: Render HTML<br/>Execute Alpine.js
```

**Giải thích từng bước**:

| Bước | Thành phần | Hoạt động |
|------|------------|-----------|
| 1 | Browser → Nginx | Request HTTP được gửi đến web server |
| 2 | Nginx → Laravel | Nginx forward request tới PHP-FPM chạy Laravel |
| 3 | Laravel → Redis | Khôi phục session của user từ Redis |
| 4 | Global Middleware | Kiểm tra CSRF token, xử lý CORS |
| 5 | Router | Match URL `/products/intel-core-i7` với route pattern |
| 6 | Route Middleware | Chạy middleware của route (nếu có) |
| 7 | Controller | Execute method `show()` của `ProductController` |
| 8 | Model → MySQL | Eloquent query lấy product và relationships |
| 9 | View | Blade render HTML với data từ controller |
| 10 | Response | HTML được gửi về browser |
| 11 | Browser | Render HTML, chạy Alpine.js cho interactivity |

---

## 3. Cách Hệ Thống Hoạt Động

### 3.1 Luồng Đăng Ký / Đăng Nhập

```mermaid
flowchart TD
    A[User truy cập /register] --> B{Đã đăng nhập?}
    B -->|Có| C[Redirect về /]
    B -->|Không| D[Hiển thị form đăng ký]
    D --> E[User điền form]
    E --> F[Submit POST /register]
    F --> G[Validate dữ liệu]
    G -->|Invalid| H[Hiện lỗi validation]
    H --> D
    G -->|Valid| I[Hash password với bcrypt]
    I --> J[Tạo record USERS]
    J --> K[Auto login]
    K --> L[Redirect về /]
```

**Chi tiết xử lý**:

```php
// RegisteredUserController.php
public function store(Request $request)
{
    // Bước 1: Validate
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Bước 2: Tạo user với password đã hash
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Mã hóa bcrypt
        'role' => 'user', // Mặc định role user
    ]);

    // Bước 3: Kích hoạt session
    Auth::login($user);

    return redirect('/');
}
```

---

### 3.2 Luồng Xem Sản Phẩm

```mermaid
flowchart TD
    A[User truy cập /products] --> B[ProductController::index]
    B --> C[Lấy filter từ query string]
    C --> D{Có filter?}
    D -->|Có| E[Apply filters: category, brand, price, search]
    D -->|Không| F[Query tất cả products]
    E --> G[Eager load: images, category, brand]
    F --> G
    G --> H[Paginate 12 items/page]
    H --> I[Return view với products]
    I --> J[Blade render product grid]
    J --> K[User xem danh sách]
```

**Query với Filter**:

```php
// ProductController.php
public function index(Request $request)
{
    $query = Product::query()
        ->with(['images', 'category', 'brand']) // Eager loading
        ->where('is_active', true);

    // Filter theo category
    if ($request->category) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // Filter theo khoảng giá
    if ($request->min_price) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->max_price) {
        $query->where('price', '<=', $request->max_price);
    }

    // Tìm kiếm
    if ($request->search) {
        $query->where('name', 'like', "%{$request->search}%");
    }

    // Sắp xếp
    $query->orderBy($request->sort ?? 'created_at', $request->order ?? 'desc');

    $products = $query->paginate(12);

    return view('products.index', compact('products'));
}
```

---

### 3.3 Luồng Mua Hàng (Add to Cart → Checkout → Order)

```mermaid
flowchart TD
    subgraph AddToCart["1. THÊM VÀO GIỎ"]
        A1[User click Add to Cart] --> A2[CartController::add]
        A2 --> A3{User đã có cart?}
        A3 -->|Không| A4[Tạo cart mới]
        A3 -->|Có| A5[Lấy cart hiện tại]
        A4 --> A6
        A5 --> A6[Thêm/Update cart_item]
        A6 --> A7[Redirect về trang sản phẩm]
    end
    
    subgraph Checkout["2. CHECKOUT"]
        B1[User vào /checkout] --> B2[Lấy cart items]
        B2 --> B3[Hiển thị form shipping]
        B3 --> B4[User điền thông tin]
        B4 --> B5[Chọn payment method]
        B5 --> B6[Nhập mã giảm giá]
        B6 --> B7{Mã hợp lệ?}
        B7 -->|Có| B8[Tính discount]
        B7 -->|Không| B9[Thông báo lỗi]
        B8 --> B10[Review order]
    end
    
    subgraph PlaceOrder["3. ĐẶT HÀNG"]
        C1[User click Đặt hàng] --> C2[Validate dữ liệu]
        C2 --> C3[BEGIN TRANSACTION]
        C3 --> C4[Tạo record ORDERS]
        C4 --> C5[Tạo ORDER_ITEMS]
        C5 --> C6[Trừ stock sản phẩm]
        C6 --> C7[Áp dụng promotion]
        C7 --> C8[Update cart status = ordered]
        C8 --> C9[COMMIT]
        C9 --> C10[Redirect Order Success]
    end
    
    A7 --> B1
    B10 --> C1
```

**Chi tiết code xử lý checkout**:

```php
// CheckoutController.php
public function placeOrder(Request $request)
{
    DB::beginTransaction();
    try {
        $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();
        
        // 1. Tạo order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_code' => 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT),
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $cart->items->sum(fn($item) => $item->price * $item->qty),
            'shipping_fee' => $request->shipping_fee,
            'discount' => $request->discount ?? 0,
            'total' => $total,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'placed_at' => now(),
        ]);

        // 2. Tạo order items + trừ stock
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->price,
                'qty' => $item->qty,
            ]);

            $item->product->decrement('stock', $item->qty);
        }

        // 3. Áp dụng promotion
        if ($request->promotion_id) {
            OrderPromotion::create([
                'order_id' => $order->id,
                'promotion_id' => $request->promotion_id,
                'discount_amount' => $request->discount,
            ]);
            Promotion::find($request->promotion_id)->increment('usage_count');
        }

        // 4. Update cart status
        $cart->update(['status' => 'ordered']);

        DB::commit();
        return redirect()->route('orders.show', $order);

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Đặt hàng thất bại!');
    }
}
```

---

### 3.4 Luồng Admin Quản Lý Sản Phẩm

```mermaid
flowchart TD
    A[Admin truy cập /admin/products] --> B[Middleware kiểm tra role=admin]
    B -->|Không phải admin| C[Redirect về / với lỗi 403]
    B -->|OK| D[ProductController::index]
    D --> E[Hiển thị danh sách products]
    
    E --> F{Thao tác?}
    F -->|Tạo mới| G[Form tạo product]
    F -->|Sửa| H[Form edit product]
    F -->|Xóa| I[Confirm modal]
    
    G --> J[Validate + Create]
    H --> K[Validate + Update]
    I --> L[Soft Delete]
    
    J --> M[AuditService::log create]
    K --> M
    L --> M
    
    M --> N[Ghi vào audit_logs table]
    N --> O[Redirect với success message]
```

**Audit Log hoạt động**:

```php
// AuditService.php
class AuditService
{
    public static function log(string $action, Model $model, ?array $oldValues = null): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => $action, // 'create', 'update', 'delete'
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'model_name' => $model->name ?? $model->title ?? "#{$model->id}",
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => json_encode($model->toArray()),
            'ip_address' => request()->ip(),
        ]);
    }
}

// Sử dụng trong controller
public function store(Request $request)
{
    $product = Product::create($validated);
    AuditService::log('create', $product);
    return redirect()->route('admin.products.index');
}
```

---

## 4. Activity Diagrams

### 4.1 Activity Diagram: Xử Lý Trạng Thái Đơn Hàng

```mermaid
stateDiagram-v2
    [*] --> Pending: Đặt hàng
    
    Pending --> Processing: Admin xác nhận
    Pending --> Cancelled: User/Admin hủy
    
    Processing --> Picking: Chuẩn bị hàng
    Processing --> Cancelled: Hết hàng
    
    Picking --> Shipped: Giao cho vận chuyển
    
    Shipped --> Delivered: Giao thành công
    Shipped --> Shipped: Đang giao
    
    Delivered --> [*]: Hoàn thành
    Delivered --> Refunded: Hoàn tiền
    
    Cancelled --> [*]
    Refunded --> [*]
```

**Giải thích từng trạng thái**:

| Trạng thái | Mô tả | Cho phép chuyển sang |
|------------|-------|---------------------|
| **pending** | Đơn hàng mới đặt, chờ xác nhận | processing, cancelled |
| **processing** | Đã xác nhận, đang xử lý | picking, cancelled |
| **picking** | Đang lấy hàng từ kho | shipped |
| **shipped** | Đã giao cho đơn vị vận chuyển | delivered |
| **delivered** | Giao hàng thành công | refunded, (end) |
| **cancelled** | Đơn hàng bị hủy | (end) |
| **refunded** | Đã hoàn tiền | (end) |

---

### 4.2 Activity Diagram: Build PC

```mermaid
flowchart TD
    Start([Bắt đầu]) --> SelectBudget[Chọn ngân sách/tier]
    SelectBudget --> LoadComponents[Load danh sách component types]
    
    LoadComponents --> SelectCPU[Chọn CPU]
    SelectCPU --> SelectMainboard[Chọn Mainboard]
    
    Note1[Filter theo socket tương thích]
    SelectMainboard --> Note1
    
    SelectMainboard --> SelectRAM[Chọn RAM]
    SelectRAM --> SelectVGA[Chọn VGA]
    SelectVGA --> SelectSSD[Chọn SSD]
    SelectSSD --> SelectPSU[Chọn PSU]
    SelectPSU --> SelectCase[Chọn Case]
    SelectCase --> SelectCooling[Chọn Cooling]
    
    SelectCooling --> CalculateTotal[Tính tổng giá]
    CalculateTotal --> Review{Review cấu hình}
    
    Review -->|Thay đổi| SelectBudget
    Review -->|OK| AddToCart[Thêm tất cả vào giỏ]
    AddToCart --> End([Kết thúc])
```

---

## 5. Sequence Diagrams

### 5.1 Sequence Diagram: Checkout Flow

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant CheckoutController
    participant CartModel
    participant OrderModel
    participant ProductModel
    participant PromotionModel
    participant Database
    participant View

    User->>Browser: Click "Thanh toán"
    Browser->>CheckoutController: GET /checkout
    
    CheckoutController->>CartModel: Lấy cart của user
    CartModel->>Database: SELECT * FROM carts, cart_items, products
    Database-->>CartModel: Cart data
    CartModel-->>CheckoutController: Cart object với items
    
    CheckoutController->>View: Render checkout form
    View-->>Browser: HTML form
    
    User->>Browser: Điền form + Submit
    Browser->>CheckoutController: POST /checkout/place-order
    
    CheckoutController->>Database: BEGIN TRANSACTION
    
    CheckoutController->>OrderModel: Create order
    OrderModel->>Database: INSERT INTO orders
    
    loop Mỗi cart item
        CheckoutController->>OrderModel: Create order_item
        OrderModel->>Database: INSERT INTO order_items
        
        CheckoutController->>ProductModel: Trừ stock
        ProductModel->>Database: UPDATE products SET stock = stock - qty
    end
    
    alt Có mã giảm giá
        CheckoutController->>PromotionModel: Validate + apply
        PromotionModel->>Database: UPDATE promotions SET usage_count++
        PromotionModel->>Database: INSERT INTO order_promotions
    end
    
    CheckoutController->>CartModel: Update status = ordered
    CartModel->>Database: UPDATE carts SET status = 'ordered'
    
    CheckoutController->>Database: COMMIT
    
    CheckoutController-->>Browser: Redirect /orders/{id}
    Browser-->>User: Hiển thị Order Success
```

---

### 5.2 Sequence Diagram: Product Review

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant OrderPage
    participant ReviewController
    participant OrderItemModel
    participant ProductReviewModel
    participant Database

    User->>Browser: Xem chi tiết đơn hàng đã giao
    Browser->>OrderPage: GET /orders/{id}
    
    OrderPage->>Database: Check order.status
    Database-->>OrderPage: status = 'delivered'
    
    OrderPage->>Database: Lấy products chưa review
    Database-->>OrderPage: Unreviewed products
    
    OrderPage-->>Browser: Hiển thị form review
    
    User->>Browser: Chọn rating + viết comment
    Browser->>ReviewController: POST /products/{id}/reviews
    
    ReviewController->>OrderItemModel: Kiểm tra đã mua?
    OrderItemModel->>Database: SELECT FROM order_items WHERE product_id AND status='delivered'
    Database-->>OrderItemModel: Có record
    OrderItemModel-->>ReviewController: Đã mua ✓
    
    ReviewController->>ProductReviewModel: Kiểm tra đã review?
    ProductReviewModel->>Database: SELECT FROM product_reviews WHERE user_id AND product_id
    Database-->>ProductReviewModel: Chưa có
    ProductReviewModel-->>ReviewController: Chưa review ✓
    
    ReviewController->>ProductReviewModel: Create review
    ProductReviewModel->>Database: INSERT INTO product_reviews (rating, comment, status='pending')
    Database-->>ProductReviewModel: Created
    
    ReviewController-->>Browser: Success message
    Browser-->>User: "Đánh giá sẽ hiển thị sau khi được duyệt"
```

---

## 6. Tổng Kết Cơ Chế Hoạt Động

### 6.1 Tổng quan Flow chính

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           UITech E-Commerce                              │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │  Browse  │ →  │   Add    │ →  │ Checkout │ →  │  Order   │          │
│  │ Products │    │ to Cart  │    │          │    │ Tracking │          │
│  └──────────┘    └──────────┘    └──────────┘    └──────────┘          │
│       ↓               ↓               ↓               ↓                 │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │ PRODUCTS │    │ CARTS    │    │ ORDERS   │    │ REVIEWS  │          │
│  │ Table    │    │ Table    │    │ Table    │    │ Table    │          │
│  └──────────┘    └──────────┘    └──────────┘    └──────────┘          │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### 6.2 Các cơ chế bảo mật

| Cơ chế | Implementation | Mục đích |
|--------|----------------|----------|
| **Authentication** | Laravel Breeze + Session | Xác thực người dùng |
| **Authorization** | AdminMiddleware | Phân quyền admin/user |
| **CSRF Protection** | `@csrf` token trong form | Chống tấn công CSRF |
| **Password Hashing** | bcrypt với cost 12 | Bảo mật mật khẩu |
| **SQL Injection** | Eloquent ORM + Prepared statements | Chống SQL injection |
| **XSS Protection** | Blade `{{ }}` auto-escape | Chống XSS |
| **Soft Deletes** | `deleted_at` column | Khôi phục data khi cần |
| **Audit Logs** | AuditService | Theo dõi hoạt động admin |

### 6.3 Các điểm tối ưu performance

| Kỹ thuật | Áp dụng | Lợi ích |
|----------|---------|---------|
| **Eager Loading** | `Product::with('images', 'category')` | Tránh N+1 query |
| **Database Indexes** | `idx_category_id`, `idx_brand_id` | Query nhanh hơn |
| **Redis Session** | `SESSION_DRIVER=redis` | Giảm tải database |
| **Pagination** | `->paginate(12)` | Không load toàn bộ data |
| **Soft Deletes** | `deleted_at` thay vì DELETE | Preserve data, query nhanh |

---

## Tài Liệu Liên Quan

- [ERD_DIAGRAM.md](ERD_DIAGRAM.md) - Sơ đồ ERD chi tiết tất cả 24 bảng
- [ERD_SCHEMA.sql](ERD_SCHEMA.sql) - SQL schema đầy đủ

---

Cập nhật: 13/12/2025
