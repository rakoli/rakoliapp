<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{

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

    public static function getAllFiatRates()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://api.coincap.io/v2/rates");
            $responseStatus = $response->getStatusCode(); // 200
            $responseJson = $response->getBody();
            $responseArray = json_decode($responseJson,true);
            if($responseStatus == 200){
                return $responseArray['data'];
            }
        }catch (\Exception $exception){
            \Bugsnag::notifyException($exception);
            \Log::error($exception);
        }
        return false;
    }

    public static function getUsdRate($coinCapId)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://api.coincap.io/v2/rates/$coinCapId");
            $responseStatus = $response->getStatusCode(); // 200
            $responseJson = $response->getBody();
            $responseArray = json_decode($responseJson,true);
            if($responseStatus == 200){
                return (1/$responseArray['data']['rateUsd']);
            }
        }catch (\Exception $exception){
            \Bugsnag::notifyException($exception);
            \Log::error($exception);
        }
        return false;
    }

    public static function convertCryptoToFiat($cryptoTypeSymbol,$fiatCurrencySymbol,$cryptoAmount = 1)
    {
        $cryptoModel = Crypto::where('symbol',$cryptoTypeSymbol)->first();
        $cryptoUsdRate = $cryptoModel->usd_rate;
        $usdToFiatCurrencyConvesion = (1/Country::where('currency',$fiatCurrencySymbol)->first()->currency_usdrate);
        return ($cryptoAmount * $cryptoUsdRate * $usdToFiatCurrencyConvesion);
    }

    public static function convertFiatToCrypto($fiatCurrencySymbol,$cryptoTypeSymbol,$fiatAmount = 1)
    {
        $cryptoModel = Crypto::where('symbol',$cryptoTypeSymbol)->first();
        $cryptoUsdRate = $cryptoModel->usd_rate;
        $usdToFiatCurrencyConvesion = (1/Country::where('currency',$fiatCurrencySymbol)->first()->currency_usdrate);
        return ($fiatAmount/($cryptoUsdRate * $usdToFiatCurrencyConvesion));
    }
}
