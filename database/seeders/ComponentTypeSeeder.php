<?php

namespace Database\Seeders;

use App\Models\ComponentType;
use Illuminate\Database\Seeder;

class ComponentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $componentTypes = [
            ['name' => 'CPU', 'code' => 'cpu', 'is_required' => true, 'sort_order' => 1],
            ['name' => 'GPU/VGA', 'code' => 'gpu', 'is_required' => true, 'sort_order' => 2],
            ['name' => 'RAM', 'code' => 'ram', 'is_required' => true, 'sort_order' => 3],
            ['name' => 'SSD', 'code' => 'ssd', 'is_required' => true, 'sort_order' => 4],
            ['name' => 'Mainboard', 'code' => 'mainboard', 'is_required' => true, 'sort_order' => 5],
            ['name' => 'PSU', 'code' => 'psu', 'is_required' => true, 'sort_order' => 6],
            ['name' => 'Case', 'code' => 'case', 'is_required' => false, 'sort_order' => 7],
            ['name' => 'Cooling', 'code' => 'cooling', 'is_required' => false, 'sort_order' => 8],
            ['name' => 'Monitor', 'code' => 'monitor', 'is_required' => false, 'sort_order' => 9],
        ];

        foreach ($componentTypes as $type) {
            ComponentType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }

        $this->command->info('✅ Created ' . count($componentTypes) . ' component types');
    }
}
