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
        Schema::create('spec_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_type_id')
                ->nullable()
                ->constrained('component_types')
                ->onDelete('cascade');
            $table->string('name'); // Tên thông số hiển thị (VD: "Số nhân", "Dung lượng RAM")
            $table->string('code')->unique(); // Mã nội bộ (VD: "core_count", "ram_capacity")
            $table->string('unit')->nullable(); // Đơn vị (VD: "core", "GB", "GHz")
            $table->enum('input_type', ['text', 'number', 'select', 'textarea'])->default('text'); // Kiểu nhập liệu
            $table->text('options')->nullable(); // JSON options cho select (nếu input_type = 'select')
            $table->integer('sort_order')->default(0); // Thứ tự hiển thị
            $table->boolean('is_required')->default(false); // Bắt buộc nhập hay không
            $table->boolean('is_filterable')->default(false); // Có thể dùng để lọc sản phẩm không
            $table->timestamps();

            // Indexes
            $table->index('component_type_id');
            $table->index('sort_order');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spec_definitions');
    }
};
