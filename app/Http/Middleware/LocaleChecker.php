<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;

class LocaleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if ($request->method() === 'GET') {
            $locale = $request->segment(1);
            $localeLenght = strlen($locale);
            $defaultLocale = config('app.locale');

            if (empty($locale)) {
                app()->setLocale($defaultLocale);
                return $next($request);
            }

            if ($locale === $defaultLocale) {
                app()->setLocale($defaultLocale);
                $url = trim($request->getPathInfo(), "/{$defaultLocale}");
                return redirect()->to($url);
            }

            if (in_array($locale, config('app.public_locales'))) {
                app()->setLocale($locale);
                return $next($request);
            }

            app()->setLocale($defaultLocale);
//            return abort(404);
        }

        return $next($request);
    }
}
