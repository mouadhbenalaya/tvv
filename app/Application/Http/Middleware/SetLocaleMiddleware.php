<?php

namespace App\Application\Http\Middleware;

use App\Domain\Users\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Set the locale based on the user.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var ?User $user */
        $user = auth()->user();

        // TODO: Uncomment this when the user is ready to be localized.
        /** @var string $locale */
        //        $locale = match ($user) {
        //            null => $request->query->get('locale'),
        //            default => $user->locale,
        //        } ?? 'ar';

        // TODO: Remove this when the user is ready to be localized.
        $locale = $request->query->get('locale') ?? 'ar';

        \App::setLocale($locale);

        return $next($request);
    }
}
