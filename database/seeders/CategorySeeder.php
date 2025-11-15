<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating categories with subcategories...');

        // Main categories với subcategories
        $categoriesStructure = [
            [
                'name' => 'CPU - Bộ vi xử lý',
                'slug' => 'cpu',
                'description' => 'Bộ xử lý trung tâm',
                'children' => [
                    ['name' => 'CPU Intel', 'slug' => 'cpu-intel'],
                    ['name' => 'CPU AMD', 'slug' => 'cpu-amd'],
                ]
            ],
            [
                'name' => 'Mainboard - Bo mạch chủ',
                'slug' => 'mainboard',
                'description' => 'Bo mạch chủ máy tính',
                'children' => [
                    ['name' => 'Mainboard ASUS', 'slug' => 'mainboard-asus'],
                    ['name' => 'Mainboard MSI', 'slug' => 'mainboard-msi'],
                    ['name' => 'Mainboard GIGABYTE', 'slug' => 'mainboard-gigabyte'],
                    ['name' => 'Mainboard ASROCK', 'slug' => 'mainboard-asrock'],
                    ['name' => 'Mainboard Biostar', 'slug' => 'mainboard-biostar'],
                    ['name' => 'Mainboard NZXT', 'slug' => 'mainboard-nzxt'],
                ]
            ],
            [
                'name' => 'RAM - Bộ nhớ trong',
                'slug' => 'ram',
                'description' => 'Bộ nhớ RAM',
                'children' => [
                    ['name' => 'RAM Corsair', 'slug' => 'ram-corsair'],
                    ['name' => 'RAM GIGABYTE', 'slug' => 'ram-gigabyte'],
                    ['name' => 'RAM Kingston', 'slug' => 'ram-kingston'],
                    ['name' => 'RAM ADATA', 'slug' => 'ram-adata'],
                    ['name' => 'RAM G.SKILL', 'slug' => 'ram-gskill'],
                    ['name' => 'RAM TeamGroup', 'slug' => 'ram-teamgroup'],
                    ['name' => 'RAM Apacer', 'slug' => 'ram-apacer'],
                    ['name' => 'RAM Silicon Power', 'slug' => 'ram-silicon-power'],
                ]
            ],
            [
                'name' => 'VGA - Card màn hình',
                'slug' => 'vga',
                'description' => 'Card đồ họa rời',
                'children' => [
                    ['name' => 'VGA ASUS', 'slug' => 'vga-asus'],
                    ['name' => 'VGA MSI', 'slug' => 'vga-msi'],
                    ['name' => 'VGA GIGABYTE', 'slug' => 'vga-gigabyte'],
                    ['name' => 'VGA ASROCK', 'slug' => 'vga-asrock'],
                ]
            ],
            [
                'name' => 'SSD - Ổ cứng SSD',
                'slug' => 'ssd',
                'description' => 'Ổ cứng thể rắn',
                'children' => [
                    ['name' => 'SSD Samsung', 'slug' => 'ssd-samsung'],
                    ['name' => 'SSD Kingston', 'slug' => 'ssd-kingston'],
                    ['name' => 'SSD WD', 'slug' => 'ssd-wd'],
                    ['name' => 'SSD Crucial', 'slug' => 'ssd-crucial'],
                    ['name' => 'SSD ADATA', 'slug' => 'ssd-adata'],
                ]
            ],
            [
                'name' => 'HDD - Ổ cứng HDD',
                'slug' => 'hdd',
                'description' => 'Ổ cứng cơ',
                'children' => [
                    ['name' => 'HDD Seagate', 'slug' => 'hdd-seagate'],
                    ['name' => 'HDD WD', 'slug' => 'hdd-wd'],
                    ['name' => 'HDD Toshiba', 'slug' => 'hdd-toshiba'],
                ]
            ],
            [
                'name' => 'PSU - Nguồn máy tính',
                'slug' => 'psu',
                'description' => 'Nguồn máy tính',
                'children' => [
                    ['name' => 'Nguồn ASUS', 'slug' => 'psu-asus'],
                    ['name' => 'Nguồn Cooler Master', 'slug' => 'psu-cooler-master'],
                    ['name' => 'Nguồn Corsair', 'slug' => 'psu-corsair'],
                    ['name' => 'Nguồn MSI', 'slug' => 'psu-msi'],
                    ['name' => 'Nguồn GIGABYTE', 'slug' => 'psu-gigabyte'],
                    ['name' => 'Nguồn DeepCool', 'slug' => 'psu-deepcool'],
                    ['name' => 'Nguồn NZXT', 'slug' => 'psu-nzxt'],
                    ['name' => 'Nguồn Lian Li', 'slug' => 'psu-lian-li'],
                    ['name' => 'Nguồn Antec', 'slug' => 'psu-antec'],
                ]
            ],
            [
                'name' => 'Case - Vỏ máy tính',
                'slug' => 'case',
                'description' => 'Vỏ case máy tính',
                'children' => [
                    ['name' => 'Case NZXT', 'slug' => 'case-nzxt'],
                    ['name' => 'Case Corsair', 'slug' => 'case-corsair'],
                    ['name' => 'Case Cooler Master', 'slug' => 'case-cooler-master'],
                    ['name' => 'Case Lian Li', 'slug' => 'case-lian-li'],
                    ['name' => 'Case Fractal Design', 'slug' => 'case-fractal-design'],
                ]
            ],
            [
                'name' => 'Monitor - Màn hình',
                'slug' => 'monitor',
                'description' => 'Màn hình máy tính',
                'children' => [
                    ['name' => 'Monitor ASUS', 'slug' => 'monitor-asus'],
                    ['name' => 'Monitor LG', 'slug' => 'monitor-lg'],
                    ['name' => 'Monitor Samsung', 'slug' => 'monitor-samsung'],
                    ['name' => 'Monitor Dell', 'slug' => 'monitor-dell'],
                    ['name' => 'Monitor MSI', 'slug' => 'monitor-msi'],
                ]
            ],
        ];

        foreach ($categoriesStructure as $mainCat) {
            $children = $mainCat['children'] ?? [];
            unset($mainCat['children']);

            // Create parent category
            $parent = Category::updateOrCreate(
                ['slug' => $mainCat['slug']],
                array_merge($mainCat, ['parent_id' => null, 'depth' => 0, 'status' => true])
            );

            $this->command->info("✅ Created parent: {$parent->name}");

            // Create child categories
            foreach ($children as $childData) {
                $child = Category::updateOrCreate(
                    ['slug' => $childData['slug']],
                    array_merge($childData, [
                        'parent_id' => $parent->id,
                        'depth' => 1,
                        'description' => $childData['name'],
                        'status' => true
                    ])
                );
                $this->command->info("  └─ {$child->name}");
            }
        }

        $this->command->info('✅ Categories created successfully!');
    }
}
