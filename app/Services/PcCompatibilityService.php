<?php

namespace App\Services;

/**
 * PC Compatibility & Scoring System
 * 
 * 3 Layers:
 * 1. Physical Compatibility (Socket, RAM, Form Factor, GPU Length, Cooler Height)
 * 2. Performance/Bottleneck Check (CPU Tier vs Mainboard Tier)
 * 3. Power Consumption Check (TDP + PSU Connector validation)
 */
class PcCompatibilityService
{
    /**
     * Chipset to Tier mapping (VN Market 2024-2025)
     * Tier 1: Entry, Tier 2: Mid-Range, Tier 3: High-End, Tier 4: Enthusiast
     */
    private const CHIPSET_TIERS = [
        // Intel Entry
        'H610' => 1,
        'H510' => 1,
        'H410' => 1,
        // AMD Entry
        'A520' => 1,
        'A320' => 1,
        'A620' => 1,
        // Intel Mid-Range
        'B760' => 2,
        'B660' => 2,
        'B560' => 2,
        'B460' => 2,
        // AMD Mid-Range
        'B650' => 2,
        'B650E' => 2,
        'B550' => 2,
        'B450' => 2,
        // Intel High-End
        'Z790' => 3,
        'Z690' => 3,
        'H770' => 3,
        'Z590' => 3,
        // AMD High-End
        'X670' => 3,
        'X570' => 3,
        'X470' => 3,
        // Enthusiast
        'X670E' => 4,
    ];

    /**
     * Form factor compatibility matrix
     * Key: Case type, Value: Supported motherboard form factors
     */
    private const CASE_MB_COMPATIBILITY = [
        'Full Tower' => ['E-ATX', 'ATX', 'mATX', 'Mini-ITX'],
        'Mid Tower' => ['ATX', 'mATX', 'Mini-ITX'],
        'Mini Tower' => ['mATX', 'Mini-ITX'],
        'SFF' => ['Mini-ITX'],
    ];

    /**
     * Analyze full configuration - Main entry point
     * 
     * @param array $components Array of selected components with specs
     * @return array ['isValid' => bool, 'errors' => [], 'warnings' => [], 'info' => []]
     */
    public function analyzeConfiguration(array $components): array
    {
        $result = [
            'isValid' => true,
            'errors' => [],
            'warnings' => [],
            'info' => [],
        ];

        // Layer 1: Physical Compatibility (check first, blocking errors)
        $physicalCheck = $this->checkPhysicalCompatibility($components);
        $result['errors'] = array_merge($result['errors'], $physicalCheck['errors']);

        // Layer 2: Performance/Bottleneck
        $performanceCheck = $this->checkPerformanceCompatibility($components);
        $result['warnings'] = array_merge($result['warnings'], $performanceCheck['warnings']);
        $result['info'] = array_merge($result['info'], $performanceCheck['info']);

        // Layer 3: Power Consumption
        $powerCheck = $this->checkPowerCompatibility($components);
        $result['errors'] = array_merge($result['errors'], $powerCheck['errors']);
        $result['info'] = array_merge($result['info'], $powerCheck['info']);

        // Set isValid based on errors
        $result['isValid'] = empty($result['errors']);

        return $result;
    }

