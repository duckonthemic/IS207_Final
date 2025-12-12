<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\PcCompatibilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PcCompatibilityServiceTest extends TestCase
{
    protected PcCompatibilityService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PcCompatibilityService();
    }

    // ============================================
    // LAYER 1: PHYSICAL COMPATIBILITY TESTS
    // ============================================

    /** @test */
    public function it_detects_socket_mismatch_between_cpu_and_mainboard()
    {
        $components = [
            'cpu' => [
                'name' => 'Intel Core i5-14400F',
                'specs' => ['cpu_socket' => 'LGA1700']
            ],
            'mainboard' => [
                'name' => 'ASUS ROG Strix B650E-F',
                'specs' => ['mb_socket' => 'AM5', 'mb_chipset' => 'B650E']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertNotEmpty($result['errors']);
        $this->assertStringContainsString('socket', $result['errors'][0]);
    }

    /** @test */
    public function it_allows_matching_socket_between_cpu_and_mainboard()
    {
        $components = [
            'cpu' => [
                'name' => 'AMD Ryzen 5 7600',
                'specs' => ['cpu_socket' => 'AM5']
            ],
            'mainboard' => [
                'name' => 'ASUS ROG Strix B650E-F',
                'specs' => ['mb_socket' => 'AM5', 'mb_memory_type' => 'DDR5']
            ],
        ];

        $result = $this->service->checkPhysicalCompatibility($components);

        $this->assertEmpty($result['errors']);
    }

    /** @test */
    public function it_detects_ram_type_mismatch()
    {
        $components = [
            'mainboard' => [
                'name' => 'MSI MAG B760 Tomahawk',
                'specs' => ['mb_socket' => 'LGA1700', 'mb_memory_type' => 'DDR5']
            ],
            'ram' => [
                'name' => 'Kingston Fury Beast DDR4',
                'specs' => ['ram_type' => 'DDR4']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertStringContainsString('RAM', $result['errors'][0]);
    }

    /** @test */
    public function it_detects_gpu_length_exceeds_case_limit()
    {
        $components = [
            'gpu' => [
                'name' => 'RTX 4090',
                'specs' => ['gpu_length_mm' => 400]
            ],
            'case' => [
                'name' => 'NZXT H5 Flow',
                'specs' => ['case_gpu_length' => 365, 'case_type' => 'Mid Tower']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertStringContainsString('GPU', $result['errors'][0]);
        $this->assertStringContainsString('400mm', $result['errors'][0]);
    }

    /** @test */
    public function it_detects_cooler_height_exceeds_case_limit()
    {
        $components = [
            'cooler' => [
                'name' => 'Noctua NH-D15',
                'specs' => ['cooler_type' => 'Air', 'cooler_height' => 165]
            ],
            'case' => [
                'name' => 'Mini ITX Case',
                'specs' => ['case_cooler_height' => 150, 'case_type' => 'Mini Tower']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertStringContainsString('Tản nhiệt', $result['errors'][0]);
    }

    /** @test */
    public function it_detects_mainboard_form_factor_incompatible_with_case()
    {
        $components = [
            'mainboard' => [
                'name' => 'ASUS ROG Maximus',
                'specs' => ['mb_form_factor' => 'E-ATX']
            ],
            'case' => [
                'name' => 'NZXT H1 V2',
                'specs' => ['case_type' => 'Mini Tower', 'case_motherboard_support' => ['mATX', 'Mini-ITX']]
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertStringContainsString('E-ATX', $result['errors'][0]);
    }

    // ============================================
    // LAYER 2: PERFORMANCE/BOTTLENECK TESTS
    // ============================================

    /** @test */
    public function it_warns_when_high_tier_cpu_paired_with_low_tier_mainboard()
    {
        $components = [
            'cpu' => [
                'name' => 'Intel Core i9-14900K',
                'tier' => 4,
                'specs' => ['cpu_socket' => 'LGA1700']
            ],
            'mainboard' => [
                'name' => 'Gigabyte H610M',
                'tier' => 1,
                'specs' => ['mb_socket' => 'LGA1700', 'mb_chipset' => 'H610']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertNotEmpty($result['warnings']);
        $this->assertStringContainsString('Tier 4', $result['warnings'][0]);
        $this->assertStringContainsString('Tier 1', $result['warnings'][0]);
    }

    /** @test */
    public function it_infers_cpu_tier_from_name_when_tier_not_set()
    {
        $components = [
            'cpu' => [
                'name' => 'AMD Ryzen 7 7800X3D',
                'specs' => ['cpu_socket' => 'AM5']
            ],
            'mainboard' => [
                'name' => 'MSI A520M',
                'specs' => ['mb_socket' => 'AM5', 'mb_chipset' => 'A520']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        // Ryzen 7 = Tier 3, A520 = Tier 1 -> Should warn about bottleneck
        $this->assertNotEmpty($result['warnings']);
        $this->assertStringContainsString('VRM', $result['warnings'][0]);
    }

    /** @test */
    public function it_suggests_when_mainboard_is_overkill_for_cpu()
    {
        $components = [
            'cpu' => [
                'name' => 'Intel Core i3-12100',
                'tier' => 1,
                'specs' => ['cpu_socket' => 'LGA1700']
            ],
            'mainboard' => [
                'name' => 'ASUS ROG Maximus Z790',
                'tier' => 3,
                'specs' => ['mb_socket' => 'LGA1700', 'mb_chipset' => 'Z790']
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        // Should have no errors but have info suggestion
        $this->assertTrue($result['isValid']);
        $this->assertNotEmpty($result['info']);
        $this->assertStringContainsString('tối ưu chi phí', $result['info'][0]);
    }

    // ============================================
    // LAYER 3: POWER CONSUMPTION TESTS
    // ============================================

    /** @test */
    public function it_detects_insufficient_psu_wattage()
    {
        $components = [
            'cpu' => [
                'name' => 'Intel Core i7-14700K',
                'specs' => ['cpu_tdp' => 125]
            ],
            'gpu' => [
                'name' => 'RTX 4070 Super',
                'specs' => ['gpu_tdp' => 220]
            ],
            'psu' => [
                'name' => 'Generic 450W',
                'specs' => ['psu_wattage' => 450]
            ],
        ];

        // Total TDP = 125 + 220 + 50 = 395W, need 474W (x1.2)
        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertStringContainsString('không đủ', $result['errors'][0]);
    }

    /** @test */
    public function it_suggests_when_psu_is_near_limit()
    {
        $components = [
            'cpu' => [
                'name' => 'Intel Core i5-14400F',
                'specs' => ['cpu_tdp' => 65]
            ],
            'gpu' => [
                'name' => 'RTX 4060',
                'specs' => ['gpu_tdp' => 115]
            ],
            'psu' => [
                'name' => 'Corsair 500W',
                'specs' => ['psu_wattage' => 500]
            ],
        ];

        // Total TDP = 65 + 115 + 50 = 230W
        // Required (x1.2) = 276W, Recommended (x1.3) = 299W
        // 500W should be fine with no warnings
        $result = $this->service->analyzeConfiguration($components);

        $this->assertTrue($result['isValid']);
    }

    /** @test */
    public function it_detects_insufficient_pcie_connectors()
    {
        $components = [
            'gpu' => [
                'name' => 'AMD RX 7800 XT',
                'specs' => ['gpu_power_connectors' => '2x 8-pin PCIe']
            ],
            'psu' => [
                'name' => 'Budget PSU',
                'specs' => ['psu_wattage' => 700, 'psu_pcie_8pin' => 1]
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertStringContainsString('8-pin', $result['errors'][0]);
    }

    /** @test */
    public function it_informs_about_12vhpwr_requirement()
    {
        $components = [
            'gpu' => [
                'name' => 'NVIDIA RTX 4070 Super',
                'specs' => ['gpu_power_connectors' => '1x 16-pin 12VHPWR', 'gpu_tdp' => 220]
            ],
            'psu' => [
                'name' => 'Old PSU',
                'specs' => ['psu_wattage' => 750, 'psu_12vhpwr' => 0]
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        // Should have info about 12VHPWR
        $this->assertNotEmpty($result['info']);
        $hasAdapterInfo = false;
        foreach ($result['info'] as $info) {
            if (stripos($info, '12VHPWR') !== false) {
                $hasAdapterInfo = true;
                break;
            }
        }
        $this->assertTrue($hasAdapterInfo);
    }

    // ============================================
    // COMBINED SCENARIOS
    // ============================================

    /** @test */
    public function it_validates_a_fully_compatible_build()
    {
        $components = [
            'cpu' => [
                'name' => 'AMD Ryzen 5 7600',
                'tier' => 2,
                'specs' => ['cpu_socket' => 'AM5', 'cpu_tdp' => 65]
            ],
            'mainboard' => [
                'name' => 'ASUS ROG Strix B650E-F',
                'tier' => 2,
                'specs' => ['mb_socket' => 'AM5', 'mb_memory_type' => 'DDR5', 'mb_form_factor' => 'ATX', 'mb_chipset' => 'B650E']
            ],
            'ram' => [
                'name' => 'Corsair Vengeance DDR5 32GB',
                'specs' => ['ram_type' => 'DDR5']
            ],
            'gpu' => [
                'name' => 'NVIDIA RTX 4070 Super',
                'specs' => ['gpu_tdp' => 220, 'gpu_length_mm' => 267]
            ],
            'psu' => [
                'name' => 'Corsair RM750x',
                'specs' => ['psu_wattage' => 750, 'psu_pcie_8pin' => 3, 'psu_12vhpwr' => 1]
            ],
            'case' => [
                'name' => 'Lian Li Lancool 216',
                'specs' => ['case_type' => 'Mid Tower', 'case_gpu_length' => 392, 'case_cooler_height' => 180, 'case_motherboard_support' => ['E-ATX', 'ATX', 'mATX', 'Mini-ITX']]
            ],
            'cooler' => [
                'name' => 'Noctua NH-D15',
                'specs' => ['cooler_type' => 'Air', 'cooler_height' => 165]
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertTrue($result['isValid']);
        $this->assertEmpty($result['errors']);
    }

    /** @test */
    public function it_can_detect_multiple_errors_at_once()
    {
        $components = [
            'cpu' => [
                'name' => 'Intel Core i9-14900K',
                'specs' => ['cpu_socket' => 'LGA1700', 'cpu_tdp' => 253]
            ],
            'mainboard' => [
                'name' => 'ASUS ROG Strix B650E-F',
                'specs' => ['mb_socket' => 'AM5', 'mb_memory_type' => 'DDR5'] // Wrong socket!
            ],
            'ram' => [
                'name' => 'Kingston Fury Beast DDR4',
                'specs' => ['ram_type' => 'DDR4'] // Wrong RAM type!
            ],
            'psu' => [
                'name' => 'Generic 400W',
                'specs' => ['psu_wattage' => 400] // Too weak!
            ],
        ];

        $result = $this->service->analyzeConfiguration($components);

        $this->assertFalse($result['isValid']);
        $this->assertGreaterThanOrEqual(2, count($result['errors']));
    }
}
