<?php

namespace App\Utils;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\User;
use Symfony\Component\HttpClient\HttpClient;

class SMS
{
    public static function nextSMSSendSingleText($to, $text)
    {
        $client = HttpClient::create([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept header' => 'application/json',
                'Authorization' => 'Basic '.base64_encode(env('NEXTSMS_USERNAME').':'.env('NEXTSMS_PASSWORD')),
            ],
        ]);

        $body = [
            'from' => 'rakoli',
            'to' => $to,
            'text' => $text,
            'reference' => 'web_app'.random_int(10, 99),
        ];

        $response = $client->request(
            'POST',
            'https://messaging-service.co.tz/api/sms/v1/text/single',
            [
                'body' => json_encode($body),
            ]
        );

        //        $statusCode = $response->getStatusCode();
        //        $contentType = $response->getHeaders()['content-type'][0];
        //        $content = $response->getContent();

        return $response;
    }

    public static function atSendSingleText($to, $text)
    {
        $username = env('AT_USERNAME'); // use 'sandbox' for development in the test environment
        $apiKey = env('AT_KEY'); // use your sandbox app API key for development in the test environment
        $atClient = new AfricasTalking($username, $apiKey);

        $sms = $atClient->sms();

        $result = $sms->send([
            'to' => $to,
            'message' => $text,
        ]);

        return $result;
    }

    public static function sendToUser(User $user, $text)
    {
        $phone = cleanText($user->phone);

        $country = substr($phone, 0, 3);

        if ($country == '255') {
            self::nextSMSSendSingleText($phone, $text);
        } else {
            self::atSendSingleText($phone, $text);
        }

        return true;
    }
}
