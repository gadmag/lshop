<?php
return [
    'app' => [
        'title' => 'Базовые настройки',
        'desc' => 'Общие настройки приложения',
        'icon' => 'glyphicon glyphicon-sunglasses',

        'fields' => [
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'app_name',
                'label' => 'Название сайта',
                'rules' => 'required|min:2|max:50',
                'class' => '',
                'value' => config('app.name')
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'app_email',
                'label' => 'Email сайта',
                'rules' => 'required|email',
                'class' => '',
                'value' => env('ADMIN_MAIL', '')
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'app_title',
                'label' => 'Заголовок',
                'rules' => 'min:2',
                'class' => '',
                'value' => '',
                'title_separated' => 'Мета-теги'
            ],
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'app_description',
                'label' => 'Мета-тег Description',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'app_keywords',
                'label' => 'Мета-тег Keywords',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
        ]
    ],
    
    'catalog' => [
        'title' => 'Каталог',
        'desc' => 'Настройки каталога',
        'icon' => 'fa fa-payment',
        'fields' => [
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'catalog_title',
                'label' => 'Заголовок',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'catalog_description',
                'label' => 'Мета-тег Description',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'catalog_keywords',
                'label' => 'Мета-тег Keywords',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
        ]
    ],
    'payment' => [
        'title' => 'Магазин',
        'desc' => '',
        'icon' => 'fa fa-payment',
        'fields' => [
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'payment_address',
                'label' => 'Адрес магазина',
                'rules' => '',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'payment_phone',
                'label' => 'Телефон',
                'rules' => '',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'min_sum',
                'label' => 'Минимальная сумма заказа',
                'rules' => 'required|numeric',
                'class' => '',
                'value' => 1000.00
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'free_shipping',
                'label' => 'Бесплатная доставка',
                'rules' => 'required|numeric',
                'class' => '',
                'value' => 10000.00
            ],

        ]
    ]
];
