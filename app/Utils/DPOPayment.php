<?php

namespace App\Utils;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class DPOPayment
{
    const DPO_URL_TEST = 'https://secure1.sandbox.directpay.online';

    const DPO_URL_LIVE = 'https://secure.3gdirectpay.com';

    private $dpoUrl;

    private $dpoGateway;

    private $testMode = false;

    private $company_token;

    private $company_type;

    private $dpo_back_url;

    private $dpo_redirect_url;

    public function __construct()
    {
        $this->testMode = config('payments.is_test_mode');
        $this->company_token = config('payments.company_token');
        $this->company_type = config('payments.account_type');
        $this->dpo_back_url = config('payments.back_url');
        $this->dpo_redirect_url = config('payments.redirect_url');
        if ($this->testMode == true) {
            $this->dpoUrl = self::DPO_URL_TEST;
        } else {
            $this->dpoUrl = self::DPO_URL_LIVE;
        }
        $this->dpoGateway = $this->dpoUrl.'/payv2.php?ID=';
    }

    public function getDpoGateway()
    {
        return $this->dpoGateway;
    }

    public function createToken(array $data, $service = null)
    {
        $companyToken = $this->company_token;
        $accountType = $this->company_type;
        if ($service != null) {
            $accountType = $service;
        }
        $paymentAmount = $data['paymentAmount'];
        $paymentCurrency = $data['paymentCurrency'];
        $customerFirstName = $data['customerFirstName'];
        $customerLastName = $data['customerLastName'];
        $customerAddress = $data['customerAddress'];
        $customerPhone = $data['customerPhone'];
        $customerCountry = $data['customerCountryISOCode'];
        $customerDialCode = $data['customerDialCode'];
        $redirectURL = $this->dpo_redirect_url;
        $backURL = $this->dpo_back_url;
        $customerEmail = $data['customerEmail'];
        $reference = $data['companyRef'];
        $timeLimit = config('payments.payment_valid_time_hours');

        $odate = date('Y/m/d H:i');
        $postXml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                    <API3G>
                        <CompanyToken>$companyToken</CompanyToken>
                        <Request>createToken</Request>
                        <Transaction>
                            <PTL>$timeLimit</PTL>
                            <PaymentAmount>$paymentAmount</PaymentAmount>
                            <PaymentCurrency>$paymentCurrency</PaymentCurrency>
                            <CompanyRef>$reference</CompanyRef>
                            <customerFirstName>$customerFirstName</customerFirstName>
                            <customerLastName>$customerLastName</customerLastName>
                            <customerAddress>$customerAddress</customerAddress>
                            <customerPhone>$customerPhone</customerPhone>
                            <customerCountry>$customerCountry</customerCountry>
                            <customerDialCode>$customerDialCode</customerDialCode>
                            <DefaultPayment>MO</DefaultPayment>
                            <RedirectURL>$redirectURL</RedirectURL>
                            <BackURL>$backURL</BackURL>
                            <customerEmail>$customerEmail</customerEmail>
                            <TransactionSource>whmcs</TransactionSource>
                        </Transaction>
                        <Services>
                            <Service>
                                <ServiceType>$accountType</ServiceType>
                                <ServiceDescription>$reference</ServiceDescription>
                                <ServiceDate>$odate</ServiceDate>
                            </Service>
                        </Services>
                    </API3G>";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->dpoUrl.'/API/v6/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postXml,
            CURLOPT_HTTPHEADER => [
                'cache-control: no-cache',
            ],
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($response != '') {
            try {
                $xml = new \SimpleXMLElement($response);
                $result = $xml->xpath('Result')[0]->__toString();
                $resultExplanation = $xml->xpath('ResultExplanation')[0]->__toString();
                $returnResult = [
                    'result' => $result,
                    'resultExplanation' => $resultExplanation,
                ];
            } catch (\Exception $exception) {
                Log::error($response);
                Bugsnag::notifyException($exception);

                return [
                    'success' => false,
                    'result' => $response,
                    'resultExplanation' => $exception->getMessage(),
                ];
            }

            // Check if token was created successfully
            if ($xml->xpath('Result')[0] != '000') {
                $returnResult['success'] = false;
            } else {
                $transToken = $xml->xpath('TransToken')[0]->__toString();
                $transRef = $xml->xpath('TransRef')[0]->__toString();
                $returnResult['success'] = true;
                $returnResult['transToken'] = $transToken;
                $returnResult['transRef'] = $transRef;
            }

            return $returnResult;
        } else {
            Log::error($response);
            Bugsnag::notifyError('DPO Payment', 'Empty Response on request');

            return [
                'success' => false,
                'result' => ! empty($error) ? $error : 'Unknown error occurred in token creation',
                'resultExplanation' => ! empty($error) ? $error : 'Unknown error occurred in token creation',
            ];
        }
    }