    /**
     * Layer 1: Physical Compatibility Check
     * Blocking errors - Cannot build if these fail
     */
    public function checkPhysicalCompatibility(array $components): array
    {
        $errors = [];

        $cpu = $components['cpu'] ?? null;
        $mainboard = $components['mainboard'] ?? null;
        $ram = $components['ram'] ?? null;
        $gpu = $components['gpu'] ?? null;
        $case = $components['case'] ?? null;
        $cooler = $components['cooler'] ?? null;

        // 1. CPU Socket vs Mainboard Socket
        if ($cpu && $mainboard) {
            $cpuSocket = $this->getSpec($cpu, 'cpu_socket');
            $mbSocket = $this->getSpec($mainboard, 'mb_socket');

            if ($cpuSocket && $mbSocket && $cpuSocket !== $mbSocket) {
                $errors[] = "CPU socket ({$cpuSocket}) không khớp với Mainboard socket ({$mbSocket})";
            }
        }

        // 2. RAM Type vs Mainboard (CHECK THIS BEFORE TIER!)
        if ($ram && $mainboard) {
            $ramType = $this->getSpec($ram, 'ram_type');
            $mbMemoryType = $this->getSpec($mainboard, 'mb_memory_type');

            if ($ramType && $mbMemoryType) {
                // Handle both string and array cases
                $supported = is_array($mbMemoryType) ? $mbMemoryType : [$mbMemoryType];
                if (!in_array($ramType, $supported) && $ramType !== $mbMemoryType) {
                    $errors[] = "RAM ({$ramType}) không tương thích với Mainboard (hỗ trợ {$mbMemoryType})";
                }
            }
        }

        // 3. Mainboard Form Factor vs Case
        if ($mainboard && $case) {
            $mbFormFactor = $this->getSpec($mainboard, 'mb_form_factor');
            $caseType = $this->getSpec($case, 'case_type');
            $caseMbSupport = $this->getSpec($case, 'case_motherboard_support');

            if ($mbFormFactor && $caseMbSupport) {
                $supported = is_array($caseMbSupport) ? $caseMbSupport : [$caseMbSupport];
                if (!in_array($mbFormFactor, $supported)) {
                    $errors[] = "Mainboard {$mbFormFactor} không lắp vừa Case (hỗ trợ: " . implode(', ', $supported) . ")";
                }
            } elseif ($mbFormFactor && $caseType) {
                // Fallback to case type mapping
                $defaultSupport = self::CASE_MB_COMPATIBILITY[$caseType] ?? [];
                if (!empty($defaultSupport) && !in_array($mbFormFactor, $defaultSupport)) {
                    $errors[] = "Mainboard {$mbFormFactor} không lắp vừa Case {$caseType}";
                }
            }
        }

        // 4. GPU Length vs Case
        if ($gpu && $case) {
            $gpuLength = (int) $this->getSpec($gpu, 'gpu_length_mm');
            $caseMaxGpu = (int) $this->getSpec($case, 'case_gpu_length');

            if ($gpuLength > 0 && $caseMaxGpu > 0 && $gpuLength > $caseMaxGpu) {
                $errors[] = "GPU dài {$gpuLength}mm, Case chỉ hỗ trợ tối đa {$caseMaxGpu}mm";
            }
        }

        // 5. Cooler Height vs Case (Air cooler)
        if ($cooler && $case) {
            $coolerType = $this->getSpec($cooler, 'cooler_type');

            if ($coolerType === 'Air') {
                $coolerHeight = (int) $this->getSpec($cooler, 'cooler_height');
                $caseMaxCooler = (int) $this->getSpec($case, 'case_cooler_height');

                if ($coolerHeight > 0 && $caseMaxCooler > 0 && $coolerHeight > $caseMaxCooler) {
                    $errors[] = "Tản nhiệt cao {$coolerHeight}mm, Case chỉ hỗ trợ tối đa {$caseMaxCooler}mm";
                }
            }

            // 6. AIO Radiator vs Case
            if ($coolerType === 'Liquid') {
                $radiatorSize = (int) $this->getSpec($cooler, 'cooler_radiator');
                $caseRadiatorSupport = $this->getSpec($case, 'case_radiator_support');

                if ($radiatorSize > 0 && $caseRadiatorSupport) {
                    // Parse case radiator support (e.g., "Front 360mm, Top 280mm")
                    preg_match_all('/(\d+)mm/', $caseRadiatorSupport, $matches);
                    $supportedSizes = array_map('intval', $matches[1] ?? []);
                    $maxSupported = !empty($supportedSizes) ? max($supportedSizes) : 0;

                    if ($maxSupported > 0 && $radiatorSize > $maxSupported) {
                        $errors[] = "Radiator {$radiatorSize}mm không hỗ trợ, Case chỉ lắp tối đa {$maxSupported}mm";
                    }
                }
            }
        }

        // 7. Cooler Socket Support vs CPU Socket
        if ($cooler && $cpu) {
            $cpuSocket = $this->getSpec($cpu, 'cpu_socket');
            $coolerSocketSupport = $this->getSpec($cooler, 'cooler_socket_support');

            if ($cpuSocket && $coolerSocketSupport) {
                $supported = is_array($coolerSocketSupport) ? $coolerSocketSupport : [$coolerSocketSupport];
                if (!in_array($cpuSocket, $supported)) {
                    $errors[] = "Tản nhiệt không hỗ trợ socket {$cpuSocket}";
                }
            }
        }

        return ['errors' => $errors];
    }

    /**
     * Layer 2: Performance/Bottleneck Check
     * Warnings - Can still build but not optimal
     */
    public function checkPerformanceCompatibility(array $components): array
    {
        $warnings = [];
        $info = [];

        $cpu = $components['cpu'] ?? null;
        $mainboard = $components['mainboard'] ?? null;

        if ($cpu && $mainboard) {
            // Get tiers - prefer database tier, fallback to calculated
            $cpuTier = $cpu['tier'] ?? $this->inferCpuTier($cpu);
            $mbTier = $mainboard['tier'] ?? $this->inferMainboardTier($mainboard);

            if ($cpuTier && $mbTier) {
                // CPU too powerful for Mainboard (bottleneck)
                if ($cpuTier > $mbTier) {
                    $warnings[] = "CPU cao cấp (Tier {$cpuTier}) ghép với Mainboard entry-level (Tier {$mbTier}) có thể gây nghẽn cổ chai do VRM yếu";
                }

                // Mainboard overkill for CPU
                if ($mbTier > $cpuTier + 1) {
                    $info[] = "Mainboard (Tier {$mbTier}) cao cấp hơn nhiều so với CPU (Tier {$cpuTier}) - có thể tối ưu chi phí";
                }
            }
        }

        return ['warnings' => $warnings, 'info' => $info];
    }

