<?php

declare(strict_types=1);

namespace App\Common\Console\Commands;

use App\Common\Models\Region;
use App\Common\Services\CsvService;
use Illuminate\Console\Command;

class ImportRegionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for import regions';

    /**
     * Create a new command instance.
     */
    public function __construct(
        private readonly CsvService $csvService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            foreach ($this->csvService->load(storage_path('app/files/regions.csv')) as $region) {
                Region::create([
                    'code' => $region['code'],
                    'name' => $region['name'],
                ]);
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
