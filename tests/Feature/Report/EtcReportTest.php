<?php

namespace Tests\Feature\Location;

use App\Console\Commands\MonthlyPerformanceEmail;
use App\Mail\MonthlyPerformance;
use App\Models\ETC\ExternalTransportationCompany;
use App\Models\Event\Driver;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Tests\Traits\EventTrait;
use Tests\Traits\UserTrait;

class EtcReportTest extends ApiTestBase
{
    use UserTrait, EventTrait;

    public function setUp()
    {
        Carbon::setTestNow(Carbon::createFromFormat('Y-m-d H:i:s', '2018-05-20 12:00:00'));
        parent::setUp();
    }

    /**
     * @group etc-report
     */
    public function testEtcReport()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $this->login($upperManagement->email);

        $facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $etc = $facility->externalTransportationCompanies[0];

        $pastEvent = $facility->events[0];
        $pastEvent->date = Carbon::yesterday()->format('Y-m-d');
        $pastEvent->save();

        $futureEvent1 = $facility->events[1];
        $futureEvent1->date = Carbon::today()->format('Y-m-d');
        $futureEvent1->save();

        $futureEvent2 = $facility->events[2];
        $futureEvent2->date = Carbon::tomorrow()->format('Y-m-d');
        $futureEvent2->save();

        $response = $this->getJsonRequest(route('etc-reports.index'));
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(4, $jsonData['data']);
        foreach ($jsonData['data'] as $row) {
            if ($etc->id == $row['id']) {
                $this->assertEquals($etc->name, $row['attributes']['name']);
                $this->assertEquals(8, $row['attributes']['ytd']['cost']);
                $this->assertEquals(2, $row['attributes']['ytd']['passengers']);
                $this->assertEquals(8, $row['attributes']['mtd']['cost']);
                $this->assertEquals(2, $row['attributes']['mtd']['passengers']);
                $this->assertEquals(144, $row['attributes']['projected']['cost']);
                $this->assertEquals(24, $row['attributes']['projected']['passengers']);
            }
        }
        foreach ($organizationTree['organizationOne']['facilities'][0]['users'] as $user) {
            $this->login($user->email);
            $response = $this->getJsonRequest(route('etc-reports.index'));
            if ($user->role_id === 6) {
                $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
                continue;
            }
            $response->assertStatus(JsonResponse::HTTP_OK);
        }
    }

    /**
     * @group etc-report
     */
    public function testEtcDrilldown()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $this->login($upperManagement->email);

        $facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $etc = $facility->externalTransportationCompanies[0];

        $response = $this->getJsonRequest(route('etc-reports.show', ['id' => $etc->id]));
        $jsonData = $response->decodeResponseJson();

        $this->assertCount(19, $jsonData['data']['attributes']['ytd']);
        $this->assertCount(19, $jsonData['data']['attributes']['mtd']);
        $this->assertCount(12, $jsonData['data']['attributes']['projected']);
        $this->assertCount(2, $jsonData['data']['attributes']['projected']['2018-05-23']);
    }

    /**
     * @group etc-report
     */
    public function testWeCanSendEmails()
    {
        Mail::fake();
        $etcs = ExternalTransportationCompany::withoutGlobalScopes()->get();
        $this->artisan('mail:monthly-performance');

        foreach ($etcs as $etc) {
            Mail::assertSent(MonthlyPerformance::class, function ($mail) use ($etc) {
                return $mail->hasTo(explode(',', $etc->emails));
            });
        }
    }

    /**
     * @group etc-report
     */
    public function testEtcDailyView()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $this->login($upperManagement->email);
        $etc = $facility->externalTransportationCompanies[0];

        for ($i = 10; $i < 30; $i++) {
            $response = $this->getJsonRequest(route('etc-reports.daily-view', [
                'id' => $etc->id,
                'date' => Carbon::now()->format("Y-m-${i}")
            ]));
            $jsonData = $response->decodeResponseJson();
            if ($i === 23) {
                $this->assertCount(2, $jsonData['data']);
                continue;
            }
            $this->assertCount(1, $jsonData['data']);
        }
    }
}
