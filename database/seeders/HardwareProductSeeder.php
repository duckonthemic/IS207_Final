<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ComponentType;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Models\SpecDefinition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HardwareProductSeeder extends Seeder
{
    protected $keyMapping = [
        'CPU' => [
            'segment' => 'cpu_segment',
            'generation' => 'cpu_generation',
            'codename' => 'cpu_codename',
            'socket' => 'cpu_socket',
            'cores' => 'cpu_cores',
            'threads' => 'cpu_threads',
            'p_core_base_ghz' => 'cpu_p_core_base',
            'p_core_boost_ghz' => 'cpu_p_core_boost',
            'e_core_base_ghz' => 'cpu_e_core_base',
            'e_core_boost_ghz' => 'cpu_e_core_boost',
            'turbo_boost_max_ghz' => 'cpu_turbo_boost_max',
            'l2_cache_mb' => 'cpu_l2_cache',
            'l3_cache_mb' => 'cpu_l3_cache',
            'max_memory_gb' => 'cpu_max_memory',
            'memory_types' => 'cpu_memory_types',
            'memory_channels' => 'cpu_memory_channels',
            'integrated_graphics' => 'cpu_igpu',
            'igpu_base_clock_mhz' => 'cpu_igpu_base',
            'igpu_max_clock_mhz' => 'cpu_igpu_max',
            'pcie_lanes' => 'cpu_pcie_lanes',
            'base_power_w' => 'cpu_base_power',
            'max_turbo_power_w' => 'cpu_max_turbo_power',
        ],
        'GPU' => [
            'gpu_chip' => 'gpu_chip',
            'core_clock_mhz' => 'gpu_core_clock',
            'cuda_cores' => 'gpu_cuda_cores',
            'memory_size_gb' => 'gpu_memory_size',
            'memory_type' => 'gpu_memory_type',
            'memory_bus_bit' => 'gpu_memory_bus',
            'recommended_psu_w' => 'gpu_recommended_psu',
        ],
        'RAM' => [
            'ram_type' => 'ram_type',
            'model_name' => 'ram_model_name',
            'capacity_gb' => 'ram_capacity',
            'module_type' => 'ram_module_type',
            'speed_mhz' => 'ram_speed',
            'latency' => 'ram_latency',
            'voltage_v' => 'ram_voltage',
            'ecc' => 'ram_ecc',
            'color' => 'ram_color',
            'heatsink' => 'ram_heatsink',
            'rgb' => 'ram_rgb',
        ],
        'SSD' => [
            'series' => 'ssd_series',
            'capacity_gb' => 'ssd_capacity',
            'form_factor' => 'ssd_form_factor',
            'nand_type' => 'ssd_nand_type',
            'interface' => 'ssd_interface',
            'seq_read_mb_s' => 'ssd_seq_read',
            'seq_write_mb_s' => 'ssd_seq_write',
            'rand_read_iops' => 'ssd_rand_read_iops',
            'rand_write_iops' => 'ssd_rand_write_iops',
            'endurance_tbw' => 'ssd_endurance_tbw',
            'operating_temp_min_c' => 'ssd_temp_min',
            'operating_temp_max_c' => 'ssd_temp_max',
        ],
        'Mainboard' => [
            'form_factor' => 'mb_form_factor',
            'cpu_socket' => 'mb_cpu_socket',
            'chipset' => 'mb_chipset',
            'memory_type' => 'mb_memory_type',
            'memory_slots' => 'mb_memory_slots',
            'max_memory_gb' => 'mb_max_memory',
            'memory_speed_support' => 'mb_memory_speed',
            'sata_ports' => 'mb_sata_ports',
            'm2_slots' => 'mb_m2_slots',
            'raid_support' => 'mb_raid_support',
            'audio_codec' => 'mb_audio_codec',
            'lan_chipset' => 'mb_lan_chipset',
            'lan_speed_gbps' => 'mb_lan_speed',
            'rear_usb_ports' => 'mb_rear_usb_ports',
            'rear_display_ports' => 'mb_rear_display_ports',
            'rear_audio_jacks' => 'mb_rear_audio_jacks',
            'onboard_usb_headers' => 'mb_onboard_usb_headers',
            'rgb_headers' => 'mb_rgb_headers',
            'fan_headers' => 'mb_fan_headers',
            'board_length_cm' => 'mb_board_length',
            'board_width_cm' => 'mb_board_width',
            'power_connectors' => 'mb_power_connectors',
        ],
        'PSU' => [
            'wattage' => 'psu_wattage',
            'efficiency' => 'psu_efficiency',
            'modular' => 'psu_modular',
            'form_factor' => 'psu_form_factor',
            'fan_size_mm' => 'psu_fan_size',
            'pcie_connectors' => 'psu_pcie_connectors',
            'eps_connectors' => 'psu_eps_connectors',
            'sata_connectors' => 'psu_sata_connectors',
            'length_mm' => 'psu_length',
            'warranty_years' => 'psu_warranty',
        ],
        'Case' => [
            'brand' => 'case_brand',
            'type' => 'case_type',
            'form_factor' => 'case_form_factor',
            'color' => 'case_color',
            'side_panel' => 'case_side_panel',
            'material' => 'case_material',
            'psu_shroud' => 'case_psu_shroud',
            'max_gpu_length_mm' => 'case_max_gpu_length',
            'max_cpu_height_mm' => 'case_max_cpu_height',
            'dimensions_mm' => 'case_dimensions',
            'weight_kg' => 'case_weight',
        ],
        'Monitor' => [
            'screen_size_inch' => 'monitor_size',
            'resolution' => 'monitor_resolution',
            'refresh_rate_hz' => 'monitor_refresh_rate',
            'response_time_ms' => 'monitor_response_time',
            'panel_type' => 'monitor_panel_type',
            'curve' => 'monitor_curvature',
            'ports' => 'monitor_ports',
        ],
        'Cooling' => [
            'brand' => 'cooling_brand',
            'type' => 'cooling_type',
            'radiator_size_mm' => 'cooling_radiator_size',
            'fan_count' => 'cooling_fan_count',
            'fan_size_mm' => 'cooling_fan_size',
            'rgb' => 'cooling_rgb',
            'socket_support' => 'cooling_socket_support',
        ],
    ];

    protected $categoryMapping = [
        'GPU' => 'VGA',
        'Monitor' => 'Màn hình',
        'Cooling' => 'Tản nhiệt',
        'Case' => 'Vỏ máy tính',
        'PSU' => 'Nguồn máy tính',
        'RAM' => 'RAM',
        'SSD' => 'SSD',
        'CPU' => 'CPU',
        'Mainboard' => 'Mainboard',
        'HDD' => 'HDD',
    ];

    protected $slugMapping = [
        'GPU' => 'vga',
        'Monitor' => 'monitor',
        'Cooling' => 'tan-nhiet',
        'Case' => 'case',
        'PSU' => 'psu',
        'RAM' => 'ram',
        'SSD' => 'ssd',
        'CPU' => 'cpu',
        'Mainboard' => 'mainboard',
        'HDD' => 'hdd',
    ];

    public function run(): void
    {
        $jsonPath = base_path('hardware_products_detailed.json');
        if (!File::exists($jsonPath)) {
            $this->command->error("File not found: $jsonPath");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        foreach ($data as $originalCategoryName => $products) {
            $categoryName = $this->categoryMapping[$originalCategoryName] ?? $originalCategoryName;
            $slug = $this->slugMapping[$originalCategoryName] ?? Str::slug($categoryName);
            
            $this->command->info("Processing category: $categoryName (slug: $slug)");

            // 1. Create or Get Category
            $category = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $categoryName, 'description' => "All $categoryName products"]
            );

            // 2. Create or Get ComponentType
            // We keep the code based on the ORIGINAL category name from JSON to match SpecDefinitionSeeder codes (e.g. 'gpu', 'ram')
            // OR we need to update SpecDefinitionSeeder to match.
            // SpecDefinitionSeeder uses 'gpu', 'ram', 'ssd', 'monitor', 'mainboard', 'psu', 'case'.
            // So we should keep component type code as Str::slug($originalCategoryName).
            $componentType = ComponentType::firstOrCreate(
                ['code' => Str::slug($originalCategoryName)],
                ['name' => $originalCategoryName]
            );

            foreach ($products as $productData) {
                // 3. Create Product
                $productName = $productData['brand'] . ' ' . $productData['model'];
                $priceVnd = $productData['price_usd'] * 25000;

                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($productName)],
                    [
                        'name' => $productName,
                        'sku' => Str::slug($productName),
                        'category_id' => $category->id,
                        'description' => $productData['specs']['segment'] ?? '',
                        'price' => $priceVnd,
                        'sale_price' => null,
                        'stock' => 100,
                        'component_type_id' => $componentType->id,
                    ]
                );

                // 4. Process Specs
                if (isset($productData['specs'])) {
                    foreach ($productData['specs'] as $specKey => $specValue) {
                        $code = $this->getSpecCode($originalCategoryName, $specKey);

                        // Try to find existing definition first (from SpecDefinitionSeeder)
                        $specDef = SpecDefinition::where('component_type_id', $componentType->id)
                            ->where('code', $code)
                            ->first();

                        if (!$specDef) {
                            // Fallback: Create new definition
                            $specDef = SpecDefinition::firstOrCreate(
                                ['code' => $code],
                                [
                                    'name' => Str::title(str_replace('_', ' ', $specKey)),
                                    'component_type_id' => $componentType->id,
                                    'input_type' => 'text',
                                ]
                            );
                        }

                        // Create ProductSpec
                        $finalValue = is_array($specValue) ? json_encode($specValue) : (string) $specValue;

                        // Normalize specific values to avoid duplicates in filters
                        if ($code === 'cpu_generation') {
                            if (str_contains($finalValue, '12th')) {
                                $finalValue = '12th Gen';
                            } elseif (str_contains($finalValue, '13th')) {
                                $finalValue = '13th Gen';
                            } elseif (str_contains($finalValue, '14th')) {
                                $finalValue = '14th Gen';
                            } elseif (str_contains($finalValue, 'Ryzen 7000') || str_contains($finalValue, 'Zen 4')) {
                                $finalValue = 'Ryzen 7000 (Zen 4)';
                            } elseif (str_contains($finalValue, 'Ryzen 5000') || str_contains($finalValue, 'Zen 3')) {
                                $finalValue = 'Ryzen 5000 (Zen 3)';
                            }
                        }

                        if ($code === 'cpu_socket' || $code === 'mb_cpu_socket') {
                            if (str_contains(strtoupper($finalValue), 'LGA1700') || str_contains(strtoupper($finalValue), 'LGA 1700')) {
                                $finalValue = 'LGA 1700';
                            } elseif (str_contains(strtoupper($finalValue), 'AM5')) {
                                $finalValue = 'AM5';
                            } elseif (str_contains(strtoupper($finalValue), 'AM4')) {
                                $finalValue = 'AM4';
                            }
                        }

                        if ($code === 'ram_type' || $code === 'mb_memory_type') {
                            if (str_contains(strtoupper($finalValue), 'DDR5')) {
                                $finalValue = 'DDR5';
                            } elseif (str_contains(strtoupper($finalValue), 'DDR4')) {
                                $finalValue = 'DDR4';
                            }
                        }

                        ProductSpec::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'spec_definition_id' => $specDef->id,
                            ],
                            [
                                'value' => $finalValue,
                            ]
                        );
                    }
                }
            }
        }
    }

    private function getSpecCode(string $category, string $key): string
    {
        if (isset($this->keyMapping[$category][$key])) {
            return $this->keyMapping[$category][$key];
        }

        // Fallback to slug
        return Str::slug($category . '_' . $key);
    }
}