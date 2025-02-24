<?php

namespace App\Console\Commands;

use App\Models\ETC\ExternalTransportationCompany;
use App\Repositories\ETC\ETCRepository;
use App\Repositories\Report\EtcReportRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Swift_RfcComplianceException;

class MonthlyPerformanceEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:monthly-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out a Monthly Performance Report emails to ETCs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Sending performance report emails...');
        $etcs = ExternalTransportationCompany::withoutGlobalScopes()->get();
        foreach ($etcs as $etc) {
            try {
                Mail::to(explode(',', $etc->emails))->send(
                    new \App\Mail\MonthlyPerformance(
                        (new EtcReportRepository)->getMonthlyPerformanceData($etc)
                    )
                );
            } catch (Swift_RfcComplianceException $e) {
                logger('Email not sent to:' . $etc->name . ', because not valid email(s): ' . $etc->emails . PHP_EOL);
            }
        }
        $this->comment('All performance report emails are sent.');
    }
}
