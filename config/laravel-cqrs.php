<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    'logging' => [

        'command' => [
            'channel' => [
                'driver' => 'daily',
                'path' => storage_path('logs/laravel-cqrs-command.log'),
            ],

            'stack' => [],
        ],

        'query' => [
            'channel' => [
                'driver' => 'daily',
                'path' => storage_path('logs/laravel-cqrs-query.log'),
            ],

            'stack' => [],
        ]

    ],

];
