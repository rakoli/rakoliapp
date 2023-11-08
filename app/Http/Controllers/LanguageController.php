<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{

    public function languageSwitch(Request $request)
    {
        $locale = $request->language;

        if(!in_array($locale, config('app.accepted_locales'))){
            $locale = 'en';
        }

        App::setLocale($locale);

        session()->put('locale', $locale);

        return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
    }

}
