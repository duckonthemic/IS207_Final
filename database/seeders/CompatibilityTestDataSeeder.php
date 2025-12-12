<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Models\SpecDefinition;
use App\Models\ComponentType;
use App\Models\Category;

/**
 * Seeder để tạo data test đầy đủ cho PC Compatibility System
 * Bao gồm tất cả các scenarios: socket, RAM type, TDP, GPU length, cooler, PSU
 */
class CompatibilityTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating test products for Compatibility System...');

        // Get component types
        $cpuType = ComponentType::where('code', 'cpu')->first();
        $mainboardType = ComponentType::where('code', 'mainboard')->first();
        $gpuType = ComponentType::where('code', 'vga')->first();
        $ramType = ComponentType::where('code', 'ram')->first();
        $psuType = ComponentType::where('code', 'psu')->first();
        $caseType = ComponentType::where('code', 'case')->first();
        $coolerType = ComponentType::where('code', 'cooler')->first();

        // Get categories
        $cpuCategory = Category::where('slug', 'cpu')->first();
        $mainboardCategory = Category::where('slug', 'mainboard')->first();
        $gpuCategory = Category::where('slug', 'vga')->first();
        $ramCategory = Category::where('slug', 'ram')->first();
        $psuCategory = Category::where('slug', 'psu')->first();
        $caseCategory = Category::where('slug', 'case')->first();
        $coolerCategory = Category::where('slug', 'cooler')->first();

        if (!$cpuType || !$mainboardType) {
            $this->command->error('Component types not found. Please run SmartProductSeeder first.');
            return;
        }

        // ==========================================
        // CPUs - Different sockets and tiers
        // ==========================================
        $cpus = [
            [
                'name' => 'Intel Core i9-14900K',
                'price' => 15990000,
                'tier' => 4,
                'specs' => ['cpu_socket' => 'LGA1700', 'cpu_tdp' => '253']
            ],
            [
                'name' => 'Intel Core i3-12100F',
                'price' => 2490000,
                'tier' => 1,
                'specs' => ['cpu_socket' => 'LGA1700', 'cpu_tdp' => '58']
            ],
            [
                'name' => 'AMD Ryzen 9 7950X',
                'price' => 14990000,
                'tier' => 4,
                'specs' => ['cpu_socket' => 'AM5', 'cpu_tdp' => '170']
            ],
            [
                'name' => 'AMD Ryzen 3 4100',
                'price' => 1990000,
                'tier' => 1,
                'specs' => ['cpu_socket' => 'AM4', 'cpu_tdp' => '65']
            ],
        ];

        foreach ($cpus as $data) {
            $this->createProduct($data, $cpuType, $cpuCategory);
        }
        $this->command->info('  Created ' . count($cpus) . ' test CPUs');

        // ==========================================
        // Mainboards - Different sockets, tiers, DDR types
        // ==========================================
        $mainboards = [
            [
                'name' => 'Gigabyte H610M-S2H DDR4',
                'price' => 1890000,
                'tier' => 1,
                'specs' => [
                    'mb_socket' => 'LGA1700',
                    'mb_chipset' => 'H610',
                    'mb_memory_type' => 'DDR4',
                    'mb_form_factor' => 'mATX'
                ]
            ],
            [
                'name' => 'ASUS ROG Maximus Z790 Hero',
                'price' => 18990000,
                'tier' => 4,
                'specs' => [
                    'mb_socket' => 'LGA1700',
                    'mb_chipset' => 'Z790',
                    'mb_memory_type' => 'DDR5',
                    'mb_form_factor' => 'ATX'
                ]
            ],
            [
                'name' => 'MSI B550M PRO-VDH WiFi',
                'price' => 2590000,
                'tier' => 2,
                'specs' => [
                    'mb_socket' => 'AM4',
                    'mb_chipset' => 'B550',
                    'mb_memory_type' => 'DDR4',
                    'mb_form_factor' => 'mATX'
                ]
            ],
            [
                'name' => 'ASUS ROG Crosshair X670E Hero',
                'price' => 19990000,
                'tier' => 4,
                'specs' => [
                    'mb_socket' => 'AM5',
                    'mb_chipset' => 'X670E',
                    'mb_memory_type' => 'DDR5',
                    'mb_form_factor' => 'ATX'
                ]
            ],
        ];

        foreach ($mainboards as $data) {
            $this->createProduct($data, $mainboardType, $mainboardCategory);
        }
        $this->command->info('  Created ' . count($mainboards) . ' test Mainboards');

        // ==========================================
        // GPUs - Different TDP, lengths
        // ==========================================
        $gpus = [
            [
                'name' => 'NVIDIA GeForce RTX 4090 24GB',
                'price' => 49990000,
                'tier' => 4,
                'specs' => [
                    'gpu_tdp' => '450',
                    'gpu_length_mm' => '336',
                    'gpu_recommended_psu' => '850',
                    'gpu_power_connectors' => '1x 16-pin 12VHPWR'
                ]
            ],
            [
                'name' => 'NVIDIA GeForce RTX 4060 8GB',
                'price' => 8490000,
                'tier' => 2,
                'specs' => [
                    'gpu_tdp' => '115',
                    'gpu_length_mm' => '240',
                    'gpu_recommended_psu' => '550',
                    'gpu_power_connectors' => '1x 8-pin PCIe'
                ]
            ],
            [
                'name' => 'AMD Radeon RX 7900 XTX 24GB',
                'price' => 29990000,
                'tier' => 4,
                'specs' => [
                    'gpu_tdp' => '355',
                    'gpu_length_mm' => '287',
                    'gpu_recommended_psu' => '800',
                    'gpu_power_connectors' => '2x 8-pin PCIe'
                ]
            ],
            [
                'name' => 'NVIDIA GeForce GTX 1650 4GB',
                'price' => 3990000,
                'tier' => 1,
                'specs' => [
                    'gpu_tdp' => '75',
                    'gpu_length_mm' => '200',
                    'gpu_recommended_psu' => '350',
                    'gpu_power_connectors' => 'None'
                ]
            ],
        ];

        foreach ($gpus as $data) {
            $this->createProduct($data, $gpuType, $gpuCategory);
        }
        $this->command->info('  Created ' . count($gpus) . ' test GPUs');

        // ==========================================
        // RAM - DDR4 và DDR5
        // ==========================================
        $rams = [
            [
                'name' => 'Kingston Fury Beast DDR4 16GB 3200MHz',
                'price' => 1290000,
                'tier' => 2,
                'specs' => ['ram_type' => 'DDR4']
            ],
            [
                'name' => 'Corsair Vengeance DDR5 32GB 5600MHz',
                'price' => 3490000,
                'tier' => 3,
                'specs' => ['ram_type' => 'DDR5']
            ],
            [
                'name' => 'G.Skill Trident Z5 DDR5 64GB 6000MHz',
                'price' => 7990000,
                'tier' => 4,
                'specs' => ['ram_type' => 'DDR5']
            ],
        ];

        foreach ($rams as $data) {
            $this->createProduct($data, $ramType, $ramCategory);
        }
        $this->command->info('  Created ' . count($rams) . ' test RAMs');

        // ==========================================
        // PSUs - Different wattages and connectors
        // ==========================================
        $psus = [
            [
                'name' => 'Corsair CV450 450W 80+ Bronze',
                'price' => 990000,
                'tier' => 1,
                'specs' => [
                    'psu_wattage' => '450',
                    'psu_pcie_8pin' => '1',
                    'psu_12vhpwr' => '0'
                ]
            ],
            [
                'name' => 'Corsair RM750x 750W 80+ Gold',
                'price' => 2990000,
                'tier' => 3,
                'specs' => [
                    'psu_wattage' => '750',
                    'psu_pcie_8pin' => '4',
                    'psu_12vhpwr' => '0'
                ]
            ],
            [
                'name' => 'Corsair RM1000x 1000W 80+ Gold',
                'price' => 4990000,
                'tier' => 4,
                'specs' => [
                    'psu_wattage' => '1000',
                    'psu_pcie_8pin' => '6',
                    'psu_12vhpwr' => '1'
                ]
            ],
        ];

        foreach ($psus as $data) {
            $this->createProduct($data, $psuType, $psuCategory);
        }
        $this->command->info('  Created ' . count($psus) . ' test PSUs');

        // ==========================================
        // Cases - Different sizes and clearances
        // ==========================================
        $cases = [
            [
                'name' => 'NZXT H1 V2 Mini-ITX',
                'price' => 4990000,
                'tier' => 2,
                'specs' => [
                    'case_type' => 'SFF',
                    'case_motherboard_support' => 'Mini-ITX',
                    'case_gpu_length' => '305',
                    'case_cooler_height' => '72',
                    'case_radiator_support' => 'Rear 140mm',
                    'case_max_fans' => '2',
                    'case_fan_sizes' => '140mm'
                ]
            ],
            [
                'name' => 'Lian Li Lancool 216 Mid Tower',
                'price' => 2490000,
                'tier' => 3,
                'specs' => [
                    'case_type' => 'Mid Tower',
                    'case_motherboard_support' => 'ATX,mATX,Mini-ITX',
                    'case_gpu_length' => '392',
                    'case_cooler_height' => '180',
                    'case_radiator_support' => 'Front 360mm, Top 280mm',
                    'case_max_fans' => '10',
                    'case_fan_sizes' => '120mm,140mm'
                ]
            ],
            [
                'name' => 'Corsair 7000D Full Tower',
                'price' => 5990000,
                'tier' => 4,
                'specs' => [
                    'case_type' => 'Full Tower',
                    'case_motherboard_support' => 'E-ATX,ATX,mATX,Mini-ITX',
                    'case_gpu_length' => '450',
                    'case_cooler_height' => '190',
                    'case_radiator_support' => 'Front 420mm, Top 420mm, Side 360mm',
                    'case_max_fans' => '12',
                    'case_fan_sizes' => '120mm,140mm'
                ]
            ],
        ];

        foreach ($cases as $data) {
            $this->createProduct($data, $caseType, $caseCategory);
        }
        $this->command->info('  Created ' . count($cases) . ' test Cases');

        // ==========================================
        // Coolers - Air and Liquid
        // ==========================================
        $coolers = [
            [
                'name' => 'Noctua NH-D15 Air Cooler',
                'price' => 2490000,
                'tier' => 3,
                'specs' => [
                    'cooler_type' => 'Air',
                    'cooler_height' => '165',
                    'cooler_tdp' => '250',
                    'cooler_socket_support' => 'LGA1700,AM5,AM4'
                ]
            ],
            [
                'name' => 'Stock Intel Cooler',
                'price' => 0,
                'tier' => 1,
                'specs' => [
                    'cooler_type' => 'Air',
                    'cooler_height' => '60',
                    'cooler_tdp' => '65',
                    'cooler_socket_support' => 'LGA1700'
                ]
            ],
            [
                'name' => 'NZXT Kraken X63 AIO 280mm',
                'price' => 3990000,
                'tier' => 3,
                'specs' => [
                    'cooler_type' => 'Liquid',
                    'cooler_radiator' => '280',
                    'cooler_tdp' => '300',
                    'cooler_socket_support' => 'LGA1700,AM5,AM4'
                ]
            ],
            [
                'name' => 'Corsair iCUE H150i Elite AIO 360mm',
                'price' => 4990000,
                'tier' => 4,
                'specs' => [
                    'cooler_type' => 'Liquid',
                    'cooler_radiator' => '360',
                    'cooler_tdp' => '350',
                    'cooler_socket_support' => 'LGA1700,AM5,AM4'
                ]
            ],
        ];

        foreach ($coolers as $data) {
            $this->createProduct($data, $coolerType, $coolerCategory);
        }
        $this->command->info('  Created ' . count($coolers) . ' test Coolers');

        // ==========================================
        // Fan Case - Different sizes and quantities
        // ==========================================
        $fancaseType = ComponentType::where('code', 'fan-case')->first();
        $fancaseCategory = Category::where('slug', 'fan-case')->first();

        // Create fan-case component type if not exists
        if (!$fancaseType) {
            $fancaseType = ComponentType::create([
                'name' => 'Fan Case',
                'code' => 'fan-case',
                'is_required' => false,
                'sort_order' => 9
            ]);
        }

        // Create fan-case category if not exists
        if (!$fancaseCategory) {
            $fancaseCategory = Category::create([
                'name' => 'Fan Case',
                'slug' => 'fan-case',
                'is_active' => true
            ]);
        }

        // Create spec definitions for fan-case
        $fanSpecDefs = [
            ['code' => 'fan_size', 'name' => 'Kích thước', 'unit' => 'mm'],
            ['code' => 'fan_quantity', 'name' => 'Số lượng', 'unit' => ''],
            ['code' => 'fan_rpm', 'name' => 'Tốc độ', 'unit' => 'RPM'],
            ['code' => 'fan_airflow', 'name' => 'Luồng gió', 'unit' => 'CFM'],
        ];

        foreach ($fanSpecDefs as $def) {
            SpecDefinition::firstOrCreate(
                ['code' => $def['code'], 'component_type_id' => $fancaseType->id],
                [
                    'name' => $def['name'],
                    'unit' => $def['unit'],
                    'input_type' => 'text',
                    'is_required' => false,
                    'is_filterable' => true,
                    'sort_order' => 1
                ]
            );
        }

        // Create case spec definitions for max_fans and fan_sizes
        $caseSpecDefs = [
            ['code' => 'case_max_fans', 'name' => 'Số fan tối đa', 'unit' => ''],
            ['code' => 'case_fan_sizes', 'name' => 'Kích thước fan hỗ trợ', 'unit' => ''],
        ];

        foreach ($caseSpecDefs as $def) {
            SpecDefinition::firstOrCreate(
                ['code' => $def['code'], 'component_type_id' => $caseType->id],
                [
                    'name' => $def['name'],
                    'unit' => $def['unit'],
                    'input_type' => 'text',
                    'is_required' => false,
                    'is_filterable' => true,
                    'sort_order' => 10
                ]
            );
        }

        $fancases = [
            [
                'name' => 'Corsair LL120 RGB 3-Pack',
                'price' => 2990000,
                'tier' => 3,
                'specs' => [
                    'fan_size' => '120',
                    'fan_quantity' => '3',
                    'fan_rpm' => '1500',
                    'fan_airflow' => '43'
                ]
            ],
            [
                'name' => 'Noctua NF-A12x25 PWM',
                'price' => 890000,
                'tier' => 3,
                'specs' => [
                    'fan_size' => '120',
                    'fan_quantity' => '1',
                    'fan_rpm' => '2000',
                    'fan_airflow' => '60'
                ]
            ],
            [
                'name' => 'Lian Li UNI FAN SL120 5-Pack',
                'price' => 4990000,
                'tier' => 4,
                'specs' => [
                    'fan_size' => '120',
                    'fan_quantity' => '5',
                    'fan_rpm' => '1900',
                    'fan_airflow' => '58'
                ]
            ],
            [
                'name' => 'be quiet! Silent Wings 4 140mm',
                'price' => 790000,
                'tier' => 3,
                'specs' => [
                    'fan_size' => '140',
                    'fan_quantity' => '1',
                    'fan_rpm' => '1100',
                    'fan_airflow' => '78'
                ]
            ],
            [
                'name' => 'Arctic P12 PWM 5-Pack Value',
                'price' => 590000,
                'tier' => 1,
                'specs' => [
                    'fan_size' => '120',
                    'fan_quantity' => '5',
                    'fan_rpm' => '1800',
                    'fan_airflow' => '56'
                ]
            ],
        ];

        foreach ($fancases as $data) {
            $this->createProduct($data, $fancaseType, $fancaseCategory);
        }
        $this->command->info('  Created ' . count($fancases) . ' test Fan Cases');

        // Run tier seeder to update existing products
        $this->call(ProductTierSeeder::class);

        $this->command->info('✅ All test products created successfully!');
        $this->command->info('');
        $this->command->info('Test scenarios available:');
        $this->command->info('  🔴 Socket Mismatch: i9-14900K (LGA1700) + X670E (AM5)');
        $this->command->info('  🔴 RAM Type: DDR4 RAM + DDR5 Mainboard');
        $this->command->info('  🔴 PSU Weak: RTX 4090 + 450W PSU');
        $this->command->info('  🔴 GPU Too Long: RTX 4090 (336mm) + H1 V2 Case (305mm)');
        $this->command->info('  🔴 Cooler Too Tall: NH-D15 (165mm) + H1 V2 Case (72mm)');
        $this->command->info('  🔴 Too Many Fans: 5-Pack Fans + H1 V2 Case (max 2 fans)');
        $this->command->info('  🟡 Bottleneck: i9-14900K (Tier 4) + H610 Main (Tier 1)');
        $this->command->info('  🔵 Overkill: i3-12100F (Tier 1) + Z790 Hero (Tier 4)');
    }

    private function createProduct(array $data, $componentType, $category): void
    {
        if (!$componentType || !$category) {
            return;
        }

        // Check if product already exists
        $existingProduct = Product::where('name', $data['name'])->first();
        if ($existingProduct) {
            // Update tier if needed
            if (isset($data['tier']) && $existingProduct->tier !== $data['tier']) {
                $existingProduct->tier = $data['tier'];
                $existingProduct->save();
            }
            return;
        }

        $product = Product::create([
            'name' => $data['name'],
            'slug' => \Str::slug($data['name']),
            'sku' => 'TEST-' . strtoupper(\Str::random(8)),
            'price' => $data['price'],
            'tier' => $data['tier'] ?? null,
            'category_id' => $category->id,
            'component_type_id' => $componentType->id,
            'stock' => rand(10, 100),
            'is_active' => true,
            'description' => 'Product for testing compatibility system',
        ]);

        // Create specs
        foreach ($data['specs'] as $code => $value) {
            $specDef = SpecDefinition::where('code', $code)
                ->where('component_type_id', $componentType->id)
                ->first();

            if ($specDef) {
                ProductSpec::create([
                    'product_id' => $product->id,
                    'spec_definition_id' => $specDef->id,
                    'value' => $value,
                ]);
            }
        }
    }
}
