<?php

return [

    'defaults' => [
        'guard' => 'usuarios',
        'passwords' => 'usuarios'
    ],

    'guards' => [
        'usuarios' => [
            'driver' => 'jwt',
            'provider' => 'usuarios'
        ],
        'duenos' => [
            'driver' => 'jwt',
            'provider' => 'duenos'
        ]
    ],

    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class
        ],
        'duenos' => [
            'driver' => 'eloquent',
            'model' => App\Models\Dueno::class
        ]
    ],

    'password_timeout' => 10800

];
