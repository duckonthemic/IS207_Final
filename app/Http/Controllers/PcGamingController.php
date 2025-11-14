<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PcGamingController extends Controller
{
    /**
     * Display PC Gaming listing page
     */
    public function index(Request $request)
    {
        // PC Gaming builds - pre-configured systems
        $builds = [
            [
                'id' => 'glacier-i5050',
                'name' => 'PC Gaming - Glacier i5050 - BL',
                'cpu' => 'Intel Core i5-13400F',
                'gpu' => 'NVIDIA RTX 5050',
                'ram' => '16GB DDR5',
                'storage' => '256GB SSD',
                'price' => 17990000,
                'sale_price' => 16490000,
                'image' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=500',
                'rating' => 4.7,
                'reviews' => 7,
            ],
            [
                'id' => 'glacier-i3050',
                'name' => 'PC Gaming - Glacier i3050',
                'cpu' => 'Intel Core i3-13100F',
                'gpu' => 'NVIDIA RTX 3050',
                'ram' => '16GB DDR4',
                'storage' => '256GB SSD',
                'price' => 16490000,
                'sale_price' => 14290000,
                'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=500',
                'rating' => 4.5,
                'reviews' => 15,
            ],
            [
                'id' => 'glacier-i3060',
                'name' => 'PC Gaming - Glacier i3060 - BL',
                'cpu' => 'Intel Core i5-13400F',
                'gpu' => 'NVIDIA RTX 3060',
                'ram' => '16GB DDR5',
                'storage' => '256GB SSD',
                'price' => 18990000,
                'sale_price' => 18290000,
                'image' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=500',
                'rating' => 4.9,
                'reviews' => 9,
            ],
            [
                'id' => 'supernova-i5080',
                'name' => 'PC Gaming - Supernova i5080 - WH',
                'cpu' => 'Intel Core i7-14700KF',
                'gpu' => 'NVIDIA RTX 5080',
                'ram' => '32GB DDR5',
                'storage' => '1TB NVMe',
                'price' => 70240000,
                'sale_price' => 76990000,
                'image' => 'https://images.unsplash.com/photo-1600861194942-f883de0dfe96?w=500',
                'rating' => 5.0,
                'reviews' => 0,
            ],
            [
                'id' => 'sniper-i5070ti',
                'name' => 'PC Gaming - Sniper i5070Ti',
                'cpu' => 'Intel Core i7-14700K',
                'gpu' => 'NVIDIA RTX 5070Ti',
                'ram' => '32GB DDR5',
                'storage' => '1TB NVMe',
                'price' => 52040000,
                'sale_price' => 50990000,
                'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500',
                'rating' => 5.0,
                'reviews' => 6,
            ],
            [
                'id' => 'supernova-a5090',
                'name' => 'PC Gaming - Supernova A5090',
                'cpu' => 'AMD Ryzen 9 9900X3D',
                'gpu' => 'NVIDIA RTX 5090',
                'ram' => '32GB DDR5',
                'storage' => '1TB NVMe',
                'price' => 97770000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1625945803699-26ebdb45cd1d?w=500',
                'rating' => 5.0,
                'reviews' => 0,
            ],
            [
                'id' => 'supernova-i507',
                'name' => 'PC Gaming - Supernova i507O',
                'cpu' => 'Intel Core i5-14600K',
                'gpu' => 'NVIDIA RTX 5070',
                'ram' => '32GB DDR5',
                'storage' => '500GB NVMe',
                'price' => 37770000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1623580065276-ad2929ed58d7?w=500',
                'rating' => 5.0,
                'reviews' => 3,
            ],
            [
                'id' => 'sniper-a9060xt',
                'name' => 'PC Gaming - Sniper A9060XT',
                'cpu' => 'AMD Ryzen 7 9800X3D',
                'gpu' => 'AMD RX 9060XT',
                'ram' => '32GB DDR5',
                'storage' => '500GB NVMe',
                'price' => 38790000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1612287230202-1ff1d85d1bdf?w=500',
                'rating' => 5.0,
                'reviews' => 11,
            ],
            [
                'id' => 'sentinel-a5080',
                'name' => 'PC Gaming - Sentinel A5080',
                'cpu' => 'AMD Ryzen 7 9800X3D',
                'gpu' => 'NVIDIA RTX 5080',
                'ram' => '32GB DDR5',
                'storage' => '1TB NVMe',
                'price' => 82640000,
                'sale_price' => null,
                'image' => 'https://images.unsplash.com/photo-1587202372583-49330a15584d?w=500',
                'rating' => 5.0,
                'reviews' => 0,
            ],
            [
                'id' => 'sniper-i5060',
                'name' => 'PC Gaming - Sniper i5060 - BL - 01',
                'cpu' => 'Intel Core i5-14400F',
                'gpu' => 'NVIDIA RTX 5060',
                'ram' => '16GB DDR5',
                'storage' => '256GB NVMe',
                'price' => 18990000,
                'sale_price' => 17490000,
                'image' => 'https://images.unsplash.com/photo-1616763355548-1b606f439f86?w=500',
                'rating' => 5.0,
                'reviews' => 4,
            ],
        ];

        // Filter by price range
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        
        if ($minPrice || $maxPrice) {
            $builds = array_filter($builds, function($build) use ($minPrice, $maxPrice) {
                $price = $build['sale_price'] ?? $build['price'];
                if ($minPrice && $price < $minPrice) return false;
                if ($maxPrice && $price > $maxPrice) return false;
                return true;
            });
        }

        // Sort
        $sort = $request->input('sort', 'latest');
        if ($sort === 'price_asc') {
            usort($builds, fn($a, $b) => ($a['sale_price'] ?? $a['price']) <=> ($b['sale_price'] ?? $b['price']));
        } elseif ($sort === 'price_desc') {
            usort($builds, fn($a, $b) => ($b['sale_price'] ?? $b['price']) <=> ($a['sale_price'] ?? $a['price']));
        }

        return view('pc-gaming.index', compact('builds'));
    }

    /**
     * Display build PC configurator
     */
    public function buildPc()
    {
        $categories = Category::whereIn('name', [
            'CPU - Processor',
            'VGA - Card màn hình', 
            'RAM - Bộ nhớ',
            'SSD - Ổ cứng',
            'Mainboard - Mainboard',
            'PSU - Nguồn',
            'Case - Vỏ máy',
            'Fan & Cooler - Quạt tản nhiệt'
        ])->get();

        $products = [];
        foreach ($categories as $category) {
            $products[$category->slug] = Product::where('category_id', $category->id)
                ->where('is_active', true)
                ->orderBy('price')
                ->get();
        }

        return view('pc-gaming.build', compact('categories', 'products'));
    }

    /**
     * Display PC AI listing page
     */
    public function pcAI(Request $request)
    {
        $builds = [
            [
                'id' => 'ai-workstation-pro',
                'name' => 'PC AI Workstation Pro',
                'cpu' => 'AMD Ryzen 9 7950X',
                'gpu' => 'NVIDIA RTX 5090 24GB',
                'ram' => '128GB DDR5',
                'storage' => '2TB NVMe SSD',
                'price' => 97990000,
                'sale_price' => 95990000,
                'image' => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?w=500',
                'rating' => 5.0,
                'reviews' => 12,
            ],
            [
                'id' => 'ai-studio',
                'name' => 'PC AI Studio',
                'cpu' => 'Intel Core i9-14900K',
                'gpu' => 'NVIDIA RTX 5080 16GB',
                'ram' => '64GB DDR5',
                'storage' => '1TB NVMe SSD',
                'price' => 68990000,
                'sale_price' => 66990000,
                'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500',
                'rating' => 4.8,
                'reviews' => 8,
            ],
            [
                'id' => 'ai-dev',
                'name' => 'PC AI Development',
                'cpu' => 'AMD Ryzen 9 7900X',
                'gpu' => 'NVIDIA RTX 5070 Ti 16GB',
                'ram' => '64GB DDR5',
                'storage' => '1TB NVMe SSD',
                'price' => 54990000,
                'sale_price' => 52990000,
                'image' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=500',
                'rating' => 4.7,
                'reviews' => 10,
            ],
        ];

        return view('pc-gaming.index', [
            'builds' => $builds,
            'pageTitle' => 'PC AI Workstation',
            'pageDescription' => 'Hệ thống PC tối ưu cho Machine Learning, Deep Learning và xử lý AI'
        ]);
    }

    /**
     * Display PC Office listing page
     */
    public function pcOffice(Request $request)
    {
        $builds = [
            [
                'id' => 'office-premium',
                'name' => 'PC Office Premium',
                'cpu' => 'Intel Core i7-14700',
                'gpu' => 'Intel UHD Graphics 770',
                'ram' => '32GB DDR5',
                'storage' => '512GB NVMe SSD',
                'price' => 22990000,
                'sale_price' => 21490000,
                'image' => 'https://images.unsplash.com/photo-1555617981-dac3880eac6e?w=500',
                'rating' => 4.6,
                'reviews' => 25,
            ],
            [
                'id' => 'office-standard',
                'name' => 'PC Office Standard',
                'cpu' => 'Intel Core i5-14400',
                'gpu' => 'Intel UHD Graphics 730',
                'ram' => '16GB DDR5',
                'storage' => '512GB NVMe SSD',
                'price' => 16990000,
                'sale_price' => 15490000,
                'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=500',
                'rating' => 4.5,
                'reviews' => 42,
            ],
            [
                'id' => 'office-basic',
                'name' => 'PC Office Basic',
                'cpu' => 'Intel Core i3-14100',
                'gpu' => 'Intel UHD Graphics 730',
                'ram' => '8GB DDR4',
                'storage' => '256GB SSD',
                'price' => 10990000,
                'sale_price' => 9990000,
                'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500',
                'rating' => 4.3,
                'reviews' => 58,
            ],
        ];

        return view('pc-gaming.index', [
            'builds' => $builds,
            'pageTitle' => 'PC Office',
            'pageDescription' => 'Hệ thống PC cho văn phòng, làm việc hiệu quả'
        ]);
    }

    /**
     * Display PC Design listing page
     */
    public function pcDesign(Request $request)
    {
        $builds = [
            [
                'id' => 'design-ultra',
                'name' => 'PC Design Ultra',
                'cpu' => 'AMD Ryzen 9 7950X3D',
                'gpu' => 'NVIDIA RTX 5080 16GB',
                'ram' => '64GB DDR5',
                'storage' => '2TB NVMe SSD',
                'price' => 72990000,
                'sale_price' => 69990000,
                'image' => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?w=500',
                'rating' => 4.9,
                'reviews' => 18,
            ],
            [
                'id' => 'design-pro',
                'name' => 'PC Design Pro',
                'cpu' => 'Intel Core i9-14900K',
                'gpu' => 'NVIDIA RTX 5070 Ti 16GB',
                'ram' => '32GB DDR5',
                'storage' => '1TB NVMe SSD',
                'price' => 54990000,
                'sale_price' => 52990000,
                'image' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=500',
                'rating' => 4.7,
                'reviews' => 24,
            ],
            [
                'id' => 'design-starter',
                'name' => 'PC Design Starter',
                'cpu' => 'AMD Ryzen 7 7700X',
                'gpu' => 'NVIDIA RTX 5070 12GB',
                'ram' => '32GB DDR5',
                'storage' => '1TB NVMe SSD',
                'price' => 42990000,
                'sale_price' => 40990000,
                'image' => 'https://images.unsplash.com/photo-1555617981-dac3880eac6e?w=500',
                'rating' => 4.6,
                'reviews' => 31,
            ],
        ];

        return view('pc-gaming.index', [
            'builds' => $builds,
            'pageTitle' => 'PC Design & Creative',
            'pageDescription' => 'Hệ thống PC chuyên dụng cho thiết kế đồ họa, render 3D, video editing'
        ]);
    }
}

