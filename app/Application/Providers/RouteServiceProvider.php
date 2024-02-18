<?php

namespace App\Application\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        /** @var array $folders */
        $folders = scandir(app_path('Domain'));
        $domains = array_values(array_diff($folders, ['.', '..']));

        /** @var array $moduleFolders */
        $moduleFolders = scandir(app_path('../modules'));
        $modules = array_values(array_diff($moduleFolders, ['.', '..', '.gitignore']));

        $this->routes(function () use ($domains, $modules) {

            // application layer routes
            Route::middleware('web')
                ->group(function () {
                    require app_path('Application/Routes/web.php');
                });

            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(function () {
                    require app_path('Common/Routes/api.php');
                });

            // domain layer routes
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(function () use ($domains) {

                    foreach ($domains as $domain) {

                        $filename = app_path(sprintf('Domain/%s/Routes/api.php', $domain));
                        if (file_exists($filename)) {
                            require $filename;
                        }
                    }
                });

            foreach ($modules as $module) {
                // module domain layer routes
                Route::middleware('api')
                    ->prefix('api/v1')
                    ->name(sprintf('api.v1.%s.', Str::snake($module, '.')))
                    ->group(function () use ($module) {
                        $filename = app_path(sprintf('../modules/%s/Common/Routes/api.php', $module));
                        if (file_exists($filename)) {
                            require $filename;
                        }
                    });
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        foreach (['api', 'web'] as $name) {
            RateLimiter::for($name, function (Request $request) {
                return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
            });
        }

        RateLimiter::for('hard', function (Request $request) {
            return Limit::perMinute(2)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
