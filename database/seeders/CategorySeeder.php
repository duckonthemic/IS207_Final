<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'CPU', 'slug' => 'cpu', 'depth' => 0, 'description' => 'Bộ xử lý máy tính'],
            ['name' => 'GPU', 'slug' => 'gpu', 'depth' => 0, 'description' => 'Card đồ họa'],
            ['name' => 'Mainboard', 'slug' => 'mainboard', 'depth' => 0, 'description' => 'Bo mạch chủ'],
            ['name' => 'RAM', 'slug' => 'ram', 'depth' => 0, 'description' => 'Bộ nhớ RAM'],
            ['name' => 'SSD', 'slug' => 'ssd', 'depth' => 0, 'description' => 'Ổ cứng SSD'],
            ['name' => 'HDD', 'slug' => 'hdd', 'depth' => 0, 'description' => 'Ổ cứng HDD'],
            ['name' => 'PSU', 'slug' => 'psu', 'depth' => 0, 'description' => 'Nguồn máy tính'],
            ['name' => 'Case', 'slug' => 'case', 'depth' => 0, 'description' => 'Vỏ case máy tính'],
            ['name' => 'Cooling', 'slug' => 'cooling', 'depth' => 0, 'description' => 'Tản nhiệt'],
            ['name' => 'Monitor', 'slug' => 'monitor', 'depth' => 0, 'description' => 'Màn hình máy tính'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
