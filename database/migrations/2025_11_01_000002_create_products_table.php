<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->foreignId('manufacturer_id')
                ->nullable()
                ->constrained('manufacturers')
                ->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->string('sku')->unique();
            $table->text('specs_json')->nullable();
            $table->unsignedSmallInteger('status')->default(1); // 1=active, 0=inactive
            $table->softDeletes();
            $table->timestamps();

            $table->fullText(['name', 'description']);
            $table->index(['category_id']);
            $table->index(['manufacturer_id']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