    public function verifyToken(array $data)
    {
        $companyToken = $data['companyToken'];
        $transToken = $data['transToken'];

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->dpoUrl.'/API/v6/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<API3G>\r\n  <CompanyToken>".$companyToken."</CompanyToken>\r\n  <Request>verifyToken</Request>\r\n  <TransactionToken>".$transToken."</TransactionToken>\r\n</API3G>",
                CURLOPT_HTTPHEADER => [
                    'cache-control: no-cache',
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            //            //For trials
            /*            $response = '<?xml version="1.0" encoding="utf-8"?><API3G><Result>000</Result><ResultExplanation>Transaction paid successfully</ResultExplanation>*/
            //<CustomerName>Erick Thomas</CustomerName><CustomerCredit></CustomerCredit><CustomerCreditType></CustomerCreditType><TransactionApproval></TransactionApproval>
            //<TransactionCurrency>TZS</TransactionCurrency><TransactionAmount>60000.00</TransactionAmount><FraudAlert>001</FraudAlert><FraudExplnation>Low Risk (Not checked)</FraudExplnation>
            //<TransactionNetAmount>0.00</TransactionNetAmount><TransactionSettlementDate>2023/11/15</TransactionSettlementDate><TransactionRollingReserveAmount>0.00</TransactionRollingReserveAmount>
            //<TransactionRollingReserveDate></TransactionRollingReserveDate><CustomerPhone>0752991650</CustomerPhone><CustomerCountry>Tanzania</CustomerCountry><CustomerAddress>Tanzania</CustomerAddress>
            //<CustomerCity>Arusha</CustomerCity><CustomerZip></CustomerZip><MobilePaymentRequest>Pending</MobilePaymentRequest><AccRef></AccRef><TransactionFinalCurrency></TransactionFinalCurrency>
            //<TransactionFinalAmount>0.00</TransactionFinalAmount></API3G>';
            //            $err = null;
            //            //End for trials

            if (strlen($err) > 0) {
                echo 'cURL Error #:'.$err;
                Log::error($err);
                Bugsnag::notifyError('DPO Payment (VerifyToken)', $err);

                return [
                    'success' => false,
                    'result' => ! empty($err) ? $err : 'Unknown error occurred in verify token',
                    'resultExplanation' => ! empty($err) ? $err : 'Unknown error occurred in verify token',
                ];
            } else {
                return [
                    'success' => true,
                    'result' => $response,
                    'resultExplanation' => 'Successfully executed verify token, check result for interpretation',
                ];
            }
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            Log::error($exception);

            return [
                'success' => false,
                'result' => ! empty($exception) ? $exception : 'Unknown error occurred in token creation',
                'resultExplanation' => ! empty($exception) ? $exception : 'Unknown error occurred in token creation',
            ];
        }
    }

