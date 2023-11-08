<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class LanguageSwitchMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }else{
            $locale = Cookie::get('locale');
            if(!in_array($locale, config('app.accepted_locales'))){
                $locale = config('app.fallback_locale');
            }
            session()->put('locale', $locale);
            App::setLocale($locale);
        }
        return $next($request);
    }
}
