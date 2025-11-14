<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping product names to image URLs (using placeholder service)
        $productImages = [
            // CPU
            'Intel Core i9-14900K' => 'https://via.placeholder.com/500x500/1e40af/ffffff?text=Intel+i9-14900K',
            'Intel Core i9-14900KF' => 'https://via.placeholder.com/500x500/1e40af/ffffff?text=Intel+i9-14900KF',
            'Intel Core i7-14700K' => 'https://via.placeholder.com/500x500/1e40af/ffffff?text=Intel+i7-14700K',
            'Intel Core i7-14700KF' => 'https://via.placeholder.com/500x500/1e40af/ffffff?text=Intel+i7-14700KF',
            'Intel Core i5-14600K' => 'https://via.placeholder.com/500x500/1e40af/ffffff?text=Intel+i5-14600K',
            'Intel Core i5-13600K' => 'https://via.placeholder.com/500x500/1e40af/ffffff?text=Intel+i5-13600K',
            'AMD Ryzen 9 7950X' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=AMD+Ryzen+9+7950X',
            'AMD Ryzen 9 7900X' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=AMD+Ryzen+9+7900X',
            'AMD Ryzen 7 7800X3D' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=AMD+Ryzen+7+7800X3D',
            'AMD Ryzen 7 7700X' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=AMD+Ryzen+7+7700X',
            'AMD Ryzen 5 7600X' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=AMD+Ryzen+5+7600X',
            'AMD Ryzen 5 5600X' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=AMD+Ryzen+5+5600X',
            
            // GPU
            'ASUS ROG Strix RTX 4090 OC 24GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4090',
            'MSI GeForce RTX 4090 Gaming X Trio 24GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4090+MSI',
            'Gigabyte RTX 4080 Super Gaming OC 16GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4080+Super',
            'ASUS TUF RTX 4080 Super OC 16GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4080+TUF',
            'MSI RTX 4070 Ti Super Gaming X Trio 16GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4070+Ti',
            'Gigabyte RTX 4070 Super Gaming OC 12GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4070+Super',
            'ASUS Dual RTX 4060 Ti OC 8GB' => 'https://via.placeholder.com/500x500/76b900/ffffff?text=RTX+4060+Ti',
            'Sapphire RX 7900 XTX Nitro+ 24GB' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=RX+7900+XTX',
            'PowerColor RX 7900 XT Red Devil 20GB' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=RX+7900+XT',
            'XFX RX 7800 XT Speedster MERC 16GB' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=RX+7800+XT',
            'ASRock RX 7700 XT Phantom Gaming 12GB' => 'https://via.placeholder.com/500x500/ed1c24/ffffff?text=RX+7700+XT',
            
            // Mainboard
            'ASUS ROG Maximus Z790 Hero' => 'https://via.placeholder.com/500x500/000000/ffffff?text=Z790+Hero',
            'MSI MPG Z790 Carbon WiFi' => 'https://via.placeholder.com/500x500/000000/ffffff?text=Z790+Carbon',
            'Gigabyte Z790 Aorus Elite AX' => 'https://via.placeholder.com/500x500/ff6600/ffffff?text=Z790+Aorus',
            'ASRock Z790 Pro RS' => 'https://via.placeholder.com/500x500/000000/ffffff?text=Z790+Pro',
            'ASUS ROG Strix X670E-E Gaming WiFi' => 'https://via.placeholder.com/500x500/000000/ffffff?text=X670E',
            'MSI MAG X670E Tomahawk WiFi' => 'https://via.placeholder.com/500x500/000000/ffffff?text=X670E+MAG',
            'Gigabyte X670 Aorus Elite AX' => 'https://via.placeholder.com/500x500/ff6600/ffffff?text=X670+Elite',
            'ASRock B650E PG Riptide WiFi' => 'https://via.placeholder.com/500x500/000000/ffffff?text=B650E',
            
            // RAM
            'Corsair Dominator Platinum RGB DDR5 64GB' => 'https://via.placeholder.com/500x500/ffc400/000000?text=Dominator+64GB',
            'G.Skill Trident Z5 RGB DDR5 32GB 6400MHz' => 'https://via.placeholder.com/500x500/ff0000/ffffff?text=Trident+Z5',
            'Corsair Vengeance DDR5 32GB 6000MHz' => 'https://via.placeholder.com/500x500/ffc400/000000?text=Vengeance+32GB',
            'Kingston Fury Beast DDR5 32GB 5600MHz' => 'https://via.placeholder.com/500x500/000000/ff0000?text=Fury+Beast',
            'Crucial DDR5 32GB 4800MHz' => 'https://via.placeholder.com/500x500/cc0000/ffffff?text=Crucial+DDR5',
            'G.Skill Trident Z RGB DDR4 32GB 3600MHz' => 'https://via.placeholder.com/500x500/ff0000/ffffff?text=Trident+Z+RGB',
            'Corsair Vengeance LPX DDR4 16GB 3200MHz' => 'https://via.placeholder.com/500x500/ffc400/000000?text=Vengeance+LPX',
            'Kingston Fury Beast DDR4 16GB 3200MHz' => 'https://via.placeholder.com/500x500/000000/ff0000?text=Fury+16GB',
        ];

        foreach ($productImages as $productName => $imageUrl) {
            $product = Product::where('name', 'LIKE', "%{$productName}%")->first();
            
            if ($product) {
                // Update image field with URL
                $product->update(['image' => $imageUrl]);
                
                $this->command->info("Updated image for: {$productName}");
            }
        }

        // For products without specific images, use category-based placeholders
        $products = Product::whereNull('image')->orWhere('image', '')->get();
        
        foreach ($products as $product) {
            $categoryColors = [
                'CPU' => '1e40af',
                'GPU' => '76b900', 
                'Mainboard' => '000000',
                'RAM' => 'ffc400',
                'SSD' => '0066cc',
                'HDD' => '666666',
                'PSU' => 'ff6600',
                'Case' => '333333',
                'Cooling' => '00ccff',
                'Monitor' => '9333ea',
            ];
            
            $categoryName = $product->category->name ?? 'Product';
            $color = $categoryColors[$categoryName] ?? '3b82f6';
            $textColor = in_array($color, ['ffc400', '00ccff']) ? '000000' : 'ffffff';
            
            $imageUrl = "https://via.placeholder.com/500x500/{$color}/{$textColor}?text=" . urlencode($categoryName);
            
            $product->update(['image' => $imageUrl]);
            $this->command->info("Added placeholder for: {$product->name}");
        }
        
        $this->command->info('Product images seeded successfully!');
    }
}
