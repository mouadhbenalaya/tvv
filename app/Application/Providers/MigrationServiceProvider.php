<?php

namespace App\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /** @var array $moduleFolders */
        $moduleFolders = scandir(app_path('../modules'));
        $modules = array_values(array_diff($moduleFolders, ['.', '..', '.gitignore']));

        foreach ($modules as $module) {
            $fileName = sprintf(app_path('../modules/%s/Common/Database/Migrations'), $module);
            if (file_exists($fileName)) {
                $this->loadMigrationsFrom($fileName);
            }
        }
    }
}
