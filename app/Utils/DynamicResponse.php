<?php

namespace App\Utils;

class DynamicResponse
{
    public static function sendResponse(callable $httpResponse, callable $jsonResponse)
    {
        if (\Illuminate\Support\Facades\Request::is('api/*') || \Illuminate\Support\Facades\Request::wantsJson()) {
            return $jsonResponse();
        }
        return $httpResponse();
    }

}
