<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $lang = $request->input('lang');
        $lang = $lang == "English" ? 1 : 2;
        session(['lang' => $lang]);
        
        return back();
    }

    public function auth(Request $request){
        echo 'invalid';
    }

    public function page(){
        $link = $_SERVER;

        print_r($link);
    }
}
