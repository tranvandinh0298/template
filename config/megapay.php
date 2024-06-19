<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MGP configuration
    |--------------------------------------------------------------------------
    */
    'mer_id' => env('MGP_MER_ID'),
    'encode_key' => env('MGP_ENCODE_KEY'),
    'cancel_password' => env('MGP_CANCEL_PASSWORD'),
    'encrypt_key' => env('MGP_3DES_ENCRYPT_KEY'),
    'decrypt_key' => env('MGP_3DES_DECRYPT_KEY'),
    'domain' => env('MGP_DOMAIN'),
    'check_trans_url' => env('MGP_CHECK_TRANS_URL'),
    'cancel_trans_url' => env('MGP_CANCEL_TRANS_URL'),
    'register_dc_url' => env('MGP_REGISTER_DC_URL'),
    'window_color' => env("WINDOW_COLOR", '#03A5E3'),
];
