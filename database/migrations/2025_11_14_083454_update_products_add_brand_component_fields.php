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
            $table->foreignId('brand_id')
                ->nullable()
                ->after('category_id')
                ->constrained('brands')
                ->nullOnDelete();
            $table->foreignId('component_type_id')
                ->nullable()
                ->after('brand_id')
                ->constrained('component_types')
                ->nullOnDelete();
            $table->integer('warranty_months')->nullable()->after('description');
            $table->boolean('is_featured')->default(false)->after('warranty_months');
            $table->boolean('is_active')->default(true)->after('is_featured');

            $table->index('brand_id');
            $table->index('component_type_id');
            $table->index('is_featured');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['component_type_id']);
            $table->dropColumn(['brand_id', 'component_type_id', 'warranty_months', 'is_featured', 'is_active']);
        });
    }
};
