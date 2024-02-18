<?php

declare(strict_types=1);

namespace App\Application\Http\Middleware;

use App\Application\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use function redirect;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @param string|null ...$guards
     *
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$guards): Response|RedirectResponse|JsonResponse
    {
        $guards = empty($guards) ? [] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
