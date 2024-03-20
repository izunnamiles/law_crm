<?php

namespace App\Jobs;

use App\Notifications\PassportReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class PassportReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $clients
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->clients as $client) {
            Notification::route('mail', $client->email)->notify(new PassportReminderNotification($client));
        }
    }
}
