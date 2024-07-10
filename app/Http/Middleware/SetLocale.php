<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('X-Locale');

        $locales = config('localization.supportedLocales');

        if (array_key_exists($lang, $locales)) {
            app()->setLocale($lang);
            \setlocale(LC_TIME, $locales[$lang]);
        } else {
            app()->setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
