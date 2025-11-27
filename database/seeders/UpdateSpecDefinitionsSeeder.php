<?php

namespace Database\Seeders;

use App\Models\SpecDefinition;
use Illuminate\Database\Seeder;

class UpdateSpecDefinitionsSeeder extends Seeder
{
    public function run(): void
    {
        // List of spec codes that should be filterable
        $filterableSpecs = [
            'cpu_socket', 'cpu_cores', 'cpu_threads', 'cpu_series',
            'vga_chipset', 'vga_vram', 'vga_series',
            'ram_type', 'ram_capacity', 'ram_bus',
            'ssd_capacity', 'ssd_type', 'ssd_interface',
            'mainboard_chipset', 'mainboard_socket', 'mainboard_size',
            'monitor_size', 'monitor_resolution', 'monitor_refresh_rate', 'monitor_panel_type',
            'psu_wattage', 'psu_efficiency',
            'case_size', 'case_material'
        ];

        foreach ($filterableSpecs as $code) {
            // We use 'like' because the actual codes might have prefixes like 'cpu_processor_socket'
            // or the seeder generated them as 'cpu_socket' (based on the json keys).
            // The previous seeder used: Str::slug($categoryName . '_' . $specKey)
            // So for CPU category and 'socket' key, it would be 'cpu_socket' or 'cpu_processor_socket' depending on category name.
            
            SpecDefinition::where('code', 'like', "%{$code}%")
                ->update(['is_filterable' => true]);
        }
        
        // Also update based on common names if codes are hard to guess
        $filterableNames = [
            'Socket', 'Chipset', 'Dung lượng', 'Bus', 'VRAM', 'Kích thước', 'Độ phân giải', 'Tần số quét', 'Công suất'
        ];
        
        foreach ($filterableNames as $name) {
            SpecDefinition::where('name', 'like', "%{$name}%")
                ->update(['is_filterable' => true]);
        }
        
        $this->command->info('Updated SpecDefinitions to be filterable.');
    }
}
