<?php

declare(strict_types=1);

namespace App\Application\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use function env;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending of email';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emailFrom = $this->ask('Sender email ');
        $emailTo = $this->ask('Receiver email ');

        try {
            Mail::raw('Test Email Body!', static function ($msg) use ($emailFrom, $emailTo) {
                $msg->from($emailFrom)
                    ->to($emailTo)
                    ->subject(env('APP_NAME') . ' Test Email');
            });
        } catch (\Throwable $exception) {
            $this->output->error($exception->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
