<?php

define('SPID', env('SPID'));
define('PASSWORD', env('PASSWORD'));
define('SERVICEID', env('SERVICEID'));
define('initiator_username', env('initiator_username'));
define('initiator_pass', env('initiator_pass'));
define('B2CPaybill', env('B2CPaybill'));
define('result_url', env('result_url'));
define('SSL_CERT_PATH', env('SSL_CERT_PATH'));
define('SSL_KEY_PATH', env('SSL_KEY_PATH'));
define('SSL_PASS', env('SSL_PASS'));
define('APICRYPT_PATH', env('APICRYPT_PATH'));

Route::get('leyo/mpesa/sendmoney',
    'leyo\mpesa\MpesaController@sendmoney');

