<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentProcessingController extends Controller
{
    public function dpoCallback(Request $request)
    {
        $response = '<?xml version="1.0" encoding="utf-8"?><API3G><Response>OK</Response></API3G>';
        Log::info($request);
        return $response;
    }
}
