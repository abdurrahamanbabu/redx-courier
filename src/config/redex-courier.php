<?php


return [

    'api_key' => env('REDX_API_KEY', ''),
    'live_url' => env('REDX_LIVE_URL', 'https://openapi.redx.com.bd'),
    'sendbox_url' => env("REDX_SENDBOX_URL",'https://sandbox.redx.com.bd'),
    'redx_env' => env("REDX_ENV","SENDBOX"),
    'timeout' => 30,

];