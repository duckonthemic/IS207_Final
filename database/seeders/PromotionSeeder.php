<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotions = [
            [
                'code' => 'SUMMER2025',
                'type' => 'percent',
                'value' => 15,
                'min_order' => 500000,
                'start_at' => now(),
                'end_at' => now()->addMonths(3),
                'max_usage' => null,
                'description' => 'Khuyến mãi mùa hè - 15% toàn bộ sản phẩm',
            ],
            [
                'code' => 'NEWYEAR2025',
                'type' => 'fixed',
                'value' => 100000,
                'min_order' => 1000000,
                'start_at' => now(),
                'end_at' => now()->addMonths(1),
                'max_usage' => 100,
                'description' => 'Giảm cố định 100K cho đơn từ 1 triệu',
            ],
            [
                'code' => 'BLACKFRIDAY',
                'type' => 'percent',
                'value' => 30,
                'min_order' => 2000000,
                'start_at' => now(),
                'end_at' => now()->addMonths(6),
                'max_usage' => 50,
                'description' => 'Black Friday - Giảm 30% đơn hàng từ 2 triệu',
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::firstOrCreate(['code' => $promo['code']], $promo);
        }
    }
}
