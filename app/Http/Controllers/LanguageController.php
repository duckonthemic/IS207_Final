<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Supported locales
     */
    protected array $supportedLocales = ['vi', 'en'];

    /**
     * Switch language
     */
    public function switch(Request $request, string $locale)
    {
        // Validate locale
        if (!in_array($locale, $this->supportedLocales)) {
            $locale = config('app.locale', 'vi');
        }

        // Set locale in session
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Redirect back to previous page
        return redirect()->back()->with('success', __('messages.language') . ': ' . ($locale === 'vi' ? 'Tiếng Việt' : 'English'));
    }

    /**
     * Get current locale
     */
    public function current()
    {
        return response()->json([
            'locale' => App::getLocale(),
            'supported' => $this->supportedLocales,
        ]);
    }
}
