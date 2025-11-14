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
        Schema::table('products', function (Blueprint $table) {
            // Kiểm tra xem column đã tồn tại chưa trước khi thêm
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable()->after('stock');
            }
            if (!Schema::hasColumn('products', 'specifications')) {
                $table->json('specifications')->nullable()->after('brand');
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('specifications');
            }
            
            // Xóa manufacturer_id nếu tồn tại
            if (Schema::hasColumn('products', 'manufacturer_id')) {
                $table->dropForeign(['manufacturer_id']);
                $table->dropColumn('manufacturer_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['stock', 'brand', 'specifications', 'image']);
        });
    }
};
