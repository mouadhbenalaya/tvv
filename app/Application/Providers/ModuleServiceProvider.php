<?php

declare(strict_types=1);

namespace App\Application\Providers;

use App\Application\Contracts\ModuleInterface;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /** @var array $folders */
        $folders = scandir(base_path('modules'));
        $entries = array_values(array_diff($folders, ['.', '..', '.gitignore']));

        foreach ($entries as $entry) {

            $class = sprintf('Module\\%s\\Module', $entry);

            if (!class_exists($class)) {
                continue;
            }

            $module = new $class();
            if (!$module instanceof ModuleInterface) {
                throw new RuntimeException('Module must be an instance of ModuleInterface.');
            }

            foreach ($module->getProviders() as $provider) {
                app()->register($provider);
            }
        }

    }

}
