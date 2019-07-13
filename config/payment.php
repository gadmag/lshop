<?php

return [
    'payment_method' => [
        'credit_card' => ['id' => '5469600025133406 Амина Байсолтановна', 'method' => 'Банковская карта'],
        'qiwi' => ['id' => '89285109392', 'method' => 'QIWI Кошелек'],
        'yandex' => ['id' => 'c193847', 'method' => 'Яндекс Кошелек'],
        'paypal' => ['id' => 'c193847', 'method' => 'Paypal Кошелек'],
        'cash' => ['id' =>'cash', 'method' => 'Оплата при получении'],

    ],
    'shipment_method' => [
        'cdek' => [
            'method' => 'СДЭК пункт выдачи',
            '1000' => 0,
            '2000' => 0,
            '5000' => 0,
            '10000' => 0,
        ],
        'pickup' => [
            'method' => 'Самовывоз',
            '1000' => 0,
            '2000' => 0,
            '5000' => 0,
            '10000' => 0,
        ],
        'pochta_ru' => [
            'method' => 'Доставка почтой по России',
            '1000' => 250,
            '2000' => 280,
            '5000' => 380,
            '10000' => 550,
        ],
        'pochta_gl' => [
            'method' => 'Доставка почтой за пределы России',
            '1000' => 350,
            '2000' => 1050,
            '5000' => 1550,
            '10000' => 2100,
        ]
    ],
    'cart_setting' => [
        'min_sum' => 1000,
        'free_shipping' => 10000
    ],

    'send_mail' => env('ADMIN_MAIL',''),
    'recaptcha_key' => env('GOOGLE_RECAPTCHA_KEY',''),
    'recaptcha_secret' => env('GOOGLE_RECAPTCHA_SECRET','')
];