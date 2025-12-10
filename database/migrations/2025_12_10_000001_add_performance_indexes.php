<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Add indexes for better query performance
     */
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            // For filtering and sorting
            $table->index('category_id', 'idx_products_category');
            $table->index('price', 'idx_products_price');
            $table->index('created_at', 'idx_products_created_at');
            $table->index('stock', 'idx_products_stock');
            $table->index('is_active', 'idx_products_is_active');
            $table->index('is_featured', 'idx_products_is_featured');
            $table->index('component_type_id', 'idx_products_component_type');

            // Composite indexes for common query patterns
            $table->index(['category_id', 'is_active'], 'idx_products_category_active');
            $table->index(['category_id', 'price'], 'idx_products_category_price');
            $table->index(['is_active', 'created_at'], 'idx_products_active_created');
        });

        // Product specs table indexes
        Schema::table('product_specs', function (Blueprint $table) {
            $table->index('spec_definition_id', 'idx_product_specs_definition');
            $table->index(['product_id', 'spec_definition_id'], 'idx_product_specs_product_definition');
        });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id', 'idx_orders_user');
            $table->index('status', 'idx_orders_status');
            $table->index('placed_at', 'idx_orders_placed_at');
            $table->index('order_code', 'idx_orders_code');
            $table->index(['user_id', 'status'], 'idx_orders_user_status');
            $table->index(['user_id', 'placed_at'], 'idx_orders_user_placed');
        });

        // Order items table indexes
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id', 'idx_order_items_order');
            $table->index('product_id', 'idx_order_items_product');
        });

        // Cart items table indexes
        Schema::table('cart_items', function (Blueprint $table) {
            $table->index('cart_id', 'idx_cart_items_cart');
            $table->index('product_id', 'idx_cart_items_product');
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('parent_id', 'idx_categories_parent');
            $table->index('slug', 'idx_categories_slug');
            $table->index('is_active', 'idx_categories_active');
        });

        // Product reviews table indexes
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->index('product_id', 'idx_reviews_product');
            $table->index('user_id', 'idx_reviews_user');
            $table->index('status', 'idx_reviews_status');
            $table->index(['product_id', 'status'], 'idx_reviews_product_status');
        });

        // Product images table indexes
        Schema::table('product_images', function (Blueprint $table) {
            $table->index('product_id', 'idx_product_images_product');
        });

        // User addresses table indexes
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->index('user_id', 'idx_user_addresses_user');
            $table->index(['user_id', 'is_default'], 'idx_user_addresses_user_default');
        });

        // Carts table indexes
        Schema::table('carts', function (Blueprint $table) {
            $table->index('user_id', 'idx_carts_user');
            $table->index('status', 'idx_carts_status');
            $table->index(['user_id', 'status'], 'idx_carts_user_status');
        });

        // Spec definitions table indexes
        Schema::table('spec_definitions', function (Blueprint $table) {
            $table->index('component_type_id', 'idx_spec_definitions_component_type');
            $table->index('is_filterable', 'idx_spec_definitions_filterable');
            $table->index('code', 'idx_spec_definitions_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_category');
            $table->dropIndex('idx_products_price');
            $table->dropIndex('idx_products_created_at');
            $table->dropIndex('idx_products_stock');
            $table->dropIndex('idx_products_is_active');
            $table->dropIndex('idx_products_is_featured');
            $table->dropIndex('idx_products_component_type');
            $table->dropIndex('idx_products_category_active');
            $table->dropIndex('idx_products_category_price');
            $table->dropIndex('idx_products_active_created');
        });

        Schema::table('product_specs', function (Blueprint $table) {
            $table->dropIndex('idx_product_specs_definition');
            $table->dropIndex('idx_product_specs_product_definition');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_user');
            $table->dropIndex('idx_orders_status');
            $table->dropIndex('idx_orders_placed_at');
            $table->dropIndex('idx_orders_code');
            $table->dropIndex('idx_orders_user_status');
            $table->dropIndex('idx_orders_user_placed');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('idx_order_items_order');
            $table->dropIndex('idx_order_items_product');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropIndex('idx_cart_items_cart');
            $table->dropIndex('idx_cart_items_product');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_parent');
            $table->dropIndex('idx_categories_slug');
            $table->dropIndex('idx_categories_active');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndex('idx_reviews_product');
            $table->dropIndex('idx_reviews_user');
            $table->dropIndex('idx_reviews_status');
            $table->dropIndex('idx_reviews_product_status');
        });

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropIndex('idx_product_images_product');
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropIndex('idx_user_addresses_user');
            $table->dropIndex('idx_user_addresses_user_default');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('idx_carts_user');
            $table->dropIndex('idx_carts_status');
            $table->dropIndex('idx_carts_user_status');
        });

        Schema::table('spec_definitions', function (Blueprint $table) {
            $table->dropIndex('idx_spec_definitions_component_type');
            $table->dropIndex('idx_spec_definitions_filterable');
            $table->dropIndex('idx_spec_definitions_code');
        });
    }
};
