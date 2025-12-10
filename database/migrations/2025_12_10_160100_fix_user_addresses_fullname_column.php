<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Fix: Remove duplicate fullname column since recipient_name is used
     */
    public function up(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            // Drop the fullname column if it exists (it's a duplicate)
            if (Schema::hasColumn('user_addresses', 'fullname')) {
                $table->dropColumn('fullname');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('user_addresses', 'fullname')) {
                $table->string('fullname')->nullable()->after('user_id');
            }
        });
    }
};
