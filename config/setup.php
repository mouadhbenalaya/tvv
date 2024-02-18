<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Project setup variables
    |--------------------------------------------------------------------------
    |
    | This file is for storing the needed project setup variables
    | like FRONTEND_URL, PAGINATION_PER_PAGE across the platform,
    | and ANY OTHER ENV variable that has no place in other config
    | files.
    |
    */

    'frontend' => [
        'url' => \env('FRONTEND_URL', 'http://frontend.com'),
    ],

    'api' => [
        'unsupported_versions' => \explode(',', \env('API_UNSUPPORTED_VERSIONS')),
        'sunset_versions' => \explode(',', \env('API_SUNSET_VERSIONS')),
        'last_version' => \env('API_LAST_VERSION', 'v2'),
    ],
];
