<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // Mã giảm giá: VD: SALE2024
            $table->string('name'); // Tên: VD: "Giảm 10% cuối năm"
            $table->text('description')->nullable();

            // Loại giảm giá
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            // percentage: giảm theo %, fixed: giảm số tiền cố định

            $table->decimal('value', 12, 2); // Giá trị giảm (10 = 10% hoặc 10,000đ)
            $table->decimal('min_order_value', 12, 2)->nullable(); // Đơn tối thiểu
            $table->decimal('max_discount', 12, 2)->nullable(); // Giảm tối đa (cho %)

            // Giới hạn sử dụng
            $table->integer('usage_limit')->nullable(); // Tổng lượt dùng tối đa
            $table->integer('usage_per_user')->default(1); // Mỗi user dùng bao nhiêu lần
            $table->integer('usage_count')->default(0); // Đã dùng bao nhiêu lần

            // Thời gian hiệu lực
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['code', 'is_active']);
            $table->index(['starts_at', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
