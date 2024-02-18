<?php

declare(strict_types=1);

namespace App\Common\Console\Commands;

use App\Common\Models\Country;
use App\Common\Services\CsvService;
use Illuminate\Console\Command;

class ImportCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for import countries';

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
     */
    public function handle(): int
    {

        $this->info('Importing countries...');

        try {
            foreach ($this->csvService->load(storage_path('app/files/countries.csv')) as $country) {
                Country::firstOrCreate(
                    ['name' =>  $country['Country Name English']],
                    [
                        'code_alpha_2' => $country['Country Code Alpha-2'],
                        'code_alpha_3' => $country['Country Code Alpha-3'],
                        'code_numeric' => $country['Country Code Numeric'],
                        'name' => $country['Country Name English'],
                    ]
                );
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }

        $this->info('Done');

        return Command::SUCCESS;
    }
}
