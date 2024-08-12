<?php

namespace App\Http\Controllers;

use App\Actions\GenerateSelcomPayment;
use App\Models\Package;
use App\Models\PackageAvailableFeatures;
use App\Models\PackageFeature;
use App\Models\PackageName;
use App\Models\User;
use App\Utils\Enums\FeatureAccessEnum;
use App\Utils\SelcomPayment;
use App\Utils\SMS;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function testing()
    {
        $users = User::where('registration_step',3)->get();

        foreach ($users as $user) {

            $text = "Ndugu {$user->fname}, Rakoli sasa ina package ya bure (trial) unayoweza kutumia kwa mwaka moja. Malizia usajili wako na package hii kuimarisha biashara yako ya uwakala. Rakoli - Thamani kwa Wakala";

            if(env('APP_ENV') == 'production'){
                SMS::sendToUser($user, $text);
            }else{
                Log::debug("SMS: $text");
            }

        }


        return false;

    }


    public function testing2()
    {


    }
}
