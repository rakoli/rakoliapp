<?php

namespace App\Http\Controllers;

use App\Actions\CompleteInitiatedPayment;
use App\Models\InitiatedPayment;
use App\Utils\Enums\InitiatedPaymentStatusEnum;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentProcessingController extends Controller
{
    public function dpoCallback(Request $request)
    {
        $response = $request->getContent();

        //        Log::info($response);
        /*        $response = '<?xml version="1.0" encoding="utf-8"?><API3G><Result>000</Result><ResultExplanation>Transaction Paid</ResultExplanation>*/
        //<TransactionToken>5989E818-C8ED-4448-BEC5-941FA1B116E3</TransactionToken><TransactionRef>rwa_21609</TransactionRef>
        //<CustomerName>Erick Mabusi</CustomerName><CustomerEmail>emabusi@gmail.com</CustomerEmail><CustomerCredit>8367</CustomerCredit>
        //<CustomerCreditType>MASC</CustomerCreditType><TransactionApproval>4444444416</TransactionApproval><TransactionCurrency>TZS</TransactionCurrency>
        //<TransactionAmount>500.00</TransactionAmount><FraudAlert>000</FraudAlert><FraudExplnation>Genuine transaction</FraudExplnation><TransactionNetAmount>500.00</TransactionNetAmount>
        //<TransactionSettlementDate></TransactionSettlementDate><TransactionRollingReserveAmount>0.00</TransactionRollingReserveAmount><TransactionRollingReserveDate>
        //</TransactionRollingReserveDate><CustomerPhone>0763466080</CustomerPhone><CustomerCountry>Tanzania</CustomerCountry><CustomerAddress>Tanzania</CustomerAddress>
        //<CustomerCity>Arusha</CustomerCity><CustomerZip></CustomerZip><MobilePaymentRequest>Not sent</MobilePaymentRequest><AccRef></AccRef></API3G>';

        if ($response != '') {
            try {
                $xml = new \SimpleXMLElement($response);

                // Check if token was created successfully
                if ($xml->xpath('Result')[0] == '000') {

                    $initiatedPayment = InitiatedPayment::where('channel', 'dpopay')
                        ->where('channel_ref', $xml->xpath('TransactionToken')[0])
                        ->where('status', InitiatedPaymentStatusEnum::INITIATED->value)->first();

                    if ($initiatedPayment != null) {

                        CompleteInitiatedPayment::dispatch($initiatedPayment);

                    }

                }

            } catch (\Exception $exception) {
                Log::error($response);
                Bugsnag::notifyException($exception);
            }

        } else {
            Log::error($response);
            Bugsnag::notifyError('DPO Payment', 'Empty Response on request');
        }

        $returnResponse = '<?xml version="1.0" encoding="utf-8"?><API3G><Response>OK</Response></API3G>';

        return $returnResponse;
    }

    public function pesapalCallback(Request $request)
    {
        $response = $request->getContent();
        Log::info($response);

        return [
            'success' => true,
            'result' => 'okay',
            'resultExplanation' => 'data received successfully',
        ];
    }

    public function selcomCallback(Request $request)
    {
        $response = $request->getContent();
        Log::info($response);

        return [
            'success' => true,
            'result' => 'okay',
            'resultExplanation' => 'data received successfully',
        ];

    }

    public function completePendingTestPayment(Request $request, $reference)
    {
        $initiatedPayment = InitiatedPayment::where('channel', 'test')
            ->where('channel_ref', $reference)
            ->where('status', InitiatedPaymentStatusEnum::INITIATED->value)->first();

        if ($initiatedPayment != null) {

            CompleteInitiatedPayment::dispatch($initiatedPayment);

            return redirect()->route('registration.agent')->with(['message' => 'Test Payment Completion Done']);
        } else {
            return redirect()->route('registration.agent')->withErrors(['Unable to retrieve Initiated Payment with given reference.'.$reference]);
        }

    }

    public function completePendingTrialPayment(Request $request, $reference)
    {
        $initiatedPayment = InitiatedPayment::where('channel_ref', $reference)
            ->where('status', InitiatedPaymentStatusEnum::INITIATED->value)->first();

        if ($initiatedPayment != null) {

            CompleteInitiatedPayment::dispatch($initiatedPayment);

            return redirect()->route('registration.agent')->with(['message' => 'Trial Payment Completion Done']);
        } else {
            return redirect()->route('registration.agent')->withErrors(['Unable to retrieve Initiated Payment with given reference.'.$reference]);
        }

    }
}
