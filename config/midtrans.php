<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G408686813'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'Mid-client-e6pBsf4_nYQW2b2n'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'Mid-server-eLD7E4GY_Zwm583unqF_S5lr'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
