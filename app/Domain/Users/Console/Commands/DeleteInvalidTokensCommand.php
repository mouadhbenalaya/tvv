<?php

declare(strict_types=1);

namespace App\Domain\Users\Console\Commands;

use App\Domain\Users\Models\TmpUser;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteInvalidTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tokens:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete registration tokens after 24 hours';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $tmpUsers = TmpUser::all();
        foreach ($tmpUsers as $tmpUser) {
            $expired = $tmpUser->updated_at->diffInSeconds(Carbon::now()) > 86400;
            if ($expired) {
                $tmpUser->delete();
            }
        }

        return Command::SUCCESS;
    }
}
