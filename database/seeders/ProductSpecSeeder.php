<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Models\SpecDefinition;
use Illuminate\Support\Facades\File;

class ProductSpecSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Seeding product specifications from hardware_products_detailed.json...');

        $jsonPath = base_path('hardware_products_detailed.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('❌ File hardware_products_detailed.json not found!');
            return;
        }

        $jsonContent = File::get($jsonPath);
        $data = json_decode($jsonContent, true);

        if (!$data) {
            $this->command->error('❌ Failed to parse JSON file!');
            return;
        }

        $totalSpecs = 0;

        $totalProducts = array_sum(array_map('count', $data));
        $bar = $this->command->getOutput()->createProgressBar($totalProducts);
        $bar->start();

        foreach ($data as $categoryKey => $products) {
            foreach ($products as $productData) {
                $this->seedProductSpecs($categoryKey, $productData, $totalSpecs);
                $bar->advance();
            }
        }

        $bar->finish();
        $this->command->newLine(2);
        $this->command->info("✅ Product specifications seeded successfully!");
        $this->command->info("📊 Total specs created: {$totalSpecs}");
    }

    private function seedProductSpecs(string $categoryKey, array $productData, int &$totalSpecs): void
    {
        // Find product by name
        $productName = "{$productData['brand']} {$productData['model']}";
        $product = Product::where('name', 'LIKE', "%{$productName}%")->first();

        if (!$product) {
            return;
        }

        $specs = $productData['specs'] ?? [];

        switch ($categoryKey) {
            case 'CPU':
                $totalSpecs += $this->seedCPUSpecs($product, $productData, $specs);
                break;
            case 'GPU':
                $totalSpecs += $this->seedGPUSpecs($product, $productData, $specs);
                break;
            case 'RAM':
                $totalSpecs += $this->seedRAMSpecs($product, $productData, $specs);
                break;
            case 'SSD':
                $totalSpecs += $this->seedSSDSpecs($product, $productData, $specs);
                break;
            case 'Mainboard':
                $totalSpecs += $this->seedMainboardSpecs($product, $productData, $specs);
                break;
        }
    }

    private function seedCPUSpecs(Product $product, array $productData, array $specs): int
    {
        $count = 0;
        $mapping = [
            'cpu_brand' => $productData['brand'],
            'cpu_segment' => $specs['segment'] ?? null,
            'cpu_generation' => $specs['generation'] ?? null,
            'cpu_codename' => $specs['codename'] ?? null,
            'cpu_socket' => $specs['socket'] ?? null,
            'cpu_cores' => $specs['cores'] ?? null,
            'cpu_threads' => $specs['threads'] ?? null,
            'cpu_p_core_base' => $specs['p_core_base_ghz'] ?? null,
            'cpu_p_core_boost' => $specs['p_core_boost_ghz'] ?? null,
            'cpu_e_core_base' => $specs['e_core_base_ghz'] ?? null,
            'cpu_e_core_boost' => $specs['e_core_boost_ghz'] ?? null,
            'cpu_turbo_boost_max' => $specs['turbo_boost_max_ghz'] ?? null,
            'cpu_l2_cache' => $specs['l2_cache_mb'] ?? null,
            'cpu_l3_cache' => $specs['l3_cache_mb'] ?? null,
            'cpu_max_memory' => $specs['max_memory_gb'] ?? null,
            'cpu_memory_types' => $specs['memory_types'] ?? null,
            'cpu_memory_channels' => $specs['memory_channels'] ?? null,
            'cpu_igpu' => $specs['integrated_graphics'] ?? null,
            'cpu_igpu_base' => $specs['igpu_base_clock_mhz'] ?? null,
            'cpu_igpu_max' => $specs['igpu_max_clock_mhz'] ?? null,
            'cpu_pcie_lanes' => $specs['pcie_lanes'] ?? null,
            'cpu_base_power' => $specs['base_power_w'] ?? null,
            'cpu_max_turbo_power' => $specs['max_turbo_power_w'] ?? null,
        ];

        foreach ($mapping as $code => $value) {
            if ($value !== null) {
                $count += $this->createSpec($product, $code, $value);
            }
        }

        return $count;
    }

    private function seedGPUSpecs(Product $product, array $productData, array $specs): int
    {
        $count = 0;
        $mapping = [
            'gpu_chip' => $specs['gpu_chip'] ?? null,
            'gpu_core_clock' => $specs['core_clock_mhz'] ?? null,
            'gpu_cuda_cores' => $specs['cuda_cores'] ?? null,
            'gpu_memory_size' => $specs['memory_size_gb'] ?? null,
            'gpu_memory_type' => $specs['memory_type'] ?? null,
            'gpu_memory_clock' => isset($specs['memory_clock_gbps']) ? $specs['memory_clock_gbps'] . ' Gbps' : null,
            'gpu_memory_bus' => $specs['memory_bus_bit'] ?? null,
            'gpu_card_bus' => $specs['card_bus'] ?? null,
            'gpu_max_resolution' => $specs['digital_max_resolution'] ?? null,
            'gpu_multi_view' => $specs['multi_view_outputs'] ?? null,
            'gpu_card_length' => $specs['card_length_mm'] ?? null,
            'gpu_card_width' => $specs['card_width_mm'] ?? null,
            'gpu_card_height' => $specs['card_height_mm'] ?? null,
            'gpu_pcb_form' => $specs['pcb_form_factor'] ?? null,
            'gpu_directx' => $specs['directx_support'] ?? null,
            'gpu_opengl' => $specs['opengl_support'] ?? null,
            'gpu_recommended_psu' => $specs['recommended_psu_w'] ?? null,
            'gpu_power_connectors' => $specs['power_connectors'] ?? null,
            'gpu_output_ports' => $specs['output_ports'] ?? null,
        ];

        foreach ($mapping as $code => $value) {
            if ($value !== null) {
                $count += $this->createSpec($product, $code, $value);
            }
        }

        return $count;
    }

    private function seedRAMSpecs(Product $product, array $productData, array $specs): int
    {
        $count = 0;
        $mapping = [
            'ram_type' => $specs['ram_type'] ?? null,
            'ram_model_name' => $specs['model_name'] ?? null,
            'ram_capacity' => $specs['capacity_gb'] ?? null,
            'ram_module_type' => $specs['module_type'] ?? null,
            'ram_speed' => $specs['speed_mhz'] ?? null,
            'ram_latency' => $specs['latency'] ?? null,
            'ram_voltage' => $specs['voltage_v'] ?? null,
            'ram_ecc' => $specs['ecc'] ?? null,
            'ram_color' => $specs['color'] ?? null,
            'ram_heatsink' => isset($specs['heatsink']) ? ($specs['heatsink'] ? 'Có' : 'Không') : null,
            'ram_rgb' => isset($specs['rgb']) ? ($specs['rgb'] ? 'Có' : 'Không') : null,
        ];

        foreach ($mapping as $code => $value) {
            if ($value !== null) {
                $count += $this->createSpec($product, $code, $value);
            }
        }

        return $count;
    }

    private function seedSSDSpecs(Product $product, array $productData, array $specs): int
    {
        $count = 0;
        $mapping = [
            'ssd_series' => $specs['series'] ?? null,
            'ssd_capacity' => $specs['capacity_gb'] ?? null,
            'ssd_form_factor' => $specs['form_factor'] ?? null,
            'ssd_nand_type' => $specs['nand_type'] ?? null,
            'ssd_interface' => $specs['interface'] ?? null,
            'ssd_seq_read' => $specs['seq_read_mb_s'] ?? null,
            'ssd_seq_write' => $specs['seq_write_mb_s'] ?? null,
            'ssd_rand_read_iops' => isset($specs['rand_read_iops']) ? ($specs['rand_read_iops'] / 1000) : null,
            'ssd_rand_write_iops' => isset($specs['rand_write_iops']) ? ($specs['rand_write_iops'] / 1000) : null,
            'ssd_endurance_tbw' => $specs['endurance_tbw'] ?? null,
            'ssd_temp_min' => $specs['operating_temp_min_c'] ?? null,
            'ssd_temp_max' => $specs['operating_temp_max_c'] ?? null,
        ];

        foreach ($mapping as $code => $value) {
            if ($value !== null) {
                $count += $this->createSpec($product, $code, $value);
            }
        }

        return $count;
    }

    private function seedMainboardSpecs(Product $product, array $productData, array $specs): int
    {
        $count = 0;
        $mapping = [
            'mb_form_factor' => $specs['form_factor'] ?? null,
            'mb_cpu_socket' => $specs['cpu_socket'] ?? null,
            'mb_chipset' => $specs['chipset'] ?? null,
            'mb_memory_type' => $specs['memory_type'] ?? null,
            'mb_memory_slots' => $specs['memory_slots'] ?? null,
            'mb_max_memory' => $specs['max_memory_gb'] ?? null,
            'mb_memory_speed' => $specs['memory_speed_support'] ?? null,
            'mb_sata_ports' => $specs['sata_ports'] ?? null,
            'mb_m2_slots' => $specs['m2_slots'] ?? null,
            'mb_raid_support' => $specs['raid_support'] ?? null,
            'mb_audio_codec' => $specs['audio_codec'] ?? null,
            'mb_lan_chipset' => $specs['lan_chipset'] ?? null,
            'mb_lan_speed' => $specs['lan_speed_gbps'] ?? null,
            'mb_rear_usb_ports' => $specs['rear_usb_ports'] ?? null,
            'mb_rear_display_ports' => $specs['rear_display_ports'] ?? null,
            'mb_rear_audio_jacks' => $specs['rear_audio_jacks'] ?? null,
            'mb_onboard_usb_headers' => $specs['onboard_usb_headers'] ?? null,
            'mb_rgb_headers' => $specs['rgb_headers'] ?? null,
            'mb_fan_headers' => $specs['fan_headers'] ?? null,
            'mb_board_length' => $specs['board_length_cm'] ?? null,
            'mb_board_width' => $specs['board_width_cm'] ?? null,
            'mb_power_connectors' => $specs['power_connectors'] ?? null,
        ];

        foreach ($mapping as $code => $value) {
            if ($value !== null) {
                $count += $this->createSpec($product, $code, $value);
            }
        }

        return $count;
    }

    private function createSpec(Product $product, string $code, $value): int
    {
        $specDefinition = SpecDefinition::where('code', $code)->first();

        if (!$specDefinition) {
            return 0;
        }

        ProductSpec::updateOrCreate(
            [
                'product_id' => $product->id,
                'spec_definition_id' => $specDefinition->id,
            ],
            [
                'value' => (string) $value,
            ]
        );

        return 1;
    }
}
