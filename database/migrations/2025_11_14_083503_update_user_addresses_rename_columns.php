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
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->renameColumn('fullname', 'recipient_name');
            $table->renameColumn('address', 'address_line');
            $table->string('label', 100)->default('Home')->after('user_id');
            $table->dropColumn(['city', 'district', 'ward', 'postal_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->renameColumn('recipient_name', 'fullname');
            $table->renameColumn('address_line', 'address');
            $table->dropColumn('label');
            $table->string('city', 100)->after('address');
            $table->string('district', 100)->nullable()->after('city');
            $table->string('ward', 100)->nullable()->after('district');
            $table->string('postal_code', 20)->nullable()->after('ward');
        });
    }
};
