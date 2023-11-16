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

//        $business = $user->business;
//        $business->package_code = $package->code;
//        $business->package_expiry_at = now()->addDays($package->package_interval_days);
//        $business->save();
//
//        $user->registration_step = $user->registration_step + 1;
//        $user->save();
        return $response;
    }
}
