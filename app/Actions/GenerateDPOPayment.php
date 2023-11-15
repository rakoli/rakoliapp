<?php

namespace App\Actions;

use App\Utils\DPOPayment;
use App\Utils\DPORequestTokenFormat;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateDPOPayment
{
    use AsAction;

    public function handle(DPORequestTokenFormat $tokenRequest, $serviceType = null)
    {
        $dpo = new DPOPayment();
        $data = [
            'paymentAmount' => $tokenRequest->paymentAmount,
            'paymentCurrency' => $tokenRequest->paymentCurrency,
            'customerFirstName' => $tokenRequest->customerFirstName,
            'customerLastName' => $tokenRequest->customerLastName,
            'customerAddress' => $tokenRequest->customerAddress,
            'customerCity' => $tokenRequest->customerCity,
            'customerCountryISOCode' => $tokenRequest->customerCountryISOCode,
            'customerDialCode' => $tokenRequest->customerDialCode,
            'customerPhone' => $tokenRequest->customerPhone,
            'customerEmail' => $tokenRequest->customerEmail,
            'companyRef' => $tokenRequest->companyRef
        ];
        $token = $dpo->createToken($data, $serviceType); // return array of response with transaction code
        if($token['success'] == false){
            return $token;
        }
//        Log::debug($token);
        $payment_url = $dpo->getPaymentUrlWithoutVerifyToken($token);
        return $payment_url;
    }
}
