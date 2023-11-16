<?php

namespace App\Utils;

class DPORequestTokenFormat
{
    public $paymentAmount;
    public $paymentCurrency;
    public $customerFirstName;
    public $customerLastName;
    public $customerAddress;
    public $customerCountryISOCode;
    public $customerDialCode;
    public $customerPhone;
    public $customerEmail;
    public $companyRef;

    public function __construct($paymentAmount,$paymentCurrency,$customerFirstName,$customerLastName,$customerAddress,
                                 $customerCountryISOCode, $customerDialCode,$customerPhone,$customerEmail,
                                $companyRef)
    {
        $this->paymentAmount = $paymentAmount;
        $this->paymentCurrency = $paymentCurrency;
        $this->customerFirstName = $customerFirstName;
        $this->customerLastName = $customerLastName;
        $this->customerAddress = $customerAddress;
        $this->customerCountryISOCode = $customerCountryISOCode;
        $this->customerDialCode = $customerDialCode;
        $this->customerPhone = $customerPhone;
        $this->customerEmail = $customerEmail;
        $this->companyRef = $companyRef;
    }

}
