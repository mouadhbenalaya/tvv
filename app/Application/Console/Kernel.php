<?php

declare(strict_types=1);

namespace App\Application\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use function base_path;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(app_path('Common/Console/Commands'));
        $this->load(app_path('Domain/Users/Console/Commands'));

        /** @var array $moduleFolders */
        $moduleFolders = scandir(app_path('../modules'));
        $modules = array_values(array_diff($moduleFolders, ['.', '..', '.gitignore']));

        foreach ($modules as $module) {
            $fileName = sprintf(app_path('../modules/%s/Common/Console/Commands'), $module);
            if (file_exists($fileName)) {
                $this->load($fileName);
            }
        }

        require base_path('routes/console.php');
    }
}
