<?php

return [
    'accepted_payment_methods' => ['pesapal'],
    'payment_valid_time_hours' => 24,


    'company_token' => env('DPO_COMPANY_TOKEN', '9F416C11-127B-4DE2-AC7F-D5710E4C5E0A'),
    'account_type' => env('DPO_ACCOUNT_TYPE', '3854'),
    'is_test_mode' => env('DPO_IS_TEST_MODE', true),
    'back_url' => env('DPO_BACK_URL'),
    'redirect_url' => env('DPO_REDIRECT_URL'),

    'selcom_vendor' => env('SELCOM_VENDOR'),
    'selcom_baseurl' => env('SELCOM_BASEURL'),
    'selcom_key' => env('SELCOM_API_KEY'),
    'selcom_secret' => env('SELCOM_API_SECRET'),

    'pesapal-env' => env('PESAPAL_ENV', 'sandbox'),
    'pesapal_key' => env('PESAPAL_CONSUMER_KEY'),
    'pesapal_secret' => env('PESAPAL_CONSUMER_SECRET'),
    'pesapal_ipnid' => env('PESAPAL_CONSUMER_IPN'),
    'pesapal_istest' => env('PESAPAL_IS_TEST_MODE'),
    'pesapal-endpoint' => [
        /*
         * For getting auth token using key and secret
         * Your Pesapal merchant consumer_key and consumer_secret will be used to generate an access token. This access token is valid for a maximum period of 5 minutes. Use this token (sent as a Bearer Token) to access all other Pesapal API 3.0 endpoints.
         * */
        'auth' => env('PESAPAL_AUTH_ENDPOINT', 'api/Auth/RequestToken'),

        /*
         * For registering the url(s) to be used for receiving IPNs from pesapal
         * It's mandatory to have IPN configured to allow Pesapal to notify your servers when a status changes. It's also important to note that this IPN URL must be publicly available. In cases where you have strict server rules preventing external systems reaching your end, you must then whitelist all calls from our domain (pesapal.com).
         * */
        'ipn-register' => env('PESAPAL_IPN_REG_ENDPOINT', 'api/URLSetup/RegisterIPN'),

        /*
         * For Listing registered IPN URLs
         * This endpoint allows you to fetch all registered IPN URLs for a particular Pesapal merchant account.
         * */
        'ipn-list' => env('PESAPAL_IPN_LIST_ENDPOINT', 'api/URLSetup/GetIpnList'),

        /*
         * Making the actual payment/order request to pesapal.
         * Call the SubmitOrderRequest and in return you will get a response which contains a payment redirect URL which you then redirect the customer to or load the URL as an iframe within your site in case you don’t want to redirect the customer off your application.
         * */
        'payment-request' => env('PESAPAL_PAYMENT_REQ_ENDPOINT', 'api/Transactions/SubmitOrderRequest'),

        /*
         * Check the status of a transaction using a given id
         * Once Pesapal redirect your customer to your callback URL and triggers your IPN URL, you need to check the status of the payment using the OrderTrackingId.
         * */
        'tsq' => env('PESAPAL_TSQ_ENDPOINT', 'api/Transactions/GetTransactionStatus'),
    ],
];
