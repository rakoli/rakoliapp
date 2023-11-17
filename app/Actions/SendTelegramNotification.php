<?php

namespace App\Actions;

use App\Utils\TelegramCommunication;
use Lorisleiva\Actions\Concerns\AsAction;

class SendTelegramNotification
{
    use AsAction;

    public function handle($message)
    {
        TelegramCommunication::updates($message);
    }
}
