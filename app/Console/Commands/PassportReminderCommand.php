<?php

namespace App\Console\Commands;

use App\Jobs\PassportReminderJob;
use App\Models\Client;
use Illuminate\Console\Command;

class PassportReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:passport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder to clients without passport photographs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Client::whereNull('passport')
            ->whereRaw('DATEDIFF(created_at, NOW()) % 3 = 0')
            ->chunk(20, function ($client) {
                PassportReminderJob::dispatch($client);
            });
    }
}
