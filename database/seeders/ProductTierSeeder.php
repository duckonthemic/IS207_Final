<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ComponentType;

/**
 * Seeder to populate tier values for products based on their component type and specs
 * This enables the PC Compatibility & Scoring System
 */
class ProductTierSeeder extends Seeder
{
    /**
     * CPU Tier mapping based on product name patterns
     */
    private const CPU_TIERS = [
        // Tier 4: Enthusiast
        4 => ['i9', 'Ryzen 9', 'Ryzen9'],
        // Tier 3: High-End
        3 => ['i7', 'Ryzen 7', 'Ryzen7'],
        // Tier 2: Mid-Range
        2 => ['i5', 'Ryzen 5', 'Ryzen5'],
        // Tier 1: Entry
        1 => ['i3', 'Ryzen 3', 'Ryzen3', 'Pentium', 'Athlon'],
    ];

    /**
     * Mainboard Tier mapping based on chipset
     */
    private const MAINBOARD_CHIPSET_TIERS = [
        // Tier 4: Enthusiast
        4 => ['X670E'],
        // Tier 3: High-End
        3 => ['Z790', 'Z690', 'H770', 'Z590', 'X670', 'X570', 'X470'],
        // Tier 2: Mid-Range
        2 => ['B760', 'B660', 'B560', 'B460', 'B650', 'B650E', 'B550', 'B450'],
        // Tier 1: Entry
        1 => ['H610', 'H510', 'H410', 'A520', 'A320', 'A620'],
    ];

    /**
     * GPU Tier mapping based on product name patterns
     */
    private const GPU_TIERS = [
        // Tier 4: Enthusiast
        4 => ['4090', '4080', '7900 XTX', '7900 XT'],
        // Tier 3: High-End
        3 => ['4070 Ti', '4070 Super', '4070', '3080', '3090', '7800 XT', '6800 XT'],
        // Tier 2: Mid-Range
        2 => ['4060 Ti', '4060', '3070', '3060 Ti', '7700 XT', '6700 XT', '6600 XT'],
        // Tier 1: Entry
        1 => ['3060', '3050', '1660', '1650', '6600', '6500', '6400'],
    ];

    public function run(): void
    {
        $this->command->info('Updating product tiers...');

        // Get component types
        $cpuType = ComponentType::where('code', 'cpu')->first();
        $mainboardType = ComponentType::where('code', 'mainboard')->first();
        $gpuType = ComponentType::where('code', 'vga')->first();

        // Update CPU tiers
        if ($cpuType) {
            $this->updateTiersByName(
                Product::where('component_type_id', $cpuType->id)->get(),
                self::CPU_TIERS,
                'CPU'
            );
        }

        // Update Mainboard tiers based on chipset spec
        if ($mainboardType) {
            $this->updateMainboardTiers($mainboardType->id);
        }

        // Update GPU tiers
        if ($gpuType) {
            $this->updateTiersByName(
                Product::where('component_type_id', $gpuType->id)->get(),
                self::GPU_TIERS,
                'GPU'
            );
        }

        $this->command->info('Product tiers updated successfully!');
    }

    /**
     * Update tiers based on product name patterns
     */
    private function updateTiersByName($products, array $tierMap, string $type): void
    {
        $updated = 0;
        foreach ($products as $product) {
            foreach ($tierMap as $tier => $patterns) {
                foreach ($patterns as $pattern) {
                    if (stripos($product->name, $pattern) !== false) {
                        $product->tier = $tier;
                        $product->save();
                        $updated++;
                        $this->command->line("  {$type}: {$product->name} -> Tier {$tier}");
                        break 2;
                    }
                }
            }
        }
        $this->command->info("  Updated {$updated} {$type} products");
    }

    /**
     * Update Mainboard tiers based on chipset from specs
     */
    private function updateMainboardTiers(int $componentTypeId): void
    {
        $products = Product::where('component_type_id', $componentTypeId)
            ->with('specs.specDefinition')
            ->get();

        $updated = 0;
        foreach ($products as $product) {
            // Try to get chipset from specs
            $chipset = null;
            foreach ($product->specs as $spec) {
                if ($spec->specDefinition && $spec->specDefinition->code === 'mb_chipset') {
                    $chipset = $spec->value;
                    break;
                }
            }

            // If no chipset in specs, try to infer from name
            if (!$chipset) {
                $chipset = $this->inferChipsetFromName($product->name);
            }

            if ($chipset) {
                foreach (self::MAINBOARD_CHIPSET_TIERS as $tier => $chipsets) {
                    foreach ($chipsets as $cs) {
                        if (stripos($chipset, $cs) !== false || stripos($product->name, $cs) !== false) {
                            $product->tier = $tier;
                            $product->save();
                            $updated++;
                            $this->command->line("  Mainboard: {$product->name} ({$chipset}) -> Tier {$tier}");
                            break 2;
                        }
                    }
                }
            }
        }
        $this->command->info("  Updated {$updated} Mainboard products");
    }

    /**
     * Try to infer chipset from product name
     */
    private function inferChipsetFromName(string $name): ?string
    {
        $allChipsets = array_merge(...array_values(self::MAINBOARD_CHIPSET_TIERS));
        foreach ($allChipsets as $chipset) {
            if (stripos($name, $chipset) !== false) {
                return $chipset;
            }
        }
        return null;
    }
}
