<?php

namespace App\Utils;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Selcom\ApigwClient\Client;
use Illuminate\Support\Facades\Log;

class SelcomPayment
{

    protected string $key;

    protected string $secret;

    protected string $baseURL;

    protected Client $client;

    public function __construct()
    {
        $this->baseURL = config('payments.selcom_baseurl');
        $this->key = config('payments.selcom_key');
        $this->secret = config('payments.selcom_secret');

        // Init client
        $this->client = new Client($this->baseURL, $this->key, $this->secret);

    }

    /*
     * Make a payment request to Selcom
     * */
    public function paymentRequest($params)
    {
        $results = [];
        $response = null;

        try {
            $orderPath = "/v1/checkout/create-order-minimal";
            $response = $this->client->postFunc($orderPath,$params);
            $results = $response;
        } catch (\Exception $exception) {
            Log::error($exception);
            Bugsnag::notifyException($exception);

            return [
                'success' => false,
                'result' => $response,
                'resultExplanation' => $exception->getMessage(),
            ];
        }

        return [
            'success' => true,
            'result' => $results,
            'resultExplanation' => 'Payment Request Sent Successfully',
        ];
    }

    /*
     * Get transaction status from Selcom using OrderTrackingId
     * */
    public function transactionStatus($id)
    {
        $response = null;
        $results = [];
        try {
            $orderStatusPath = "/v1/checkout/order-status";
            $orderStatusArray = ["order_id"=>$id];
            $response = $this->client->postFunc($orderStatusPath,$orderStatusArray);
            $results = $response;
        } catch (\Exception $exception) {
            Log::error($exception);
            Bugsnag::notifyException($exception);

            return [
                'success' => false,
                'result' => $response,
                'resultExplanation' => $exception->getMessage(),
            ];
        }

        return [
            'success' => true,
            'result' => $results,
            'resultExplanation' => 'Transaction Status Retrieved Successfully',
        ];
    }

    public function isPaymentComplete($id)
    {
        $response = $this->transactionStatus($id);
        $result = $response['result'];
        if ($result['resultcode'] == 0 && $result['data'][0]['payment_status'] == 'COMPLETED') {
            return [
                'success' => true,
                'result' => $result['data'][0]['payment_status'],
                'resultExplanation' => 'Transaction Paid',
            ];
        }

        dd($result);

        return [
            'success' => false,
            'result' => $result['data'][0]['payment_status'],
            'resultExplanation' => 'Transaction Not Paid',
        ];
    }

}
