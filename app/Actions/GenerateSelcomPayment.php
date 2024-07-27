<?php

namespace App\Actions;

use App\Utils\SelcomPayment;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateSelcomPayment
{
    use AsAction;

    public function handle($data)
    {
        $selcom = new SelcomPayment();

        $result = $selcom->paymentRequest($data);

        return $result;
    }
}
