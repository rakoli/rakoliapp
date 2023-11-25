<?php

namespace App\Http\Controllers;

use App\Actions\GenerateDPOPayment;
use App\Actions\RequestEmailVerificationCode;
use App\Actions\SendTelegramNotification;
use App\Mail\SendCodeMail;
use App\Models\ExchangeAds;
use App\Models\ExchangeStat;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\DPOPayment;
use App\Utils\DPORequestTokenFormat;
use App\Utils\Enums\AgentRegistrationStepsEnums;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use App\Utils\PesaPalPayment;
use App\Utils\TelegramCommunication;
use App\Utils\SMS;
use App\Utils\VerifyOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class TestController extends Controller
{
    public function testing()
    {

    }
}
