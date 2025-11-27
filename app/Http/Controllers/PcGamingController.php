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
        return $this->getProductsByCategory($request, 'pc-gaming', 'PC Gaming - Bộ PC Gaming Lắp Sẵn', 'Bộ máy tính gaming được lựa chọn kỹ lưỡng, tối ưu hiệu năng và giá thành');
    }

    /**
     * Display build PC configurator
     */
    public function buildPc()
    {
        return view('build-pc');
    }

    /**
     * Display PC AI listing page
     */
    public function pcAI(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-ai-workstation', 'PC AI Workstation', 'Hệ thống PC tối ưu cho Machine Learning, Deep Learning và xử lý AI');
    }

    /**
     * Display PC Office listing page
     */
    public function pcOffice(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-office', 'PC Office', 'Hệ thống PC cho văn phòng, làm việc hiệu quả');
    }

    /**
     * Display PC Design listing page
     */
    public function pcDesign(Request $request)
    {
        return $this->getProductsByCategory($request, 'pc-design', 'PC Design & Creative', 'Hệ thống PC chuyên dụng cho thiết kế đồ họa, render 3D, video editing');
    }

    private function getProductsByCategory(Request $request, $categorySlug, $title, $description)
    {
        $query = Product::whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        })->with(['category', 'images', 'specs.specDefinition']);

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Sort
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $builds = $query->paginate(12)->withQueryString();

        return view('pc-gaming.index', [
            'builds' => $builds,
            'pageTitle' => $title,
            'pageDescription' => $description
        ]);
    }
}

