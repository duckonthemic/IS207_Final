<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotions = [
            // Active percentage discounts
            [
                'code' => 'WELCOME10',
                'name' => 'Chào mừng khách hàng mới',
                'description' => 'Giảm 10% cho đơn hàng đầu tiên',
                'type' => 'percentage',
                'value' => 10,
                'min_order_value' => 500000,
                'max_discount' => 200000,
                'usage_limit' => 1000,
                'usage_per_user' => 1,
                'usage_count' => 0,
                'starts_at' => Carbon::now()->subMonth(),
                'expires_at' => Carbon::now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'SALE15',
                'name' => 'Giảm giá mùa hè',
                'description' => 'Giảm 15% tối đa 500K',
                'type' => 'percentage',
                'value' => 15,
                'min_order_value' => 1000000,
                'max_discount' => 500000,
                'usage_limit' => 500,
                'usage_per_user' => 2,
                'usage_count' => 45,
                'starts_at' => Carbon::now()->subWeeks(2),
                'expires_at' => Carbon::now()->addMonth(),
                'is_active' => true,
            ],
            [
                'code' => 'VIP20',
                'name' => 'Ưu đãi VIP',
                'description' => 'Giảm 20% cho khách VIP',
                'type' => 'percentage',
                'value' => 20,
                'min_order_value' => 2000000,
                'max_discount' => 1000000,
                'usage_limit' => 100,
                'usage_per_user' => 5,
                'usage_count' => 12,
                'starts_at' => Carbon::now()->subMonth(),
                'expires_at' => Carbon::now()->addMonths(3),
                'is_active' => true,
            ],

            // Fixed amount discounts
            [
                'code' => 'GIAM100K',
                'name' => 'Giảm 100K',
                'description' => 'Giảm 100.000đ cho đơn từ 1 triệu',
                'type' => 'fixed',
                'value' => 100000,
                'min_order_value' => 1000000,
                'max_discount' => null,
                'usage_limit' => 200,
                'usage_per_user' => 1,
                'usage_count' => 78,
                'starts_at' => Carbon::now()->subWeek(),
                'expires_at' => Carbon::now()->addWeeks(2),
                'is_active' => true,
            ],
            [
                'code' => 'GIAM500K',
                'name' => 'Giảm 500K cho đơn lớn',
                'description' => 'Giảm 500.000đ cho đơn từ 5 triệu',
                'type' => 'fixed',
                'value' => 500000,
                'min_order_value' => 5000000,
                'max_discount' => null,
                'usage_limit' => 50,
                'usage_per_user' => 2,
                'usage_count' => 8,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addMonth(),
                'is_active' => true,
            ],

            // Freeship simulation
            [
                'code' => 'FREESHIP',
                'name' => 'Miễn phí vận chuyển',
                'description' => 'Giảm 50K phí ship',
                'type' => 'fixed',
                'value' => 50000,
                'min_order_value' => 300000,
                'max_discount' => null,
                'usage_limit' => null,
                'usage_per_user' => 10,
                'usage_count' => 156,
                'starts_at' => Carbon::now()->subMonths(2),
                'expires_at' => Carbon::now()->addMonths(12),
                'is_active' => true,
            ],

            // Expired promotion
            [
                'code' => 'SALE2023',
                'name' => 'Black Friday 2023',
                'description' => 'Đã hết hạn',
                'type' => 'percentage',
                'value' => 25,
                'min_order_value' => 500000,
                'max_discount' => 1000000,
                'usage_limit' => 1000,
                'usage_per_user' => 1,
                'usage_count' => 432,
                'starts_at' => Carbon::create(2023, 11, 20),
                'expires_at' => Carbon::create(2023, 11, 30),
                'is_active' => false,
            ],

            // Inactive promotion
            [
                'code' => 'TESTCODE',
                'name' => 'Mã test (chưa kích hoạt)',
                'description' => 'Mã dùng để test',
                'type' => 'percentage',
                'value' => 50,
                'min_order_value' => 0,
                'max_discount' => 100000,
                'usage_limit' => 10,
                'usage_per_user' => 1,
                'usage_count' => 0,
                'starts_at' => null,
                'expires_at' => null,
                'is_active' => false,
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::updateOrCreate(
                ['code' => $promo['code']],
                $promo
            );
        }
    }
}
