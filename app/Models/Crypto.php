<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getCryptoList()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.coincap.io/v2/assets');
            $responseStatus = $response->getStatusCode(); // 200
            $responseJson = $response->getBody();
            if($responseStatus == 200){
                return json_decode($responseJson,true);
            }
        }catch (\Exception $exception){
            \Bugsnag::notifyException($exception);
            \Log::error($exception);
        }
        return false;
    }
}
