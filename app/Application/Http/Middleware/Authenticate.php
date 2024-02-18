<?php

declare(strict_types=1);

namespace App\Application\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use function __;
use function abort;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return abort(403, __('auth.only_programs'));
        }
    }
}
