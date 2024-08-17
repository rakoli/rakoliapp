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
        echo "<pre>";
        $users = User::where('registration_step',1)->orWhere('registration_step',2)->get();

        $lastMessage = "";
        foreach ($users as $user) {

            echo "$user->full_name | $user->registration_step \n";
            $text = "Ndugu {$user->full_name}, Kamilisha usajili wako wa mfumo wa mawakala wa Rakoli. Lipia au jaribu kifurushi chetu cha bure (trial) kwa mwaka moja. Kwa msaada piga 0743283839. Rakoli - Thamani kwa Wakala";
            echo "$text\n";
            if(env('APP_ENV') == 'production'){
//                SMS::sendToUser($user, $text);
            }else{
                Log::debug("SMS: $text");
            }
            echo "\n";
            $lastMessage = $text;
        }

        if(env('APP_ENV') == 'production'){
            SMS::nextSMSSendSingleText('255763466080', $lastMessage);
        }

        echo "</pre>";

//        return false;

    }


    public function testing2()
    {

        $selcom = new SelcomPayment();
        $completionStatus = $selcom->isPaymentComplete('growth_140_1723930795');

        dd($completionStatus, );


    }
}
