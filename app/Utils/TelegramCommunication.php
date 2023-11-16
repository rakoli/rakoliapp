<?php

namespace App\Utils;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TelegramCommunication
{

    public static function updates($messageToSend)
    {

        try {
            $client = new Client([
                // Bse URI is used with relative requests
                "base_uri" => "https://api.telegram.org",
            ]);

            $bot_token = env('TELEGRAM_BOT_TOKEN');;
            $chat_id = env('TELEGRAM_BOT_CHATID');
            $message = $messageToSend;
            $response = $client->request("GET", "/bot$bot_token/sendMessage", [
                "query" => [
                    "chat_id" => $chat_id,
                    "text" => $message,
                    "parse_mode" => 'markdown',
                    "disable_web_page_preview" => true
                ]
            ]);

            $body = $response->getBody();
            $arr_body = json_decode($body);

            if ($arr_body->ok) {
                return true;
            }

        } catch (Exception $exception) {
            Log::error($exception);
            Bugsnag::notifyException($exception);
            return false;
        }

        return false;
    }

}
