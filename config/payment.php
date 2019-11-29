<?php

return [

    'min_sum' => 1000.00,
    'free_shipping' => 10000.00,

    'send_mail' => env('ADMIN_MAIL', ''),
    'recaptcha_key' => env('GOOGLE_RECAPTCHA_KEY', ''),
    'recaptcha_secret' => env('GOOGLE_RECAPTCHA_SECRET', '')
];