    public function getPaymentUrl(array $createTokenData)
    {
        $dpo = new DPOPayment();
        if ($createTokenData['success'] == true) {
            $verify = $dpo->verifyToken(['companyToken' => config('payments.company_token'), 'transToken' => $createTokenData['transToken']]);
            if (! empty($verify['result']) && $verify['result'] != '') {
                try {
                    $verify = new \SimpleXMLElement($verify['result']);

                    if ($verify->Result->__toString() === '900') {
                        $payUrl = $dpo->getDpoGateway().$createTokenData['transToken'];

                        // redirect($payUrl);
                        return [
                            'success' => true,
                            'result' => $payUrl,
                            'resultExplanation' => 'Generated URL. Check result',
                            'transToken' => $createTokenData['transToken'],
                        ];
                    }
                } catch (\Exception $exception) {
                    Log::error($exception);
                    Bugsnag::notifyException($exception);

                    return [
                        'success' => false,
                        'result' => $verify['result'],
                        'resultExplanation' => $exception->getMessage(),
                    ];
                }
            } else {
                Log::error('DPO Payment getPaymentUrl empty response');
                Bugsnag::notifyError('DPO Payment', 'getPaymentUrl empty response');

                return [
                    'success' => false,
                    'result' => $verify['result'],
                    'resultExplanation' => 'On getPaymentUrl: Error!Empty Verify Response from DPO',
                ];
            }
        } else {
            Log::error('On getPaymentUrl: '.$createTokenData['resultExplanation']);
            Bugsnag::notifyError('On getPaymentUrl: ', $createTokenData['resultExplanation']);

            return [
                'success' => false,
                'result' => $createTokenData,
                'resultExplanation' => 'On getPaymentUrl: '.$createTokenData['resultExplanation'],
            ];
        }
    }

    public function getPaymentUrlWithoutVerifyToken(array $createTokenData)
    {
        $dpo = new DPOPayment();
        if ($createTokenData['success'] == true) {
            $payUrl = $dpo->getDpoGateway().$createTokenData['transToken'];

            return [
                'success' => true,
                'result' => $payUrl,
                'resultExplanation' => 'Generated URL. Check result',
                'transToken' => $createTokenData['transToken'],
            ];
        } else {
            Log::error('On getPaymentUrlWithoutVerifyToken: '.$createTokenData['resultExplanation']);
            Bugsnag::notifyError('On getPaymentUrlWithoutVerifyToken: ', $createTokenData['resultExplanation']);

            return [
                'success' => false,
                'result' => $createTokenData,
                'resultExplanation' => 'On getPaymentUrlWithoutVerifyToken: '.$createTokenData['resultExplanation'],
            ];
        }
    }

    public function isPaymentComplete($transactionToken)
    {
        $dpo = new DPOPayment();

        $verify = $dpo->verifyToken(['companyToken' => config('payments.company_token'), 'transToken' => $transactionToken]);

        if (! empty($verify['result']) && $verify['result'] != '') {
            $responseArray = [];
            try {
                $verify = new \SimpleXMLElement($verify['result']);

                if ($verify->Result->__toString() === '000') {
                    $responseArray = [
                        'success' => true,
                        'result' => 'completed',
                        'resultExplanation' => $verify->ResultExplanation->__toString(),
                    ];
                } else {
                    $responseArray = [
                        'success' => false,
                        'result' => 'not complete',
                        'resultExplanation' => $verify->ResultExplanation->__toString(),
                    ];
                }
            } catch (\Exception $exception) {
                Log::error($verify['result']);
                Bugsnag::notifyException($exception);
                $responseArray = [
                    'success' => false,
                    'result' => $verify['result'],
                    'resultExplanation' => $exception->getMessage(),
                ];
            }

            return $responseArray;
        } else {
            Log::error('DPO Payment checkPaymentComplete empty response');
            Bugsnag::notifyError('DPO Payment', 'checkPaymentComplete empty response');

            return [
                'success' => false,
                'result' => $verify['result'],
                'resultExplanation' => 'On checkPaymentComplete: Error!Empty Verify Response from DPO',
            ];
        }

    }
}
