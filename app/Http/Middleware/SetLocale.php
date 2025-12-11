<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales
     */
    protected array $supportedLocales = ['vi', 'en'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: URL param > Session > Browser > Default
        $locale = $this->determineLocale($request);

        // Validate locale
        if (!in_array($locale, $this->supportedLocales)) {
            $locale = config('app.locale', 'vi');
        }

        // Set the locale
        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }

    /**
     * Determine the locale from various sources
     */
    protected function determineLocale(Request $request): string
    {
        // 1. Check URL parameter (for language switching)
        if ($request->has('lang') && in_array($request->get('lang'), $this->supportedLocales)) {
            return $request->get('lang');
        }

        // 2. Check session
        if (Session::has('locale')) {
            return Session::get('locale');
        }

        // 3. Check browser's Accept-Language header
        $browserLocale = $request->getPreferredLanguage($this->supportedLocales);
        if ($browserLocale) {
            return $browserLocale;
        }

        // 4. Default to config locale
        return config('app.locale', 'vi');
    }
}
