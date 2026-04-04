<?php

return [
    'driver' => env('PAYMENTS_DRIVER', 'paystack'), // paystack|flutterwave

    'paystack' => [
        'secret'     => env('PAYSTACK_SECRET_KEY'),
        'public'     => env('PAYSTACK_PUBLIC_KEY'),
        'base_url'   => env('PAYSTACK_BASE_URL', 'https://api.paystack.co'),
        'callback'   => env('PAYSTACK_CALLBACK_URL'),
    ],

    'flutterwave' => [
        'secret'     => env('FLW_SECRET_KEY'),
        'public'     => env('FLW_PUBLIC_KEY'),
        'encryption' => env('FLW_ENCRYPTION_KEY'),
        'base_url'   => env('FLW_BASE_URL', 'https://api.flutterwave.com/v3'),
        'callback'   => env('FLW_CALLBACK_URL'),
        'hash'       => env('FLW_HASH'), // webhook verification hash header "verif-hash"
    ],

    'currency' => env('BILLING_CURRENCY', 'NGN'),
];
