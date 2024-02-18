<?php

namespace App\Application\Services;

class DatabaseSeederService
{
    public function loadModuleSeeders(): array
    {
        $classes = [];

        /** @var array $moduleFolders */
        $moduleFolders = scandir(app_path('../modules'));
        $modules = array_values(array_diff($moduleFolders, ['.', '..', '.gitignore']));

        foreach ($modules as $module) {
            $className = sprintf('Module\\%s\\Common\\Database\\Seeders\\DatabaseSeeder', $module);
            if (class_exists($className)) {
                $instance = app($className);

                foreach ($instance->getSeeders() as $seeder) {
                    $classes[] = $seeder;
                }
            }
        }

        return $classes;
    }
}
