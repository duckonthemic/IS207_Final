-- =========================================================================
-- ERD DATABASE SCHEMA - E-COMMERCE LINH KIỆN MÁY TÍNH
-- =========================================================================
-- Project: IS207 Final - Computer Parts E-commerce
-- Database: MySQL 8.0+
-- Created: 2025-11-11
-- Purpose: Complete schema with indexes, constraints, and relationships

-- =========================================================================
-- TABLE: categories (Danh mục sản phẩm)
-- =========================================================================
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    parent_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    depth TINYINT UNSIGNED DEFAULT 0,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    status TINYINT UNSIGNED DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_parent_depth (parent_id, depth),
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: manufacturers (Nhà sản xuất)
-- =========================================================================
CREATE TABLE manufacturers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    logo_url VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: products (Sản phẩm)
-- =========================================================================
CREATE TABLE products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT UNSIGNED NOT NULL,
    manufacturer_id BIGINT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    price DECIMAL(12, 2) NOT NULL,
    sale_price DECIMAL(12, 2) NULL,
    sku VARCHAR(255) NOT NULL UNIQUE,
    specs_json JSON NULL,
    status SMALLINT UNSIGNED DEFAULT 1,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (manufacturer_id) REFERENCES manufacturers(id) ON DELETE SET NULL,
    FULLTEXT INDEX ft_name_desc (name, description),
    INDEX idx_category (category_id),
    INDEX idx_manufacturer (manufacturer_id),
    INDEX idx_status_created (status, created_at),
    INDEX idx_sku (sku)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: product_images (Hình ảnh sản phẩm)
