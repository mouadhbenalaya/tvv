<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthCheck
{
    public function __invoke(): JsonResponse
    {
        $code = Response::HTTP_OK;
        $data = [
            'application_name' => env('APP_NAME'),
            'application_health' => 'up',
            'database_health' => 'up',
            'environment' => \App::environment(),
            'php_version' => PHP_VERSION
        ];

        # database
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $data['database_health'] = 'down';
        }

        #php
        if ($data['php_version'] < 8.3) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $data['php_version'] .= ' (at least 8.3 is needed)';
        }

        # composer
        $composer = (string) exec('composer --version');
        $data['composer_version'] = str_replace('Composer version ', '', $composer);

        return new JsonResponse($data, $code);
    }
}
