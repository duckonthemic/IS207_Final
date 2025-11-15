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
        Schema::create('product_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('spec_definition_id')
                ->constrained('spec_definitions')
                ->onDelete('cascade');
            $table->text('value'); // Giá trị thông số (VD: "8", "16GB", "3.5")
            $table->timestamps();

            // Unique constraint: một product chỉ có 1 giá trị cho 1 spec_definition
            $table->unique(['product_id', 'spec_definition_id'], 'product_spec_unique');
            
            // Indexes
            $table->index('product_id');
            $table->index('spec_definition_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specs');
    }
};