-- =========================================================================
CREATE TABLE product_images (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT 0,
    sort_order SMALLINT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_primary (product_id, is_primary)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: product_specs (EAV - Thông số kỹ thuật sản phẩm)
-- =========================================================================
CREATE TABLE product_specs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    spec_key VARCHAR(255) NOT NULL,
    spec_value TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_key (product_id, spec_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: branches (Chi nhánh kho hàng)
-- =========================================================================
CREATE TABLE branches (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_code (code),
    INDEX idx_city (city)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: inventory (Tồn kho theo chi nhánh)
-- =========================================================================
CREATE TABLE inventory (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    qty INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE CASCADE,
    UNIQUE KEY uk_product_branch (product_id, branch_id),
    INDEX idx_branch_product (branch_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: stock_movements (Lịch sử thay đổi tồn kho)
-- =========================================================================
CREATE TABLE stock_movements (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    branch_id BIGINT UNSIGNED NOT NULL,
    type ENUM('IN', 'OUT', 'ADJUST') NOT NULL,
    qty_before INT UNSIGNED NOT NULL,
    qty_after INT UNSIGNED NOT NULL,
    note TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE CASCADE,
    INDEX idx_product_branch_created (product_id, branch_id, created_at),
    INDEX idx_type_created (type, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: users (Người dùng)
-- =========================================================================
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin', 'moderator') DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: user_addresses (Địa chỉ giao hàng)
-- =========================================================================
CREATE TABLE user_addresses (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NULL,
    is_default BOOLEAN DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: carts (Giỏ hàng)
-- =========================================================================
CREATE TABLE carts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    status ENUM('active', 'ordered') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_status (user_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: cart_items (Chi tiết giỏ hàng)
-- =========================================================================
CREATE TABLE cart_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    cart_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    qty INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY uk_cart_product (cart_id, product_id),
    INDEX idx_cart (cart_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: orders (Đơn hàng)
-- =========================================================================
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    order_code VARCHAR(50) NOT NULL UNIQUE,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    status ENUM('pending', 'paid', 'picking', 'shipped', 'delivered', 'cancelled', 'refunded') DEFAULT 'pending',
    total DECIMAL(12, 2) NOT NULL,
    placed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_created (user_id, created_at),
    INDEX idx_status_payment (status, payment_status),
    INDEX idx_order_code (order_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: order_items (Chi tiết đơn hàng)
-- =========================================================================
CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    qty INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY uk_order_product (order_id, product_id),
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: order_addresses (Địa chỉ giao hàng đơn)
-- =========================================================================
CREATE TABLE order_addresses (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_order (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: promotions (Khuyến mãi)
-- =========================================================================
CREATE TABLE promotions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    type ENUM('percent', 'fixed') NOT NULL,
    value DECIMAL(10, 2) NOT NULL,
    min_order DECIMAL(12, 2) DEFAULT 0,
    start_at TIMESTAMP NOT NULL,
    end_at TIMESTAMP NOT NULL,
    max_usage INT UNSIGNED NULL,
    usage_count INT UNSIGNED DEFAULT 0,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_code (code),
    INDEX idx_active (start_at, end_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: order_promotions (Khuyến mãi áp dụng cho đơn)
-- =========================================================================
CREATE TABLE order_promotions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    promotion_id BIGINT UNSIGNED NOT NULL,
    discount_value DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (promotion_id) REFERENCES promotions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_order_promotion (order_id, promotion_id),
    INDEX idx_order (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: warranties (Bảo hành)
-- =========================================================================
CREATE TABLE warranties (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_item_id BIGINT UNSIGNED NOT NULL,
    serial_no VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    status ENUM('active', 'expired', 'used', 'claimed') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE,
    INDEX idx_order_item_status (order_item_id, status),
    INDEX idx_serial (serial_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: rma_tickets (Ticket RMA - Return/Repair/Exchange)
-- =========================================================================
CREATE TABLE rma_tickets (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_item_id BIGINT UNSIGNED NOT NULL,
    status ENUM('requested', 'approved', 'repairing', 'done', 'rejected') DEFAULT 'requested',
    note TEXT NULL,
    admin_note TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE,
    INDEX idx_order_item_status (order_item_id, status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- TABLE: audit_logs (Nhật ký kiểm toán)
-- =========================================================================
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(255) NOT NULL,
    entity VARCHAR(255) NOT NULL,
    entity_id BIGINT UNSIGNED NOT NULL,
    payload_json JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_created (user_id, created_at),
    INDEX idx_entity (entity, entity_id),
    INDEX idx_action_created (action, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================================
-- VIEWS - Báo cáo doanh số
-- =========================================================================

-- View: Doanh số hàng ngày
CREATE VIEW v_sales_daily AS
SELECT
    DATE(o.placed_at) as sale_date,
    SUM(o.total) as revenue,
    COUNT(DISTINCT o.id) as order_count
FROM orders o
WHERE o.status IN ('delivered', 'paid') AND o.payment_status = 'paid'
GROUP BY DATE(o.placed_at)
ORDER BY sale_date DESC;

-- View: Top 10 sản phẩm bán chạy
CREATE VIEW v_top_products AS
SELECT
    p.id,
    p.name,
    p.slug,
    SUM(oi.qty) as total_qty,
    COUNT(DISTINCT o.id) as order_count,
    SUM(oi.qty * oi.price) as revenue
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
JOIN products p ON oi.product_id = p.id
WHERE o.status IN ('delivered', 'paid') AND o.payment_status = 'paid'
GROUP BY p.id, p.name, p.slug
ORDER BY total_qty DESC
LIMIT 10;

-- =========================================================================
-- TRIGGERS
-- =========================================================================

-- Trigger: Cập nhật inventory khi order status = 'paid'
DELIMITER $$

CREATE TRIGGER tr_reduce_inventory_on_paid
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF NEW.status = 'paid' AND NEW.payment_status = 'paid' AND OLD.payment_status != 'paid' THEN
        UPDATE inventory i
        SET i.qty = i.qty - (
            SELECT SUM(oi.qty)
            FROM order_items oi
            WHERE oi.order_id = NEW.id AND oi.product_id = i.product_id
        )
        WHERE i.product_id IN (
            SELECT product_id FROM order_items WHERE order_id = NEW.id
        );
    END IF;
END$$

DELIMITER ;

-- =========================================================================
-- STORED PROCEDURES - Hỗ trợ
-- =========================================================================

DELIMITER $$

-- Procedure: Tạo đơn hàng từ giỏ hàng
CREATE PROCEDURE sp_create_order_from_cart(
    IN p_user_id BIGINT UNSIGNED,
    IN p_shipping_address_id BIGINT UNSIGNED,
    OUT p_order_id BIGINT UNSIGNED
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_order_id = NULL;
    END;

    START TRANSACTION;

    -- Tạo đơn hàng
    INSERT INTO orders (user_id, order_code, payment_status, status, total, placed_at, created_at, updated_at)
    SELECT
        p_user_id,
        CONCAT('ORD-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(AUTO_INCREMENT, 6, '0')),
        'pending',
        'pending',
        COALESCE(SUM(ci.price * ci.qty), 0),
        NOW(),
        NOW(),
        NOW()
    FROM information_schema.TABLES
    LEFT JOIN cart_items ci ON ci.cart_id IN (
        SELECT id FROM carts WHERE user_id = p_user_id AND status = 'active'
    );

    SET p_order_id = LAST_INSERT_ID();

    -- Sao chép chi tiết giỏ hàng sang chi tiết đơn
    INSERT INTO order_items (order_id, product_id, price, qty, created_at, updated_at)
    SELECT
        p_order_id,
        ci.product_id,
        ci.price,
        ci.qty,
        NOW(),
        NOW()
    FROM cart_items ci
    WHERE ci.cart_id IN (
        SELECT id FROM carts WHERE user_id = p_user_id AND status = 'active'
    );

    -- Sao chép địa chỉ
    INSERT INTO order_addresses (order_id, fullname, phone, address, city, postal_code, created_at, updated_at)
    SELECT
        p_order_id,
        ua.fullname,
        ua.phone,
        ua.address,
        ua.city,
        ua.postal_code,
        NOW(),
        NOW()
    FROM user_addresses ua
    WHERE ua.id = p_shipping_address_id;

    -- Cập nhật giỏ hàng
    UPDATE carts SET status = 'ordered' WHERE user_id = p_user_id AND status = 'active';

    COMMIT;
END$$

DELIMITER ;

-- =========================================================================
-- SAMPLE DATA (Optional)
-- =========================================================================

-- Insert Manufacturers
INSERT INTO manufacturers (name, slug, description, created_at, updated_at) VALUES
('Intel', 'intel', 'Leading CPU manufacturer', NOW(), NOW()),
('AMD', 'amd', 'Advanced Micro Devices', NOW(), NOW()),
('NVIDIA', 'nvidia', 'GPU and chipset manufacturer', NOW(), NOW()),
('Corsair', 'corsair', 'Memory and PSU specialist', NOW(), NOW()),
('ASUS', 'asus', 'Motherboard and components', NOW(), NOW()),
('Samsung', 'samsung', 'SSD and memory manufacturer', NOW(), NOW());

-- Insert Categories
INSERT INTO categories (name, slug, depth, description, status, created_at, updated_at) VALUES
('CPU', 'cpu', 0, 'Bộ xử lý', 1, NOW(), NOW()),
('GPU', 'gpu', 0, 'Card đồ họa', 1, NOW(), NOW()),
('RAM', 'ram', 0, 'Bộ nhớ RAM', 1, NOW(), NOW()),
('SSD', 'ssd', 0, 'Ổ cứng SSD', 1, NOW(), NOW()),
('PSU', 'psu', 0, 'Nguồn điện', 1, NOW(), NOW()),
('Mainboard', 'mainboard', 0, 'Bo mạch chủ', 1, NOW(), NOW()),
('Case', 'case', 0, 'Thùng máy', 1, NOW(), NOW()),
('Peripherals', 'peripherals', 0, 'Phụ kiện', 1, NOW(), NOW());

-- Insert Branches
INSERT INTO branches (code, name, address, city, phone, email, is_active, created_at, updated_at) VALUES
('HN01', 'Hà Nội - Chi nhánh 1', '123 Nguyễn Hữu Cảnh, Hà Nội', 'Hà Nội', '0243123456', 'hn01@techparts.vn', 1, NOW(), NOW()),
('HCM01', 'TP.HCM - Chi nhánh 1', '456 Nguyễn Hàm Nghi, TP.HCM', 'TP.HCM', '0283123456', 'hcm01@techparts.vn', 1, NOW(), NOW()),
('DN01', 'Đà Nẵng - Chi nhánh 1', '789 Lê Lợi, Đà Nẵng', 'Đà Nẵng', '0363123456', 'dn01@techparts.vn', 1, NOW(), NOW());

-- =========================================================================
-- END OF SCHEMA
-- =========================================================================
