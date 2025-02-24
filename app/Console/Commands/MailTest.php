<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out a test email to appdesign.journey@gmail.com';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Sending email...');
        Mail::to('appdesign.journey@gmail.com')->send(new \App\Mail\Test());
        $this->info('Mail sent to appdesign.journey@gmail.com!');
    }
}
