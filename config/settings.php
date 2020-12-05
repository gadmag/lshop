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
                'class' => 'w-auto px-2',
                'value' => config('app.name')
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'app_email',
                'label' => 'Email сайта',
                'rules' => 'required|email',
                'class' => 'w-auto px-2',
                'value' => env('ADMIN_MAIL', '')
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'app_phone',
                'label' => 'Телефон',
                'rules' => '',
                'class' => 'w-auto px-2',
                'value' => ''
            ],
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'app_address',
                'label' => 'Адрес магазина',
                'rules' => '',
                'class' => 'w-auto px-2',
                'value' => ''
            ]
        ]
    ],

    'meta_tag' => [
        'title' => 'Мета-теги',
        'desc' => '',
        'icon' => 'glyphicon glyphicon-sunglasses',
        'fields' => [
            [
                'type' => 'text',
                'data' => 'string',
                'name' => 'meta_title',
                'label' => 'Заголовок',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'meta_description',
                'label' => 'Description',
                'rules' => 'min:2',
                'class' => '',
                'value' => ''
            ],
            [
                'type' => 'textarea',
                'data' => 'string',
                'name' => 'meta_keywords',
                'label' => 'Keywords',
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

        ]
    ],
    'payment' => [
        'title' => 'Магазин',
        'desc' => '',
        'icon' => 'fa fa-payment',
        'fields' => [

        ]
    ]
];
