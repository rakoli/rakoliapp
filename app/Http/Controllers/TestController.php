<?php

namespace App\Http\Controllers;

use App\Actions\GenerateSelcomPayment;
use App\Utils\SelcomPayment;

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
            "no_of_items" => 1,

            "payment_methods"=>"MOBILEMONEYPULL",
            "billing.firstname" => "John",
            "billing.lastname" => "Erick",
            "billing.address_1" => "Kinondoni",
            "billing.city" => "Dar es salaam",
            "billing.state_or_region" => "Dar es salaam",
            "billing.postcode_or_pobox" => "00255",
            "billing.country" => "TZ",
            "billing.phone" => "255763466080",
        ];

//        $requestResult = GenerateSelcomPayment::run($paymentParams);
//        $requestResult = '{
//  "reference" : "0289999288",
//  "resultcode" : "000",
//  "result" : "SUCCESS",
//  "message" : "Payment notification logged",
//  "data": [{"gateway_buyer_uuid":"12344321", "payment_token":"80008000", "qr":"QR", "payment_gateway_url":"aHR0cDpleGFtcGxlLmNvbS9wZy90MTIyMjI="}]
//}';
//        $requestResult = json_decode($requestResult,true);
//
//        $paymentUrl = base64_decode($requestResult['data'][0]['payment_gateway_url']);
//
//        if($requestResult['resultcode'] == 0){
////            dd('tupo');
//        }




        $requestResult = GenerateSelcomPayment::run($paymentParams);

        if ($requestResult['success'] == false || $requestResult['result']['resultcode'] != 0) {
            return [
                'success' => false,
                'result' => 'Selcom Error',
                'resultExplanation' => 'Unable to request payment.' . $requestResult['result']['message'],
            ];
        }

        $apiResponse = $requestResult['result']['data'][0];
        $requestResult['url'] = $apiResponse['payment_gateway_url'];

        $redirectUrl = $apiResponse['payment_gateway_url'];
        $reference = $apiResponse['payment_token'];
        $referenceName = 'payment_token';

        dd($requestResult,$redirectUrl, $reference,$referenceName, $paymentParams['order_id']);



//        $requestResult = '{
//  "reference" : "0289999288",
//  "resultcode" : "000",
//  "result" : "SUCCESS",
//  "message" : "Order fetch successful",
//  "data": [{"order_id":"123", "creation_date":"2019-06-06 22:00:00", "amount":"1000", "payment_status":"PENDING","transid":null,"channel":null,"reference":null,"phone":null}]
//}';
//        $requestResult = json_decode($requestResult,true);
//
//        dd($requestResult,$requestResult['resultcode'],$requestResult['data'][0],$requestResult['data'][0]['amount'],$requestResult['data'][0]['payment_status']);
//

        return false;

    }


    public function testing2()
    {
        $selcom = new SelcomPayment();
        $completionStatus = $selcom->isPaymentComplete('rZdA9');

        dd($completionStatus);
    }
}
