<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rma_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')
                ->constrained('order_items')
                ->cascadeOnDelete();
            $table->enum('status', ['requested', 'approved', 'repairing', 'done', 'rejected'])->default('requested');
            $table->text('note')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();

            $table->index(['order_item_id', 'status']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rma_tickets');
    }
};
