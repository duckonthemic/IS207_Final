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
        Schema::create('build_config_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('build_config_id')
                ->constrained('build_configs')
                ->cascadeOnDelete();
            $table->foreignId('component_type_id')
                ->constrained('component_types')
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2);
            $table->timestamps();

            $table->index(['build_config_id', 'component_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_config_items');
    }
};
