<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Config;
use Illuminate\Console\Command;
use App\Models\Event\Event;

class UpcomingEventEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:upcoming-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out Upcoming Event emails to Client Responsible Parties';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Sending upcoming event emails...');

        Config::set('auth.defaults.scopes', 'disabled');

        $dayAfterTomorrow = date('Y-m-d', strtotime('now + 2 day'));
        $lastSentLimit = date('Y-m-d H:i:s', strtotime('now - 1 day'));
        $events = Event::whereRaw("`date` <= '{$dayAfterTomorrow}'")
            ->whereNull('upcoming_email_sent_at')
            ->whereOr('upcoming_email_sent_at', '<', $lastSentLimit)
            ->get();

        foreach ($events as $event) {
            // Both facility and organization is not deleted and event is upcoming
            if ($event->facility && $event->facility->organization && $nextDate = $event->isUpcoming()) {
                $event->sendEmails(\App\Mail\EventUpcoming::class, $nextDate);
                $event->upcoming_email_sent_at = date('Y-m-d H:i:s');
                $event->save(['unprotected' => true]);
            }
        }

        $this->comment('All upcoming event emails are sent.');
    }
}
