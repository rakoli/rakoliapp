<?php

namespace App\Utils;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PesaPalPayment
{
    const PESAPAL_URL_TEST = 'https://cybqa.pesapal.com/pesapalv3';

    const PESAPAL_URL_LIVE = 'https://pay.pesapal.com/v3';

    protected string $key;

    protected string $secret;

    protected string $baseURL;

    protected ?string $token = null;

    protected string $expires;

    protected Client $client;

    protected array $headers;

    private $testMode = false;

    /*
     * Let's bootstrap our class.
     * */
    public function __construct()
    {
        $this->testMode = config('payments.pesapal_istest');
        $verify = false;
        if ($this->testMode == false) {
            $verify = true;
        }

        $this->key = config('payments.pesapal_key');
        $this->secret = config('payments.pesapal_secret');

        if ($this->testMode == true) {
            $this->baseURL = self::PESAPAL_URL_TEST;
        } else {
            $this->baseURL = self::PESAPAL_URL_LIVE;
        }

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'debug' => true,
        ];

        // Init client
        $this->client = new Client([
            'base_uri' => $this->baseURL,
            'headers' => $this->headers,
            'verify' => $verify,
        ]);
    }

    public function getEndPointUrl($endpointPath)
    {
        return $this->baseURL.'/'.$endpointPath;
    }

    /*
     * Get authentication token from Pesapal
     * */
    public function authenticate()
    {
        $url = $this->getEndPointUrl(config('payments.pesapal-endpoint')['auth']);
        $params = [
            'consumer_key' => $this->key,
            'consumer_secret' => $this->secret,
        ];
        $results = [];
        try {
            $response = $this->client->request('POST', $url, ['json' => $params, 'headers' => $this->headers]);
            $results = json_decode($response->getBody()->getContents());
            if (! empty($results)) {
                $authRes = $results;
                $this->token = $authRes->token ?? '';
                $this->expires = $authRes->expiryDate ?? '';
                $this->headers['Authorization'] = 'Bearer '.$this->token;
            }
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
            'resultExplanation' => 'Authentication Completed Successfully',
        ];
    }

    /*
     * Make a payment request to Pesapal
     * */
    public function paymentRequest($params)
    {
        $this->authenticate();
        $url = $this->getEndPointUrl(config('payments.pesapal-endpoint')['payment-request']);
        $results = [];
        try {
            $response = $this->client->request('POST', $url, ['json' => $params, 'headers' => $this->headers]);
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
            'resultExplanation' => 'Payment Request Sent Successfully',
        ];
    }

    /*
     * Get transaction status from pesapal using OrderTrackingId
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

    public function IPNList()
    {
        $this->authenticate();
        $url = $this->getEndPointUrl(config('payments.pesapal-endpoint')['ipn-list']);
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
            'resultExplanation' => 'IPN List Fetched Successfully',
        ];
    }

    public function IPNRegister($ipnURL = '', $method = 'GET')
    {
        $this->authenticate();
        $url = $this->getEndPointUrl(config('pesapal.pesapal-endpoint')['ipn-register']);
        $ipn_url = route('pesapal.callback');
        $params = [
            'url' => $ipn_url,
            'ipn_notification_type' => $method,
        ];
        $results = [];
        try {
            $response = $this->client->request('POST', $url, ['json' => $params, 'headers' => $this->headers]);
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
            'resultExplanation' => 'IPN Registered Successfully',
        ];
    }
}
