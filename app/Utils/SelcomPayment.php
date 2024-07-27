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
        $this->authenticate();
        $url = $this->getEndPointUrl(config('payments.pesapal-endpoint')['tsq']);
        $url .= "?orderTrackingId={$id}";
        $results = [];
        try {
            $response = $this->client->request('GET', $url, ['headers' => $this->headers]);
            $results = json_decode($response->getBody()->getContents());
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

        if ($result->status == 200 && $result->payment_status_description == 'Completed') {
            return [
                'success' => true,
                'result' => $result->payment_status_description,
                'resultExplanation' => 'Transaction Paid',
            ];
        }

        return [
            'success' => false,
            'result' => $result->payment_status_description,
            'resultExplanation' => 'Transaction Not Paid',
        ];
    }

}
