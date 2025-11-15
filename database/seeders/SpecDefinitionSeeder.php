<?php

namespace Database\Seeders;

use App\Models\ComponentType;
use App\Models\SpecDefinition;
use Illuminate\Database\Seeder;

class SpecDefinitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating spec definitions...');

        // CPU Specs
        $cpuType = ComponentType::where('code', 'cpu')->first();
        if ($cpuType) {
            $cpuSpecs = [
                ['name' => 'Thương hiệu', 'code' => 'cpu_brand', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Dòng sản phẩm', 'code' => 'cpu_segment', 'unit' => null, 'input_type' => 'text', 'sort_order' => 2, 'is_filterable' => true],
                ['name' => 'Thế hệ', 'code' => 'cpu_generation', 'unit' => null, 'input_type' => 'text', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Codename', 'code' => 'cpu_codename', 'unit' => null, 'input_type' => 'text', 'sort_order' => 4],
                ['name' => 'Socket', 'code' => 'cpu_socket', 'unit' => null, 'input_type' => 'text', 'sort_order' => 5, 'is_filterable' => true],
                ['name' => 'Số nhân', 'code' => 'cpu_cores', 'unit' => null, 'input_type' => 'number', 'sort_order' => 6, 'is_filterable' => true],
                ['name' => 'Số luồng', 'code' => 'cpu_threads', 'unit' => null, 'input_type' => 'number', 'sort_order' => 7, 'is_filterable' => true],
                ['name' => 'Xung nhịp cơ sở P-core', 'code' => 'cpu_p_core_base', 'unit' => 'GHz', 'input_type' => 'text', 'sort_order' => 8],
                ['name' => 'Xung nhịp Boost P-core', 'code' => 'cpu_p_core_boost', 'unit' => 'GHz', 'input_type' => 'text', 'sort_order' => 9],
                ['name' => 'Xung nhịp cơ sở E-core', 'code' => 'cpu_e_core_base', 'unit' => 'GHz', 'input_type' => 'text', 'sort_order' => 10],
                ['name' => 'Xung nhịp Boost E-core', 'code' => 'cpu_e_core_boost', 'unit' => 'GHz', 'input_type' => 'text', 'sort_order' => 11],
                ['name' => 'Turbo Boost Max', 'code' => 'cpu_turbo_boost_max', 'unit' => 'GHz', 'input_type' => 'text', 'sort_order' => 12],
                ['name' => 'Bộ nhớ đệm L2', 'code' => 'cpu_l2_cache', 'unit' => 'MB', 'input_type' => 'text', 'sort_order' => 13],
                ['name' => 'Bộ nhớ đệm L3', 'code' => 'cpu_l3_cache', 'unit' => 'MB', 'input_type' => 'text', 'sort_order' => 14],
                ['name' => 'Dung lượng RAM tối đa', 'code' => 'cpu_max_memory', 'unit' => 'GB', 'input_type' => 'number', 'sort_order' => 15],
                ['name' => 'Loại RAM hỗ trợ', 'code' => 'cpu_memory_types', 'unit' => null, 'input_type' => 'text', 'sort_order' => 16],
                ['name' => 'Số kênh RAM', 'code' => 'cpu_memory_channels', 'unit' => null, 'input_type' => 'number', 'sort_order' => 17],
                ['name' => 'Card đồ họa tích hợp', 'code' => 'cpu_igpu', 'unit' => null, 'input_type' => 'text', 'sort_order' => 18],
                ['name' => 'iGPU Base Clock', 'code' => 'cpu_igpu_base', 'unit' => 'MHz', 'input_type' => 'number', 'sort_order' => 19],
                ['name' => 'iGPU Max Clock', 'code' => 'cpu_igpu_max', 'unit' => 'MHz', 'input_type' => 'number', 'sort_order' => 20],
                ['name' => 'PCIe Lanes', 'code' => 'cpu_pcie_lanes', 'unit' => null, 'input_type' => 'text', 'sort_order' => 21],
                ['name' => 'TDP cơ bản', 'code' => 'cpu_base_power', 'unit' => 'W', 'input_type' => 'number', 'sort_order' => 22],
                ['name' => 'TDP Turbo tối đa', 'code' => 'cpu_max_turbo_power', 'unit' => 'W', 'input_type' => 'number', 'sort_order' => 23],
            ];
            
            foreach ($cpuSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $cpuType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $cpuType->id])
                );
            }
            $this->command->info('✅ Created CPU specs');
        }

        // GPU Specs
        $gpuType = ComponentType::where('code', 'gpu')->first();
        if ($gpuType) {
            $gpuSpecs = [
                ['name' => 'Nhân đồ họa', 'code' => 'gpu_chip', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Core Clock', 'code' => 'gpu_core_clock', 'unit' => 'MHz', 'input_type' => 'number', 'sort_order' => 2],
                ['name' => 'CUDA Cores / Stream Processors', 'code' => 'gpu_cuda_cores', 'unit' => null, 'input_type' => 'number', 'sort_order' => 3],
                ['name' => 'Dung lượng bộ nhớ', 'code' => 'gpu_memory_size', 'unit' => 'GB', 'input_type' => 'number', 'sort_order' => 4, 'is_filterable' => true],
                ['name' => 'Loại bộ nhớ', 'code' => 'gpu_memory_type', 'unit' => null, 'input_type' => 'text', 'sort_order' => 5, 'is_filterable' => true],
                ['name' => 'Memory Clock', 'code' => 'gpu_memory_clock', 'unit' => 'Gbps', 'input_type' => 'text', 'sort_order' => 6],
                ['name' => 'Memory Bus', 'code' => 'gpu_memory_bus', 'unit' => 'bit', 'input_type' => 'number', 'sort_order' => 7],
                ['name' => 'Card Bus', 'code' => 'gpu_card_bus', 'unit' => null, 'input_type' => 'text', 'sort_order' => 8],
                ['name' => 'Độ phân giải tối đa', 'code' => 'gpu_max_resolution', 'unit' => null, 'input_type' => 'text', 'sort_order' => 9],
                ['name' => 'Multi-view outputs', 'code' => 'gpu_multi_view', 'unit' => null, 'input_type' => 'number', 'sort_order' => 10],
                ['name' => 'Chiều dài card', 'code' => 'gpu_card_length', 'unit' => 'mm', 'input_type' => 'number', 'sort_order' => 11],
                ['name' => 'Chiều rộng card', 'code' => 'gpu_card_width', 'unit' => 'mm', 'input_type' => 'number', 'sort_order' => 12],
                ['name' => 'Chiều cao card', 'code' => 'gpu_card_height', 'unit' => 'mm', 'input_type' => 'number', 'sort_order' => 13],
                ['name' => 'PCB Form Factor', 'code' => 'gpu_pcb_form', 'unit' => null, 'input_type' => 'text', 'sort_order' => 14],
                ['name' => 'DirectX', 'code' => 'gpu_directx', 'unit' => null, 'input_type' => 'text', 'sort_order' => 15],
                ['name' => 'OpenGL', 'code' => 'gpu_opengl', 'unit' => null, 'input_type' => 'text', 'sort_order' => 16],
                ['name' => 'Nguồn khuyến nghị', 'code' => 'gpu_recommended_psu', 'unit' => 'W', 'input_type' => 'number', 'sort_order' => 17],
                ['name' => 'Cổng nguồn', 'code' => 'gpu_power_connectors', 'unit' => null, 'input_type' => 'text', 'sort_order' => 18],
                ['name' => 'Cổng xuất hình', 'code' => 'gpu_output_ports', 'unit' => null, 'input_type' => 'text', 'sort_order' => 19],
            ];
            
            foreach ($gpuSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $gpuType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $gpuType->id])
                );
            }
            $this->command->info('✅ Created GPU specs');
        }

        // RAM Specs
        $ramType = ComponentType::where('code', 'ram')->first();
        if ($ramType) {
            $ramSpecs = [
                ['name' => 'Loại RAM', 'code' => 'ram_type', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Tên model', 'code' => 'ram_model_name', 'unit' => null, 'input_type' => 'text', 'sort_order' => 2],
                ['name' => 'Dung lượng', 'code' => 'ram_capacity', 'unit' => 'GB', 'input_type' => 'number', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Loại module', 'code' => 'ram_module_type', 'unit' => null, 'input_type' => 'text', 'sort_order' => 4],
                ['name' => 'Tốc độ (Bus)', 'code' => 'ram_speed', 'unit' => 'MHz', 'input_type' => 'number', 'sort_order' => 5, 'is_filterable' => true],
                ['name' => 'Latency', 'code' => 'ram_latency', 'unit' => null, 'input_type' => 'text', 'sort_order' => 6],
                ['name' => 'Điện áp', 'code' => 'ram_voltage', 'unit' => 'V', 'input_type' => 'text', 'sort_order' => 7],
                ['name' => 'ECC', 'code' => 'ram_ecc', 'unit' => null, 'input_type' => 'text', 'sort_order' => 8, 'is_filterable' => true],
                ['name' => 'Màu sắc', 'code' => 'ram_color', 'unit' => null, 'input_type' => 'text', 'sort_order' => 9],
                ['name' => 'Tản nhiệt', 'code' => 'ram_heatsink', 'unit' => null, 'input_type' => 'text', 'sort_order' => 10],
                ['name' => 'RGB', 'code' => 'ram_rgb', 'unit' => null, 'input_type' => 'text', 'sort_order' => 11],
            ];
            
            foreach ($ramSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $ramType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $ramType->id])
                );
            }
            $this->command->info('✅ Created RAM specs');
        }

        // SSD Specs
        $ssdType = ComponentType::where('code', 'ssd')->first();
        if ($ssdType) {
            $ssdSpecs = [
                ['name' => 'Series', 'code' => 'ssd_series', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1],
                ['name' => 'Dung lượng', 'code' => 'ssd_capacity', 'unit' => 'GB', 'input_type' => 'number', 'sort_order' => 2, 'is_filterable' => true],
                ['name' => 'Form Factor', 'code' => 'ssd_form_factor', 'unit' => null, 'input_type' => 'text', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Loại NAND', 'code' => 'ssd_nand_type', 'unit' => null, 'input_type' => 'text', 'sort_order' => 4],
                ['name' => 'Chuẩn kết nối', 'code' => 'ssd_interface', 'unit' => null, 'input_type' => 'text', 'sort_order' => 5, 'is_filterable' => true],
                ['name' => 'Tốc độ đọc tuần tự', 'code' => 'ssd_seq_read', 'unit' => 'MB/s', 'input_type' => 'number', 'sort_order' => 6],
                ['name' => 'Tốc độ ghi tuần tự', 'code' => 'ssd_seq_write', 'unit' => 'MB/s', 'input_type' => 'number', 'sort_order' => 7],
                ['name' => 'IOPS đọc ngẫu nhiên', 'code' => 'ssd_rand_read_iops', 'unit' => 'K IOPS', 'input_type' => 'number', 'sort_order' => 8],
                ['name' => 'IOPS ghi ngẫu nhiên', 'code' => 'ssd_rand_write_iops', 'unit' => 'K IOPS', 'input_type' => 'number', 'sort_order' => 9],
                ['name' => 'Độ bền (TBW)', 'code' => 'ssd_endurance_tbw', 'unit' => 'TB', 'input_type' => 'text', 'sort_order' => 10],
                ['name' => 'Nhiệt độ hoạt động tối thiểu', 'code' => 'ssd_temp_min', 'unit' => '°C', 'input_type' => 'number', 'sort_order' => 11],
                ['name' => 'Nhiệt độ hoạt động tối đa', 'code' => 'ssd_temp_max', 'unit' => '°C', 'input_type' => 'number', 'sort_order' => 12],
            ];
            
            foreach ($ssdSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $ssdType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $ssdType->id])
                );
            }
            $this->command->info('✅ Created SSD specs');
        }

        // Monitor Specs
        $monitorType = ComponentType::where('code', 'monitor')->first();
        if ($monitorType) {
            $monitorSpecs = [
                ['name' => 'Kích thước màn hình', 'code' => 'monitor_size', 'unit' => 'inch', 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Độ phân giải', 'code' => 'monitor_resolution', 'unit' => null, 'input_type' => 'text', 'sort_order' => 2, 'is_filterable' => true],
                ['name' => 'Tần số quét', 'code' => 'monitor_refresh_rate', 'unit' => 'Hz', 'input_type' => 'number', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Thời gian phản hồi', 'code' => 'monitor_response_time', 'unit' => 'ms', 'input_type' => 'text', 'sort_order' => 4],
                ['name' => 'Tấm nền', 'code' => 'monitor_panel_type', 'unit' => null, 'input_type' => 'text', 'sort_order' => 5],
                ['name' => 'Độ cong', 'code' => 'monitor_curvature', 'unit' => null, 'input_type' => 'text', 'sort_order' => 6],
                ['name' => 'Cổng kết nối', 'code' => 'monitor_ports', 'unit' => null, 'input_type' => 'textarea', 'sort_order' => 7],
            ];
            
            foreach ($monitorSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $monitorType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $monitorType->id])
                );
            }
            $this->command->info('✅ Created Monitor specs');
        }

        // Mainboard Specs
        $mainboardType = ComponentType::where('code', 'mainboard')->first();
        if ($mainboardType) {
            $mainboardSpecs = [
                ['name' => 'Form Factor', 'code' => 'mb_form_factor', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Socket CPU', 'code' => 'mb_cpu_socket', 'unit' => null, 'input_type' => 'text', 'sort_order' => 2, 'is_filterable' => true],
                ['name' => 'Chipset', 'code' => 'mb_chipset', 'unit' => null, 'input_type' => 'text', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Loại RAM', 'code' => 'mb_memory_type', 'unit' => null, 'input_type' => 'text', 'sort_order' => 4, 'is_filterable' => true],
                ['name' => 'Số khe RAM', 'code' => 'mb_memory_slots', 'unit' => null, 'input_type' => 'number', 'sort_order' => 5, 'is_filterable' => true],
                ['name' => 'Dung lượng RAM tối đa', 'code' => 'mb_max_memory', 'unit' => 'GB', 'input_type' => 'number', 'sort_order' => 6, 'is_filterable' => true],
                ['name' => 'Tốc độ RAM hỗ trợ', 'code' => 'mb_memory_speed', 'unit' => null, 'input_type' => 'text', 'sort_order' => 7],
                ['name' => 'Số cổng SATA', 'code' => 'mb_sata_ports', 'unit' => null, 'input_type' => 'number', 'sort_order' => 8],
                ['name' => 'Số khe M.2', 'code' => 'mb_m2_slots', 'unit' => null, 'input_type' => 'number', 'sort_order' => 9],
                ['name' => 'Hỗ trợ RAID', 'code' => 'mb_raid_support', 'unit' => null, 'input_type' => 'text', 'sort_order' => 10],
                ['name' => 'Audio Codec', 'code' => 'mb_audio_codec', 'unit' => null, 'input_type' => 'text', 'sort_order' => 11],
                ['name' => 'LAN Chipset', 'code' => 'mb_lan_chipset', 'unit' => null, 'input_type' => 'text', 'sort_order' => 12],
                ['name' => 'Tốc độ LAN', 'code' => 'mb_lan_speed', 'unit' => 'Gbps', 'input_type' => 'text', 'sort_order' => 13],
                ['name' => 'Cổng USB mặt sau', 'code' => 'mb_rear_usb_ports', 'unit' => null, 'input_type' => 'text', 'sort_order' => 14],
                ['name' => 'Cổng hiển thị mặt sau', 'code' => 'mb_rear_display_ports', 'unit' => null, 'input_type' => 'text', 'sort_order' => 15],
                ['name' => 'Jack âm thanh mặt sau', 'code' => 'mb_rear_audio_jacks', 'unit' => null, 'input_type' => 'text', 'sort_order' => 16],
                ['name' => 'Header USB onboard', 'code' => 'mb_onboard_usb_headers', 'unit' => null, 'input_type' => 'text', 'sort_order' => 17],
                ['name' => 'Header RGB', 'code' => 'mb_rgb_headers', 'unit' => null, 'input_type' => 'text', 'sort_order' => 18],
                ['name' => 'Header quạt', 'code' => 'mb_fan_headers', 'unit' => null, 'input_type' => 'text', 'sort_order' => 19],
                ['name' => 'Chiều dài bo mạch', 'code' => 'mb_board_length', 'unit' => 'cm', 'input_type' => 'text', 'sort_order' => 20],
                ['name' => 'Chiều rộng bo mạch', 'code' => 'mb_board_width', 'unit' => 'cm', 'input_type' => 'text', 'sort_order' => 21],
                ['name' => 'Cổng nguồn', 'code' => 'mb_power_connectors', 'unit' => null, 'input_type' => 'text', 'sort_order' => 22],
            ];
            
            foreach ($mainboardSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $mainboardType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $mainboardType->id])
                );
            }
            $this->command->info('✅ Created Mainboard specs');
        }

        // PSU Specs
        $psuType = ComponentType::where('code', 'psu')->first();
        if ($psuType) {
            $psuSpecs = [
                ['name' => 'Hãng sản xuất', 'code' => 'psu_brand', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Công suất định danh', 'code' => 'psu_wattage', 'unit' => 'W', 'input_type' => 'number', 'sort_order' => 2, 'is_filterable' => true],
                ['name' => 'Chuẩn hiệu suất', 'code' => 'psu_efficiency', 'unit' => null, 'input_type' => 'text', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Kích thước nguồn', 'code' => 'psu_form_factor', 'unit' => null, 'input_type' => 'text', 'sort_order' => 4, 'is_filterable' => true],
                ['name' => 'Modular', 'code' => 'psu_modular', 'unit' => null, 'input_type' => 'text', 'sort_order' => 5, 'is_filterable' => true],
                ['name' => 'Màu sắc', 'code' => 'psu_color', 'unit' => null, 'input_type' => 'text', 'sort_order' => 6, 'is_filterable' => true],
                ['name' => 'Quạt làm mát', 'code' => 'psu_fan_size', 'unit' => 'mm', 'input_type' => 'text', 'sort_order' => 7],
                ['name' => 'Cổng PCIe', 'code' => 'psu_pcie_connectors', 'unit' => null, 'input_type' => 'text', 'sort_order' => 8],
                ['name' => 'Cổng EPS/CPU', 'code' => 'psu_eps_connectors', 'unit' => null, 'input_type' => 'text', 'sort_order' => 9],
                ['name' => 'Cổng SATA', 'code' => 'psu_sata_connectors', 'unit' => null, 'input_type' => 'number', 'sort_order' => 10],
                ['name' => 'Chiều dài', 'code' => 'psu_length', 'unit' => 'mm', 'input_type' => 'number', 'sort_order' => 11],
                ['name' => 'Bảo hành', 'code' => 'psu_warranty', 'unit' => 'năm', 'input_type' => 'number', 'sort_order' => 12],
            ];
            
            foreach ($psuSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $psuType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $psuType->id])
                );
            }
            $this->command->info('✅ Created PSU specs');
        }

        // Case Specs
        $caseType = ComponentType::where('code', 'case')->first();
        if ($caseType) {
            $caseSpecs = [
                ['name' => 'Hãng sản xuất', 'code' => 'case_brand', 'unit' => null, 'input_type' => 'text', 'sort_order' => 1, 'is_filterable' => true],
                ['name' => 'Form Factor', 'code' => 'case_form_factor', 'unit' => null, 'input_type' => 'text', 'sort_order' => 2, 'is_filterable' => true],
                ['name' => 'Màu sắc', 'code' => 'case_color', 'unit' => null, 'input_type' => 'text', 'sort_order' => 3, 'is_filterable' => true],
                ['name' => 'Chất liệu', 'code' => 'case_material', 'unit' => null, 'input_type' => 'text', 'sort_order' => 4],
                ['name' => 'Hỗ trợ mainboard', 'code' => 'case_mobo_support', 'unit' => null, 'input_type' => 'text', 'sort_order' => 5],
                ['name' => 'Chiều dài card đồ họa tối đa', 'code' => 'case_gpu_clearance', 'unit' => 'mm', 'input_type' => 'number', 'sort_order' => 6],
                ['name' => 'Chiều cao CPU Cooler tối đa', 'code' => 'case_cpu_cooler_height', 'unit' => 'mm', 'input_type' => 'number', 'sort_order' => 7],
                ['name' => 'Số vị trí quạt', 'code' => 'case_fan_slots', 'unit' => null, 'input_type' => 'text', 'sort_order' => 8],
                ['name' => 'Khe 3.5" HDD', 'code' => 'case_hdd_35_slots', 'unit' => null, 'input_type' => 'number', 'sort_order' => 9],
                ['name' => 'Khe 2.5" SSD', 'code' => 'case_ssd_25_slots', 'unit' => null, 'input_type' => 'number', 'sort_order' => 10],
                ['name' => 'Cổng I/O mặt trước', 'code' => 'case_front_io', 'unit' => null, 'input_type' => 'text', 'sort_order' => 11],
                ['name' => 'Cửa sổ kính', 'code' => 'case_side_panel', 'unit' => null, 'input_type' => 'text', 'sort_order' => 12, 'is_filterable' => true],
                ['name' => 'RGB', 'code' => 'case_rgb', 'unit' => null, 'input_type' => 'text', 'sort_order' => 13],
            ];
            
            foreach ($caseSpecs as $spec) {
                SpecDefinition::updateOrCreate(
                    ['component_type_id' => $caseType->id, 'code' => $spec['code']],
                    array_merge($spec, ['component_type_id' => $caseType->id])
                );
            }
            $this->command->info('✅ Created Case specs');
        }

        $this->command->info('✅ All spec definitions created successfully!');
    }
}