    /**
     * Layer 3: Power Consumption Check
     * Errors for insufficient power, Info for recommendations
     */
    public function checkPowerCompatibility(array $components): array
    {
        $errors = [];
        $info = [];

        $cpu = $components['cpu'] ?? null;
        $gpu = $components['gpu'] ?? null;
        $psu = $components['psu'] ?? null;

        if ($psu) {
            $psuWattage = (int) $this->getSpec($psu, 'psu_wattage');

            if ($psuWattage > 0) {
                // Calculate total TDP
                $totalTdp = $this->calculateTotalTdp($components);
                $requiredWattage = (int) ceil($totalTdp * 1.2); // 20% headroom
                $recommendedWattage = (int) ceil($totalTdp * 1.3); // 30% for comfort

                if ($psuWattage < $requiredWattage) {
                    $errors[] = "Nguồn {$psuWattage}W không đủ! Cần tối thiểu {$requiredWattage}W (TDP tổng: {$totalTdp}W + 20% headroom)";
                } elseif ($psuWattage < $recommendedWattage) {
                    $info[] = "Nguồn {$psuWattage}W đủ dùng nhưng gần giới hạn. Khuyến nghị {$recommendedWattage}W+";
                }

                // Check GPU power connectors
                if ($gpu) {
                    $gpuRecommendedPsu = (int) $this->getSpec($gpu, 'gpu_recommended_psu');
                    if ($gpuRecommendedPsu > 0 && $psuWattage < $gpuRecommendedPsu) {
                        $info[] = "GPU khuyến nghị nguồn {$gpuRecommendedPsu}W, bạn đang dùng {$psuWattage}W";
                    }

                    // Check PCIe connectors
                    $gpuPowerConnectors = $this->getSpec($gpu, 'gpu_power_connectors');
                    $psuPcie8pin = (int) $this->getSpec($psu, 'psu_pcie_8pin');
                    $psu12vhpwr = (int) $this->getSpec($psu, 'psu_12vhpwr');

                    if ($gpuPowerConnectors) {
                        // Parse GPU power requirements (e.g., "2x 8-pin PCIe" or "1x 16-pin 12VHPWR")
                        if (preg_match('/(\d+)x\s*8-pin/i', $gpuPowerConnectors, $matches)) {
                            $required8pin = (int) $matches[1];
                            if ($psuPcie8pin > 0 && $psuPcie8pin < $required8pin) {
                                $errors[] = "GPU cần {$required8pin}x cổng 8-pin PCIe, nguồn chỉ có {$psuPcie8pin}x";
                            }
                        }

                        if (preg_match('/12VHPWR|16-pin/i', $gpuPowerConnectors)) {
                            if ($psu12vhpwr < 1) {
                                $info[] = "GPU cần cổng 12VHPWR (16-pin), cần kiểm tra nguồn có adapter không";
                            }
                        }
                    }
                }
            }
        }

        return ['errors' => $errors, 'info' => $info];
    }

    /**
     * Calculate total TDP from all components
     */
    private function calculateTotalTdp(array $components): int
    {
        $total = 0;

        // CPU TDP
        if (isset($components['cpu'])) {
            $total += (int) $this->getSpec($components['cpu'], 'cpu_tdp');
        }

        // GPU TDP
        if (isset($components['gpu'])) {
            $total += (int) $this->getSpec($components['gpu'], 'gpu_tdp');
        }

        // Estimated other components (RAM, SSD, Fans, etc.)
        $total += 50;

        return $total;
    }

    /**
     * Infer CPU tier from product name (fallback)
     */
    private function inferCpuTier(array $cpu): ?int
    {
        $name = $cpu['name'] ?? '';

        if (preg_match('/i9|Ryzen\s*9/i', $name))
            return 4;
        if (preg_match('/i7|Ryzen\s*7/i', $name))
            return 3;
        if (preg_match('/i5|Ryzen\s*5/i', $name))
            return 2;
        if (preg_match('/i3|Ryzen\s*3|Pentium|Athlon/i', $name))
            return 1;

        return null;
    }

    /**
     * Infer Mainboard tier from chipset (fallback)
     */
    private function inferMainboardTier(array $mainboard): ?int
    {
        $chipset = $this->getSpec($mainboard, 'mb_chipset');

        if ($chipset) {
            foreach (self::CHIPSET_TIERS as $key => $tier) {
                if (stripos($chipset, $key) !== false) {
                    return $tier;
                }
            }
        }

        return null;
    }

    /**
     * Get spec value from component data
     */
    private function getSpec(array $component, string $specCode)
    {
        // Try specs array first
        if (isset($component['specs'][$specCode])) {
            return $component['specs'][$specCode];
        }

        // Try direct property
        if (isset($component[$specCode])) {
            return $component[$specCode];
        }

        return null;
    }
}
