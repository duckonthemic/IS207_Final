<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ExpandedProductSeeder extends Seeder
{
    public function run()
    {
        // Get categories
        $categories = Category::all()->keyBy('name');

        $products = [
            // ===== CPU (Intel) =====
            ['name' => 'Intel Core i9-14900K', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 589.99, 'stock' => 15, 'sku' => 'CPU-INTEL-I9-14900K'],
            ['name' => 'Intel Core i9-14900KF', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 529.99, 'stock' => 12, 'sku' => 'CPU-INTEL-I9-14900KF'],
            ['name' => 'Intel Core i9-14900', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 459.99, 'stock' => 10, 'sku' => 'CPU-INTEL-I9-14900'],
            ['name' => 'Intel Core i9-14900F', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 409.99, 'stock' => 8, 'sku' => 'CPU-INTEL-I9-14900F'],
            ['name' => 'Intel Core i7-14700K', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 419.99, 'stock' => 20, 'sku' => 'CPU-INTEL-I7-14700K'],
            ['name' => 'Intel Core i7-14700KF', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 369.99, 'stock' => 18, 'sku' => 'CPU-INTEL-I7-14700KF'],
            ['name' => 'Intel Core i7-14700', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 329.99, 'stock' => 15, 'sku' => 'CPU-INTEL-I7-14700'],
            ['name' => 'Intel Core i5-14600K', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 269.99, 'stock' => 25, 'sku' => 'CPU-INTEL-I5-14600K'],
            ['name' => 'Intel Core i5-14600KF', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 229.99, 'stock' => 22, 'sku' => 'CPU-INTEL-I5-14600KF'],
            ['name' => 'Intel Core i5-13600K', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 209.99, 'stock' => 20, 'sku' => 'CPU-INTEL-I5-13600K'],

            // ===== CPU (AMD) =====
            ['name' => 'AMD Ryzen 9 7950X', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 549.99, 'stock' => 12, 'sku' => 'CPU-AMD-R9-7950X'],
            ['name' => 'AMD Ryzen 9 7950X3D', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 649.99, 'stock' => 8, 'sku' => 'CPU-AMD-R9-7950X3D'],
            ['name' => 'AMD Ryzen 9 7900X', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 419.99, 'stock' => 14, 'sku' => 'CPU-AMD-R9-7900X'],
            ['name' => 'AMD Ryzen 9 7900X3D', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 499.99, 'stock' => 10, 'sku' => 'CPU-AMD-R9-7900X3D'],
            ['name' => 'AMD Ryzen 7 7800X3D', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 379.99, 'stock' => 16, 'sku' => 'CPU-AMD-R7-7800X3D'],
            ['name' => 'AMD Ryzen 7 7700X', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 289.99, 'stock' => 18, 'sku' => 'CPU-AMD-R7-7700X'],
            ['name' => 'AMD Ryzen 7 7700', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 249.99, 'stock' => 20, 'sku' => 'CPU-AMD-R7-7700'],
            ['name' => 'AMD Ryzen 5 7600X', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 199.99, 'stock' => 25, 'sku' => 'CPU-AMD-R5-7600X'],
            ['name' => 'AMD Ryzen 5 7600', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 159.99, 'stock' => 30, 'sku' => 'CPU-AMD-R5-7600'],
            ['name' => 'AMD Ryzen 5 5600X', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 139.99, 'stock' => 28, 'sku' => 'CPU-AMD-R5-5600X'],

            // ===== GPU (NVIDIA) =====
            ['name' => 'ASUS ROG Strix RTX 4090 OC 24GB', 'category' => 'GPU', 'brand' => 'ASUS', 'price' => 1999.99, 'stock' => 5, 'sku' => 'GPU-ASUS-RTX4090-24GB'],
            ['name' => 'Gigabyte RTX 4090 Master 24GB', 'category' => 'GPU', 'brand' => 'Gigabyte', 'price' => 1949.99, 'stock' => 6, 'sku' => 'GPU-GB-RTX4090-24GB'],
            ['name' => 'MSI RTX 4090 Gaming Trio 24GB', 'category' => 'GPU', 'brand' => 'MSI', 'price' => 1899.99, 'stock' => 7, 'sku' => 'GPU-MSI-RTX4090-24GB'],
            ['name' => 'EVGA RTX 4090 FTW3 Ultra 24GB', 'category' => 'GPU', 'brand' => 'EVGA', 'price' => 1879.99, 'stock' => 4, 'sku' => 'GPU-EVGA-RTX4090-24GB'],
            ['name' => 'Gigabyte RTX 4080 Super Gaming OC 16GB', 'category' => 'GPU', 'brand' => 'Gigabyte', 'price' => 1199.99, 'stock' => 10, 'sku' => 'GPU-GB-RTX4080S-16GB'],
            ['name' => 'ASUS TUF RTX 4080 Super OC 16GB', 'category' => 'GPU', 'brand' => 'ASUS', 'price' => 1249.99, 'stock' => 9, 'sku' => 'GPU-ASUS-RTX4080S-16GB'],
            ['name' => 'MSI RTX 4080 Super Gaming Trio 16GB', 'category' => 'GPU', 'brand' => 'MSI', 'price' => 1229.99, 'stock' => 8, 'sku' => 'GPU-MSI-RTX4080S-16GB'],
            ['name' => 'MSI RTX 4070 Ti Super Gaming Trio 12GB', 'category' => 'GPU', 'brand' => 'MSI', 'price' => 799.99, 'stock' => 15, 'sku' => 'GPU-MSI-RTX4070TS-12GB'],
            ['name' => 'ASUS ROG Strix RTX 4070 Ti Super OC 12GB', 'category' => 'GPU', 'brand' => 'ASUS', 'price' => 849.99, 'stock' => 12, 'sku' => 'GPU-ASUS-RTX4070TS-12GB'],
            ['name' => 'EVGA RTX 4070 Ti Super FTW3 Ultra 12GB', 'category' => 'GPU', 'brand' => 'EVGA', 'price' => 799.99, 'stock' => 14, 'sku' => 'GPU-EVGA-RTX4070TS-12GB'],
            ['name' => 'Gigabyte RTX 4070 Gaming OC 12GB', 'category' => 'GPU', 'brand' => 'Gigabyte', 'price' => 579.99, 'stock' => 20, 'sku' => 'GPU-GB-RTX4070-12GB'],
            ['name' => 'ASUS TUF RTX 4070 OC 12GB', 'category' => 'GPU', 'brand' => 'ASUS', 'price' => 599.99, 'stock' => 18, 'sku' => 'GPU-ASUS-RTX4070-12GB'],
            ['name' => 'MSI RTX 4070 Ventus 2X OC 12GB', 'category' => 'GPU', 'brand' => 'MSI', 'price' => 569.99, 'stock' => 22, 'sku' => 'GPU-MSI-RTX4070-12GB'],
            ['name' => 'EVGA RTX 4060 Ti 8GB FTW3', 'category' => 'GPU', 'brand' => 'EVGA', 'price' => 299.99, 'stock' => 30, 'sku' => 'GPU-EVGA-RTX4060TI-8GB'],
            ['name' => 'ASUS Phoenix RTX 4060 Ti 8GB', 'category' => 'GPU', 'brand' => 'ASUS', 'price' => 319.99, 'stock' => 28, 'sku' => 'GPU-ASUS-RTX4060TI-8GB'],

            // ===== GPU (AMD) =====
            ['name' => 'AMD Radeon RX 7900 XT 20GB', 'category' => 'GPU', 'brand' => 'AMD', 'price' => 799.99, 'stock' => 12, 'sku' => 'GPU-AMD-RX7900XT-20GB'],
            ['name' => 'AMD Radeon RX 7900 GRE 20GB', 'category' => 'GPU', 'brand' => 'AMD', 'price' => 849.99, 'stock' => 10, 'sku' => 'GPU-AMD-RX7900GRE-20GB'],
            ['name' => 'AMD Radeon RX 7800 XT 16GB', 'category' => 'GPU', 'brand' => 'AMD', 'price' => 499.99, 'stock' => 18, 'sku' => 'GPU-AMD-RX7800XT-16GB'],
            ['name' => 'AMD Radeon RX 7700 XT 12GB', 'category' => 'GPU', 'brand' => 'AMD', 'price' => 349.99, 'stock' => 25, 'sku' => 'GPU-AMD-RX7700XT-12GB'],
            ['name' => 'AMD Radeon RX 7600 16GB', 'category' => 'GPU', 'brand' => 'AMD', 'price' => 249.99, 'stock' => 30, 'sku' => 'GPU-AMD-RX7600-16GB'],

            // ===== Mainboard (Intel) =====
            ['name' => 'ASUS ROG Strix Z790-E Gaming WiFi', 'category' => 'Mainboard', 'brand' => 'ASUS', 'price' => 389.99, 'stock' => 8, 'sku' => 'MB-ASUS-Z790E'],
            ['name' => 'MSI MPG Z790 Edge WiFi', 'category' => 'Mainboard', 'brand' => 'MSI', 'price' => 349.99, 'stock' => 10, 'sku' => 'MB-MSI-Z790EDGE'],
            ['name' => 'Gigabyte Z790 Master', 'category' => 'Mainboard', 'brand' => 'Gigabyte', 'price' => 329.99, 'stock' => 12, 'sku' => 'MB-GB-Z790MASTER'],
            ['name' => 'ASRock Z790 Steel Legend', 'category' => 'Mainboard', 'brand' => 'ASRock', 'price' => 299.99, 'stock' => 14, 'sku' => 'MB-ASR-Z790SL'],
            ['name' => 'ASUS TUF Z790-Plus WiFi', 'category' => 'Mainboard', 'brand' => 'ASUS', 'price' => 279.99, 'stock' => 16, 'sku' => 'MB-ASUS-Z790PLUS'],
            ['name' => 'MSI MPG Z790 Gaming Edge WiFi', 'category' => 'Mainboard', 'brand' => 'MSI', 'price' => 319.99, 'stock' => 13, 'sku' => 'MB-MSI-Z790GE'],

            // ===== Mainboard (AMD) =====
            ['name' => 'ASUS ROG Strix X870-E-E Gaming WiFi', 'category' => 'Mainboard', 'brand' => 'ASUS', 'price' => 449.99, 'stock' => 6, 'sku' => 'MB-ASUS-X870E'],
            ['name' => 'MSI MPG X870E Edge WiFi', 'category' => 'Mainboard', 'brand' => 'MSI', 'price' => 429.99, 'stock' => 7, 'sku' => 'MB-MSI-X870E'],
            ['name' => 'Gigabyte X870E-E Master', 'category' => 'Mainboard', 'brand' => 'Gigabyte', 'price' => 399.99, 'stock' => 9, 'sku' => 'MB-GB-X870E'],
            ['name' => 'ASRock X870E Steel Legend', 'category' => 'Mainboard', 'brand' => 'ASRock', 'price' => 369.99, 'stock' => 11, 'sku' => 'MB-ASR-X870E'],

            // ===== RAM (DDR5) =====
            ['name' => 'Corsair Vengeance RGB Pro 64GB (32x2) DDR5 6000MHz', 'category' => 'RAM', 'brand' => 'Corsair', 'price' => 319.99, 'stock' => 12, 'sku' => 'RAM-CORSAIR-DDR5-64GB'],
            ['name' => 'G.SKILL Trident Z5 RGB 64GB (32x2) DDR5 6000MHz', 'category' => 'RAM', 'brand' => 'G.SKILL', 'price' => 299.99, 'stock' => 14, 'sku' => 'RAM-GSKILL-DDR5-64GB'],
            ['name' => 'Kingston Fury Beast DDR5 64GB (32x2) 6000MHz', 'category' => 'RAM', 'brand' => 'Kingston', 'price' => 289.99, 'stock' => 16, 'sku' => 'RAM-KINGSTON-DDR5-64GB'],
            ['name' => 'ADATA XPG Lian Xu DDR5 64GB (32x2) 6000MHz', 'category' => 'RAM', 'brand' => 'ADATA', 'price' => 279.99, 'stock' => 18, 'sku' => 'RAM-ADATA-DDR5-64GB'],
            ['name' => 'Corsair Vengeance RGB Pro 32GB (16x2) DDR5 5600MHz', 'category' => 'RAM', 'brand' => 'Corsair', 'price' => 179.99, 'stock' => 20, 'sku' => 'RAM-CORSAIR-DDR5-32GB'],
            ['name' => 'G.SKILL Trident Z5 RGB 32GB (16x2) DDR5 5600MHz', 'category' => 'RAM', 'brand' => 'G.SKILL', 'price' => 169.99, 'stock' => 22, 'sku' => 'RAM-GSKILL-DDR5-32GB'],
            ['name' => 'Crucial Pro 48GB (24x2) DDR5 5600MHz', 'category' => 'RAM', 'brand' => 'Crucial', 'price' => 249.99, 'stock' => 15, 'sku' => 'RAM-CRUCIAL-DDR5-48GB'],
            ['name' => 'Kingston Fury Beast 32GB (16x2) DDR5 5600MHz', 'category' => 'RAM', 'brand' => 'Kingston', 'price' => 159.99, 'stock' => 25, 'sku' => 'RAM-KINGSTON-DDR5-32GB'],

            // ===== SSD (NVMe PCIe 4.0) =====
            ['name' => 'Samsung 990 Pro 4TB PCIe 4.0 NVMe', 'category' => 'SSD', 'brand' => 'Samsung', 'price' => 349.99, 'stock' => 10, 'sku' => 'SSD-SAMSUNG-990PRO-4TB'],
            ['name' => 'WD Black SN850X 4TB', 'category' => 'SSD', 'brand' => 'Western Digital', 'price' => 299.99, 'stock' => 12, 'sku' => 'SSD-WD-SN850X-4TB'],
            ['name' => 'Crucial P5 Plus 4TB', 'category' => 'SSD', 'brand' => 'Crucial', 'price' => 279.99, 'stock' => 14, 'sku' => 'SSD-CRUCIAL-P5PLUS-4TB'],
            ['name' => 'Kingston KC3000 4TB', 'category' => 'SSD', 'brand' => 'Kingston', 'price' => 269.99, 'stock' => 16, 'sku' => 'SSD-KINGSTON-KC3000-4TB'],
            ['name' => 'Samsung 990 Pro 2TB PCIe 4.0 NVMe', 'category' => 'SSD', 'brand' => 'Samsung', 'price' => 189.99, 'stock' => 20, 'sku' => 'SSD-SAMSUNG-990PRO-2TB'],
            ['name' => 'WD Black SN850X 2TB', 'category' => 'SSD', 'brand' => 'Western Digital', 'price' => 169.99, 'stock' => 22, 'sku' => 'SSD-WD-SN850X-2TB'],
            ['name' => 'ADATA XPG S70 Blade 4TB', 'category' => 'SSD', 'brand' => 'ADATA', 'price' => 329.99, 'stock' => 11, 'sku' => 'SSD-ADATA-S70BLADE-4TB'],
            ['name' => 'Corsair MP600 Core XT 4TB', 'category' => 'SSD', 'brand' => 'Corsair', 'price' => 289.99, 'stock' => 13, 'sku' => 'SSD-CORSAIR-MP600-4TB'],

            // ===== Storage (HDD) =====
            ['name' => 'WD Red Pro 12TB 256MB 7200RPM', 'category' => 'HDD', 'brand' => 'Western Digital', 'price' => 249.99, 'stock' => 8, 'sku' => 'HDD-WD-RED-12TB'],
            ['name' => 'Seagate Barracuda Pro 12TB', 'category' => 'HDD', 'brand' => 'Seagate', 'price' => 229.99, 'stock' => 10, 'sku' => 'HDD-SEAGATE-PRO-12TB'],
            ['name' => 'WD Red Pro 10TB 256MB', 'category' => 'HDD', 'brand' => 'Western Digital', 'price' => 199.99, 'stock' => 12, 'sku' => 'HDD-WD-RED-10TB'],
            ['name' => 'Seagate IronWolf 8TB 7200RPM', 'category' => 'HDD', 'brand' => 'Seagate', 'price' => 129.99, 'stock' => 15, 'sku' => 'HDD-SEAGATE-IRONWOLF-8TB'],

            // ===== PSU =====
            ['name' => 'Corsair RM1000x 1000W 80+ Gold', 'category' => 'PSU', 'brand' => 'Corsair', 'price' => 219.99, 'stock' => 10, 'sku' => 'PSU-CORSAIR-RM1000X'],
            ['name' => 'EVGA SuperNOVA 850 GA 850W 80+ Gold', 'category' => 'PSU', 'brand' => 'EVGA', 'price' => 159.99, 'stock' => 12, 'sku' => 'PSU-EVGA-SN850GA'],
            ['name' => 'Seasonic Focus GX 1050W 80+ Gold', 'category' => 'PSU', 'brand' => 'Seasonic', 'price' => 249.99, 'stock' => 8, 'sku' => 'PSU-SEASONIC-GX1050'],
            ['name' => 'Corsair HXi 1200W 80+ Platinum', 'category' => 'PSU', 'brand' => 'Corsair', 'price' => 299.99, 'stock' => 6, 'sku' => 'PSU-CORSAIR-HXI1200'],
            ['name' => 'EVGA SuperNOVA 1000 P2 1000W 80+ Platinum', 'category' => 'PSU', 'brand' => 'EVGA', 'price' => 189.99, 'stock' => 9, 'sku' => 'PSU-EVGA-SN1000P2'],
            ['name' => 'Gigabyte UD1000GM 1000W 80+ Gold', 'category' => 'PSU', 'brand' => 'Gigabyte', 'price' => 179.99, 'stock' => 11, 'sku' => 'PSU-GIGABYTE-UD1000'],

            // ===== Case =====
            ['name' => 'NZXT H7 Flow RGB', 'category' => 'Case', 'brand' => 'NZXT', 'price' => 139.99, 'stock' => 12, 'sku' => 'CASE-NZXT-H7FLOW'],
            ['name' => 'Corsair 5000T RGB', 'category' => 'Case', 'brand' => 'Corsair', 'price' => 289.99, 'stock' => 8, 'sku' => 'CASE-CORSAIR-5000T'],
            ['name' => 'Lian Li LANCOOL 303', 'category' => 'Case', 'brand' => 'Lian Li', 'price' => 79.99, 'stock' => 20, 'sku' => 'CASE-LIANLI-303'],
            ['name' => 'Phanteks Eclipse P500A D-RGB', 'category' => 'Case', 'brand' => 'Phanteks', 'price' => 149.99, 'stock' => 15, 'sku' => 'CASE-PHANTEKS-P500A'],
            ['name' => 'Fractal Design Meshify 2', 'category' => 'Case', 'brand' => 'Fractal Design', 'price' => 159.99, 'stock' => 14, 'sku' => 'CASE-FRACTAL-MESHIFY2'],
            ['name' => 'be quiet! Pure Base 500DX', 'category' => 'Case', 'brand' => 'be quiet!', 'price' => 119.99, 'stock' => 18, 'sku' => 'CASE-BEQUIET-PB500DX'],

            // ===== Cooling =====
            ['name' => 'Noctua NH-D15 Chromax Black', 'category' => 'Cooling', 'brand' => 'Noctua', 'price' => 99.99, 'stock' => 14, 'sku' => 'COOL-NOCTUA-D15'],
            ['name' => 'NZXT Kraken X73 360mm AIO', 'category' => 'Cooling', 'brand' => 'NZXT', 'price' => 199.99, 'stock' => 10, 'sku' => 'COOL-NZXT-X73'],
            ['name' => 'Corsair H150i Elite Capellix 360mm', 'category' => 'Cooling', 'brand' => 'Corsair', 'price' => 169.99, 'stock' => 12, 'sku' => 'COOL-CORSAIR-H150I'],
            ['name' => 'be quiet! Dark Rock Pro TR4', 'category' => 'Cooling', 'brand' => 'be quiet!', 'price' => 89.99, 'stock' => 16, 'sku' => 'COOL-BEQUIET-DARK'],
            ['name' => 'Scythe Ninja 5', 'category' => 'Cooling', 'brand' => 'Scythe', 'price' => 69.99, 'stock' => 20, 'sku' => 'COOL-SCYTHE-NINJA5'],
            ['name' => 'Thermalright Peerless Assassin 120 SE', 'category' => 'Cooling', 'brand' => 'Thermalright', 'price' => 34.99, 'stock' => 25, 'sku' => 'COOL-THERMALRIGHT-PA120'],

            // ===== Monitor =====
            ['name' => 'Dell S3423DWF 34" Ultrawide 3440x1440 100Hz', 'category' => 'Monitor', 'brand' => 'Dell', 'price' => 599.99, 'stock' => 6, 'sku' => 'MON-DELL-S3423DWF'],
            ['name' => 'LG 27GP850-B 27" 1440p 180Hz', 'category' => 'Monitor', 'brand' => 'LG', 'price' => 449.99, 'stock' => 8, 'sku' => 'MON-LG-27GP850'],
            ['name' => 'ASUS ProArt PA278QV 27" 2560x1440 100Hz', 'category' => 'Monitor', 'brand' => 'ASUS', 'price' => 599.99, 'stock' => 5, 'sku' => 'MON-ASUS-PA278QV'],
            ['name' => 'MSI Oculux NXG253R 25" 1080p 360Hz', 'category' => 'Monitor', 'brand' => 'MSI', 'price' => 699.99, 'stock' => 7, 'sku' => 'MON-MSI-NXG253R'],
            ['name' => 'BenQ PD2705U 27" 4K 60Hz', 'category' => 'Monitor', 'brand' => 'BenQ', 'price' => 899.99, 'stock' => 4, 'sku' => 'MON-BENQ-PD2705U'],
            ['name' => 'Gigabyte M28U 28" 4K 144Hz', 'category' => 'Monitor', 'brand' => 'Gigabyte', 'price' => 799.99, 'stock' => 6, 'sku' => 'MON-GIGABYTE-M28U'],
        ];

        foreach ($products as $productData) {
            $category = $categories->get($productData['category']);
            if (!$category) {
                continue;
            }

            // Generate placeholder image based on product type and brand
            $imageUrl = $this->generateImageUrl($productData);

            Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => \Illuminate\Support\Str::slug($productData['name']),
                'brand' => $productData['brand'],
                'price' => $productData['price'],
                'sale_price' => $productData['price'] * 0.85,
                'stock' => $productData['stock'],
                'sku' => $productData['sku'],
                'description' => $this->generateDescription($productData),
                'image' => $imageUrl,
            ]);
        }
    }

    private function generateImageUrl($product)
    {
        $category = strtolower($product['category']);
        
        // Map categories to loremflickr keywords for realistic images
        $keywords = [
            'cpu' => 'processor,computer,chip',
            'gpu' => 'graphics,card,nvidia,gpu',
            'mainboard' => 'motherboard,computer,circuit',
            'ram' => 'memory,computer,hardware',
            'ssd' => 'storage,disk,ssd',
            'hdd' => 'harddrive,disk,storage',
            'psu' => 'power,supply,electronics',
            'case' => 'computer,case,tower',
            'cooling' => 'cooler,fan,cooling',
            'monitor' => 'monitor,screen,display',
        ];
        
        $keyword = $keywords[$category] ?? 'computer,electronics';
        $seed = crc32($product['name']) % 1000;
        
        // Use loremflickr for more realistic product-like images
        return "https://loremflickr.com/500/500/{$keyword}?random={$seed}";
    }

    private function generateDescription($product)
    {
        $descriptions = [
            'CPU' => 'High-performance processor with excellent multithreading capabilities. Perfect for gaming, content creation, and professional workloads.',
            'GPU' => 'Powerful graphics card with excellent VRAM capacity. Ideal for gaming, 3D rendering, and machine learning applications.',
            'Mainboard' => 'Feature-rich motherboard with excellent power delivery and connectivity options. Supports latest processors and high-speed memory.',
            'RAM' => 'High-speed memory modules with RGB lighting. Excellent for gaming and productivity workloads.',
            'SSD' => 'Ultra-fast NVMe SSD with excellent sequential read/write speeds. Perfect for OS installation and gaming.',
            'HDD' => 'Reliable storage drive with large capacity. Ideal for backup and long-term data storage.',
            'PSU' => 'High-efficiency power supply with excellent stability and protection features.',
            'Case' => 'Well-designed PC case with excellent airflow and cable management.',
            'Cooling' => 'Effective cooling solution with excellent thermal performance.',
            'Monitor' => 'High-quality display with vibrant colors and excellent refresh rate.',
        ];

        return $descriptions[$product['category']] ?? 'Quality computer component for PC building.';
    }
}
