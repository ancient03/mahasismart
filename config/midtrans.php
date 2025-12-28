<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', null),
    'client_key' => env('MIDTRANS_CLIENT_KEY', null),
    'server_key' => env('MIDTRANS_SERVER_KEY', null),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
