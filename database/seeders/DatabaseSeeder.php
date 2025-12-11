<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call seeders
        $this->call([
            AdminUserSeeder::class,
            SmartProductSeeder::class,
            PrebuiltPcSeeder::class, // Temporarily disable or update if needed
            ProductLocalImageSeeder::class, // Map local images to products
        ]);
    }
}
