<?php

namespace App\Http\Controllers;

use App\Actions\GenerateSelcomPayment;

class TestController extends Controller
{
    public function testing()
    {

        $paymentParams = [
            "vendor" => config('payments.selcom_vendor'),
            "order_id" => \Str::random('5'),
            "buyer_email" => "john@example.com",
            "buyer_name" => "John Erick",
            "buyer_phone" => "255763466080",
            "amount" => 1000,
            "currency" => "TZS",
            "redirect_url" => base64_encode(route('home')),
            "cancel_url" => base64_encode(route('home')),
            "webhook" => base64_encode(route('selcom.callback')),
            "buyer_remarks" => "None",
            "merchant_remarks" => "None",
            "no_of_items" => 1
        ];

        $requestResult = GenerateSelcomPayment::run($paymentParams);


        dd($requestResult);
    }
}
