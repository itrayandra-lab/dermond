<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xendit Configuration
    |--------------------------------------------------------------------------
    */

    'environment' => env('XENDIT_ENVIRONMENT', 'sandbox'),

    'secret_key' => env('XENDIT_SECRET_KEY'),
    'public_key' => env('XENDIT_PUBLIC_KEY'),
    'webhook_token' => env('XENDIT_WEBHOOK_TOKEN'),

    'api_url' => env('XENDIT_ENVIRONMENT', 'sandbox') === 'production'
        ? 'https://api.xendit.co'
        : 'https://api.xendit.co',

    /*
    |--------------------------------------------------------------------------
    | Invoice Settings
    |--------------------------------------------------------------------------
    */

    'invoice' => [
        // Duration in seconds (default 24 hours)
        'duration' => env('XENDIT_INVOICE_DURATION', 86400),

        // Available payment methods
        'payment_methods' => [
            'BCA',
            'BNI',
            'BRI',
            'MANDIRI',
            'PERMATA',
            'ALFAMART',
            'INDOMARET',
            'OVO',
            'DANA',
            'SHOPEEPAY',
            'LINKAJA',
            'QRIS',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Callback URLs
    |--------------------------------------------------------------------------
    */

    'success_redirect_url' => env('XENDIT_SUCCESS_URL'),
    'failure_redirect_url' => env('XENDIT_FAILURE_URL'),
];
