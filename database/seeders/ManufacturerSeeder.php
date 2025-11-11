<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    public function run(): void
    {
        $manufacturers = [
            ['name' => 'Intel', 'slug' => 'intel', 'description' => 'Bộ xử lý Intel®'],
            ['name' => 'AMD', 'slug' => 'amd', 'description' => 'Bộ xử lý AMD Ryzen™'],
            ['name' => 'NVIDIA', 'slug' => 'nvidia', 'description' => 'Card đồ họa NVIDIA GeForce'],
            ['name' => 'NVIDIA RTX', 'slug' => 'nvidia-rtx', 'description' => 'Card đồ họa NVIDIA RTX'],
            ['name' => 'AMD Radeon', 'slug' => 'amd-radeon', 'description' => 'Card đồ họa AMD Radeon'],
            ['name' => 'Corsair', 'slug' => 'corsair', 'description' => 'RAM và PSU Corsair'],
            ['name' => 'Kingston', 'slug' => 'kingston', 'description' => 'RAM Kingston HyperX'],
            ['name' => 'G.Skill', 'slug' => 'gskill', 'description' => 'RAM G.Skill Trident'],
            ['name' => 'ASUS', 'slug' => 'asus', 'description' => 'Mainboard ASUS'],
            ['name' => 'MSI', 'slug' => 'msi', 'description' => 'Mainboard MSI'],
            ['name' => 'Gigabyte', 'slug' => 'gigabyte', 'description' => 'Mainboard Gigabyte'],
            ['name' => 'Samsung', 'slug' => 'samsung', 'description' => 'SSD Samsung 970 EVO'],
            ['name' => 'WD', 'slug' => 'western-digital', 'description' => 'SSD Western Digital'],
            ['name' => 'SK Hynix', 'slug' => 'sk-hynix', 'description' => 'SSD SK Hynix'],
            ['name' => 'Seasonic', 'slug' => 'seasonic', 'description' => 'PSU Seasonic Focus'],
            ['name' => 'EVGA', 'slug' => 'evga', 'description' => 'PSU EVGA SuperNOVA'],
            ['name' => 'Be Quiet', 'slug' => 'be-quiet', 'description' => 'PSU Be Quiet'],
            ['name' => 'NZXT', 'slug' => 'nzxt', 'description' => 'Case NZXT H510'],
            ['name' => 'Fractal Design', 'slug' => 'fractal', 'description' => 'Case Fractal Design'],
            ['name' => 'Lian Li', 'slug' => 'lian-li', 'description' => 'Case Lian Li'],
        ];

        foreach ($manufacturers as $mfr) {
            Manufacturer::firstOrCreate(['slug' => $mfr['slug']], $mfr);
        }
    }
}
