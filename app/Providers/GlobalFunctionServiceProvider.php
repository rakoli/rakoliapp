<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
 
class GlobalFunctionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('translator', function ($stringA, $stringB) {
            $lang = Session::get('lang', 1); // Default to lang 1 if not set in the session
            return $lang === 1 ? Lang::get($stringA) : Lang::get($stringB);
        });
    }
}
