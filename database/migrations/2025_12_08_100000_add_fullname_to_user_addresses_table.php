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
        // Add fullname column if it doesn't exist
        if (!Schema::hasColumn('user_addresses', 'fullname')) {
            Schema::table('user_addresses', function (Blueprint $table) {
                $table->string('fullname')->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('fullname');
        });
    }
};
