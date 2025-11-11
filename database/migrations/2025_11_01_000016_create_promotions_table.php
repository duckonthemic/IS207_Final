<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percent', 'fixed']);
            $table->decimal('value', 10, 2);
            $table->decimal('min_order', 12, 2)->default(0);
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->unsignedInteger('max_usage')->nullable();
            $table->unsignedInteger('usage_count')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['code']);
            $table->index(['start_at', 'end_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
