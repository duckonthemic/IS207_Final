<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Call seeders
        $this->call([
            AdminUserSeeder::class,
            BranchSeeder::class,
            ManufacturerSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PromotionSeeder::class,
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
