<?php

namespace App\Http\Controllers;

use App\Utils\TelegramCommunication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentProcessingController extends Controller
{
    public function dpoCallback(Request $request)
    {
        $response = '<?xml version="1.0" encoding="utf-8"?><API3G><Response>OK</Response></API3G>';
        Log::info($request->getContent());
        return $response;
    }
}
