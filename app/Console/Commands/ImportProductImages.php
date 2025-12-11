<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportProductImages extends Command
{
    protected $signature = 'products:import-images {--clear : Clear existing images first}';
    protected $description = 'Import product images from public/images/products folders';

    public function handle()
    {
        $imagesPath = public_path('images/products');
        
        if (!File::isDirectory($imagesPath)) {
            $this->error("Directory not found: {$imagesPath}");
            return 1;
        }

        $folders = File::directories($imagesPath);
        $this->info("Found " . count($folders) . " product image folders");

        if ($this->option('clear')) {
            $this->warn("Clearing existing product images...");
            ProductImage::truncate();
        }

        $bar = $this->output->createProgressBar(count($folders));
        $bar->start();

        $imported = 0;
        $skipped = 0;
        $notFound = [];

        foreach ($folders as $folder) {
            $folderName = basename($folder);
            
            // Try to find matching product by SKU or slug pattern
            $product = $this->findProduct($folderName);
            
            if (!$product) {
                $notFound[] = $folderName;
                $bar->advance();
                continue;
            }

            // Get image files from folder
            $imageFiles = File::files($folder);
            $imageFiles = array_filter($imageFiles, function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
            });

            // Sort by filename
            usort($imageFiles, function ($a, $b) {
                return $a->getFilename() <=> $b->getFilename();
            });

            // Delete existing images for this product if not using --clear
            if (!$this->option('clear')) {
                ProductImage::where('product_id', $product->id)->delete();
            }

            // Import images
            $sortOrder = 0;
            foreach ($imageFiles as $file) {
                $relativePath = 'images/products/' . $folderName . '/' . $file->getFilename();
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $relativePath,
                    'is_primary' => $sortOrder === 0,
                    'sort_order' => $sortOrder,
                ]);
                
                $sortOrder++;
                $imported++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Imported {$imported} images");
        
        if (!empty($notFound)) {
            $this->warn("⚠️  Could not find products for " . count($notFound) . " folders:");
            foreach ($notFound as $folder) {
                $this->line("  - {$folder}");
            }
        }

        return 0;
    }

    private function findProduct(string $folderName): ?Product
    {
        // Remove common prefixes and convert to search terms
        // Example: cpu-intel-i5-14400f -> Intel Core i5 14400F
        
        $searchTerms = str_replace('-', ' ', $folderName);
        
        // Try exact slug match first
        $product = Product::where('slug', 'like', "%{$folderName}%")->first();
        if ($product) return $product;

        // Try SKU match
        $product = Product::where('sku', 'like', "%{$folderName}%")->first();
        if ($product) return $product;
        
        // Extract brand and model from folder name patterns
        $patterns = [
            // CPU: cpu-intel-i5-14400f -> i5-14400f
            '/^cpu-(?:intel|amd)-(.+)$/' => function ($m) {
                return Product::where('name', 'like', "%{$m[1]}%")->first();
            },
            // GPU: gpu-nvidia-rtx-4070-super -> RTX 4070 SUPER
            '/^gpu-(?:nvidia|amd)-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // RAM: ram-corsair-vengeance-ddr5-6000-32g
            '/^ram-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // SSD: ssd-samsung-990-pro-1tb
            '/^ssd-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // Mainboard: mb-asus-rog-strix-b650e-f
            '/^mb-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // Case: case-nzxt-h5-flow
            '/^case-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // PSU: psu-corsair-rm750x-shift
            '/^psu-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // Cooler: cooler-noctua-nh-d15
            '/^cooler-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
            // Monitor: monitor-lg-27gp850-b
            '/^monitor-(.+)$/' => function ($m) {
                $search = str_replace('-', ' ', $m[1]);
                return Product::where('name', 'like', "%{$search}%")->first();
            },
        ];

        foreach ($patterns as $pattern => $finder) {
            if (preg_match($pattern, $folderName, $matches)) {
                $product = $finder($matches);
                if ($product) return $product;
            }
        }

        // Last resort: search by name with keywords
        $keywords = explode('-', $folderName);
        foreach ($keywords as $keyword) {
            if (strlen($keyword) > 3) {
                $product = Product::where('name', 'like', "%{$keyword}%")->first();
                if ($product) return $product;
            }
        }

        return null;
    }
}
