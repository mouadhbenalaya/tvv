<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Application\Services\DatabaseSeederService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly DatabaseSeederService $databaseSeederService,
    ) {
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $moduleSeeders = $this->databaseSeederService->loadModuleSeeders();

        $this->call(array_merge([
            UserTypeSeeder::class,
            PermissionsSeeder::class,
            RoleSeeder::class,
            CountrySeeder::class,
            RegionSeeder::class,
            CitySeeder::class,
            TmpUserSeeder::class,
            UserSeeder::class,
        ], $moduleSeeders));
    }
}
