<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'code' => 'HN01',
                'name' => 'Hà Nội - Chi nhánh 1',
                'address' => '123 Nguyễn Hữu Cảnh, Quận Hoàn Kiếm, Hà Nội',
                'city' => 'Hà Nội',
                'phone' => '0243123456',
                'email' => 'hn01@techparts.vn',
                'is_active' => true,
            ],
            [
                'code' => 'HCM01',
                'name' => 'TP.HCM - Chi nhánh 1',
                'address' => '456 Nguyễn Hàm Nghi, Quận 1, TP.HCM',
                'city' => 'TP.HCM',
                'phone' => '0283123456',
                'email' => 'hcm01@techparts.vn',
                'is_active' => true,
            ],
            [
                'code' => 'DN01',
                'name' => 'Đà Nẵng - Chi nhánh 1',
                'address' => '789 Lê Lợi, Quận Hải Châu, Đà Nẵng',
                'city' => 'Đà Nẵng',
                'phone' => '0363123456',
                'email' => 'dn01@techparts.vn',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(['code' => $branch['code']], $branch);
        }
    }
}
