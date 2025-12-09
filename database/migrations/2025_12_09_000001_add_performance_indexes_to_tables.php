<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to products table for frequently queried columns
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id', 'idx_products_category_id');
            $table->index('component_type_id', 'idx_products_component_type_id');
            $table->index('brand_id', 'idx_products_brand_id');
            $table->index('is_active', 'idx_products_is_active');
            $table->index('is_featured', 'idx_products_is_featured');
            $table->index('stock', 'idx_products_stock');
            $table->index(['category_id', 'is_active'], 'idx_products_category_active');
            $table->index(['price', 'category_id'], 'idx_products_price_category');
        });

        // Add indexes to product_specs table for filtering
        Schema::table('product_specs', function (Blueprint $table) {
            $table->index('product_id', 'idx_product_specs_product_id');
            $table->index('spec_definition_id', 'idx_product_specs_spec_def_id');
            $table->index(['spec_definition_id', 'product_id'], 'idx_product_specs_spec_product');
            $table->index('value', 'idx_product_specs_value');
        });

        // Add indexes to orders table for status filtering and user lookups
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id', 'idx_orders_user_id');
            $table->index('status', 'idx_orders_status');
            $table->index('payment_status', 'idx_orders_payment_status');
            $table->index('placed_at', 'idx_orders_placed_at');
            $table->index(['user_id', 'status'], 'idx_orders_user_status');
            $table->index(['status', 'placed_at'], 'idx_orders_status_placed');
        });

        // Add indexes to order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id', 'idx_order_items_order_id');
            $table->index('product_id', 'idx_order_items_product_id');
        });

        // Add indexes to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('parent_id', 'idx_categories_parent_id');
            $table->index('slug', 'idx_categories_slug');
            $table->index('status', 'idx_categories_status');
        });

        // Add indexes to carts and cart_items tables
        Schema::table('carts', function (Blueprint $table) {
            $table->index('user_id', 'idx_carts_user_id');
            $table->index('status', 'idx_carts_status');
            $table->index(['user_id', 'status'], 'idx_carts_user_status');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->index('cart_id', 'idx_cart_items_cart_id');
            $table->index('product_id', 'idx_cart_items_product_id');
        });

        // Add indexes to product_reviews table
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->index('product_id', 'idx_product_reviews_product_id');
            $table->index('user_id', 'idx_product_reviews_user_id');
            $table->index('status', 'idx_product_reviews_status');
            $table->index(['product_id', 'status'], 'idx_product_reviews_product_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_category_id');
            $table->dropIndex('idx_products_component_type_id');
            $table->dropIndex('idx_products_brand_id');
            $table->dropIndex('idx_products_is_active');
            $table->dropIndex('idx_products_is_featured');
            $table->dropIndex('idx_products_stock');
            $table->dropIndex('idx_products_category_active');
            $table->dropIndex('idx_products_price_category');
        });

        Schema::table('product_specs', function (Blueprint $table) {
            $table->dropIndex('idx_product_specs_product_id');
            $table->dropIndex('idx_product_specs_spec_def_id');
            $table->dropIndex('idx_product_specs_spec_product');
            $table->dropIndex('idx_product_specs_value');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_user_id');
            $table->dropIndex('idx_orders_status');
            $table->dropIndex('idx_orders_payment_status');
            $table->dropIndex('idx_orders_placed_at');
            $table->dropIndex('idx_orders_user_status');
            $table->dropIndex('idx_orders_status_placed');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('idx_order_items_order_id');
            $table->dropIndex('idx_order_items_product_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_parent_id');
            $table->dropIndex('idx_categories_slug');
            $table->dropIndex('idx_categories_status');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('idx_carts_user_id');
            $table->dropIndex('idx_carts_status');
            $table->dropIndex('idx_carts_user_status');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropIndex('idx_cart_items_cart_id');
            $table->dropIndex('idx_cart_items_product_id');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropIndex('idx_product_reviews_product_id');
            $table->dropIndex('idx_product_reviews_user_id');
            $table->dropIndex('idx_product_reviews_status');
            $table->dropIndex('idx_product_reviews_product_status');
        });
    }
};
