<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    'logging' => [

        'channel' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel-cqrs.log'),
        ],

        'stack' => [],

    ],

];
