<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductLocalImageSeeder extends Seeder
{
    /**
     * Seed product images from local files in public/images/products
     */
    public function run(): void
    {
        $imagesPath = public_path('images/products');

        if (!File::isDirectory($imagesPath)) {
            $this->command->error('Images directory not found: ' . $imagesPath);
            return;
        }

        // Get all image files
        $imageFiles = collect(File::files($imagesPath))
            ->filter(fn($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            ->values();

        $this->command->info("Found {$imageFiles->count()} image files to process...");

        $matched = 0;
        $unmatched = [];

        foreach ($imageFiles as $file) {
            $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $extension = $file->getExtension();

            // Parse filename to extract product name and image number
            // Format: "Product Name.png" or "Product Name-1.png" for multiple images
            $parts = $this->parseFilename($filename);
            $productName = $parts['name'];
            $sortOrder = $parts['order'];

            // Try to find product by name (exact match or fuzzy match)
            $product = $this->findProduct($productName);

            if ($product) {
                // Check if this image already exists
                $imageUrl = "images/products/{$file->getFilename()}";

                $existingImage = ProductImage::where('product_id', $product->id)
                    ->where('url', $imageUrl)
                    ->first();

                if (!$existingImage) {
                    // Determine if this should be primary (first image for product)
                    $isPrimary = !ProductImage::where('product_id', $product->id)->exists();

                    ProductImage::create([
                        'product_id' => $product->id,
                        'url' => $imageUrl,
                        'is_primary' => $isPrimary,
                        'sort_order' => $sortOrder,
                    ]);

                    $this->command->info("✓ Matched: {$filename} → {$product->name}");
                    $matched++;
                } else {
                    $this->command->warn("⊘ Already exists: {$filename}");
                }
            } else {
                $unmatched[] = $filename;
            }
        }

        $this->command->newLine();
        $this->command->info("✅ Successfully matched {$matched} images to products.");

        if (!empty($unmatched)) {
            $this->command->warn("⚠ Could not match " . count($unmatched) . " images:");
            foreach ($unmatched as $name) {
                $this->command->line("  - {$name}");
            }
        }
    }

    /**
     * Parse filename to extract product name and order number
     * Examples: "Intel Core i5-14400F" -> ['name' => 'Intel Core i5-14400F', 'order' => 0]
     *           "Intel Core i5-14400F-2" -> ['name' => 'Intel Core i5-14400F', 'order' => 2]
     */
    private function parseFilename(string $filename): array
    {
        // Check for suffix pattern like "-1", "-2" at the end
        if (preg_match('/^(.+)-(\d+)$/', $filename, $matches)) {
            return [
                'name' => $matches[1],
                'order' => (int) $matches[2],
            ];
        }

        return [
            'name' => $filename,
            'order' => 0,
        ];
    }

    /**
     * Find product by name with multiple matching strategies
     */
    private function findProduct(string $name): ?Product
    {
        // Try exact match first
        $product = Product::where('name', $name)->first();
        if ($product) {
            return $product;
        }

        // Try case-insensitive match
        $product = Product::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
        if ($product) {
            return $product;
        }

        // Try LIKE match (handles minor differences)
        $product = Product::where('name', 'LIKE', "%{$name}%")->first();
        if ($product) {
            return $product;
        }

        // Try matching by removing special characters
        $cleanName = preg_replace('/[^\w\s]/', '', $name);
        $product = Product::whereRaw("REPLACE(REPLACE(name, '-', ''), ' ', '') LIKE ?", ["%{$cleanName}%"])->first();
        if ($product) {
            return $product;
        }

        // Try slug match
        $slug = Str::slug($name);
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            return $product;
        }

        return null;
    }
}
