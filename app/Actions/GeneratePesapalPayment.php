<?php

namespace App\Actions;

use App\Utils\PesaPalPayment;
use Lorisleiva\Actions\Concerns\AsAction;

class GeneratePesapalPayment
{
    use AsAction;

    public function handle($data)
    {
        $pesapal = new PesaPalPayment();

        $result = $pesapal->paymentRequest($data);

        return $result;
    }
}
