<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a static page by slug
     */
    public function show(string $slug)
    {
        // Map of slugs to view files
        $pages = [
            'bao-hanh' => 'pages.warranty',
            'doi-tra' => 'pages.return-policy',
            'dieu-khoan' => 'pages.terms',
            'faq' => 'pages.faq',
            'gioi-thieu' => 'pages.about',
            'lien-he' => 'pages.contact',
        ];

        // Check if page exists
        if (!isset($pages[$slug])) {
            abort(404, 'Trang không tồn tại');
        }

        $viewName = $pages[$slug];

        // Check if view file exists
        if (!view()->exists($viewName)) {
            abort(404, 'Trang không tồn tại');
        }

        return view($viewName);
    }
}
