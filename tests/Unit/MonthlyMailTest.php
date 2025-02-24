<?php

namespace Tests\Unit;

use App\Models\ETC\ExternalTransportationCompany;
use App\Models\Event\Driver;
use App\Models\Event\Event;
use App\Repositories\Event\DriverRepository;
use App\Repositories\Report\EtcReportRepository;
use Carbon\Carbon;
use Tests\Feature\ApiTestBase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\EventTrait;
use Tests\Traits\UserTrait;

class MonthlyMailTest extends ApiTestBase
{
    use UserTrait;
    use EventTrait;

    public function setUp()
    {
        parent::setUp();
        Carbon::setTestNow('2018-06-20', 'Y-m-d');
    }

    /**
     * @group etc-performance-report
     */
    public function testWeCanGetValidMonthlyPerformanceData()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $etcs = ExternalTransportationCompany::withoutGlobalScopes()->where('facility_id', '>', $facility->id)->get();

        $etcReportRepository = new EtcReportRepository;
        $performance = $etcReportRepository->getMonthlyPerformanceData($etcs[0]);

        $this->assertSame([
            "num_of_accepted_bids" => 2,
            "num_of_received_bids" => 2,
            "total_earned_last_month" => 144.0,
            "total_earned_ytd" => 372.0,
        ], $performance);

        Carbon::setTestNow(Carbon::now()->addMonth());
        $performance = $etcReportRepository->getMonthlyPerformanceData($etcs[0]);
        $this->assertSame([
            "num_of_accepted_bids" => 2,
            "num_of_received_bids" => 2,
            "total_earned_last_month" => 368.0,
            "total_earned_ytd" => 728.0,
        ], $performance);
    }
}
