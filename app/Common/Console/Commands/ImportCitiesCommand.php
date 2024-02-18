<?php

declare(strict_types=1);

namespace App\Common\Console\Commands;

use App\Common\Models\City;
use App\Common\Models\Region;
use App\Common\Services\CsvService;
use Illuminate\Console\Command;

class ImportCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for import cities';

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
            foreach ($this->csvService->load(storage_path('app/files/cities.csv')) as $city) {
                if ($region = Region::where('code', $city['region_code'])->first()) {
                    City::create([
                        'code' => $city['code'],
                        'name' => $city['name'],
                        'region_id' => $region->id,
                    ]);
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
