<?php

declare(strict_types=1);

namespace App\Application\Http\Middleware;

use App\Common\Enum\ApiStatusEnum;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function config;
use function in_array;
use function mb_strtolower;
use function preg_match;
use function str_starts_with;

class ApiVersionDeprecate
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (!$response instanceof JsonResponse) {
            return $response;
        }

        $headers = [];
        $version = $this->extractVersionFromRoute($request->path());

        if (in_array($version, config('setup.api.unsupported_versions'), true)) {
            $headers['Api-Status'] = ApiStatusEnum::UNSUPPORTED->value;
        } elseif (in_array($version, config('setup.api.sunset_versions'), true)) {
            $headers['Api-Status'] = ApiStatusEnum::SUNSET->value;
        } else {
            $headers['Api-Status'] = ApiStatusEnum::SUPPORTED->value;
        }

        $response->header('Api-Status', $headers['Api-Status']);

        return $response;
    }

    private function extractVersionFromRoute(string $route): ?string
    {
        $currentVersion = $this->getVersion($route);

        if (!str_starts_with($currentVersion, 'v')) {
            return null;
        }

        return mb_strtolower($currentVersion);
    }

    private function getVersion(string $path): mixed
    {
        preg_match('/v(\\d)/i', $path, $matches);

        return $matches[0] ?? '';
    }
}
