<?php

namespace Tests\Feature\Location;

use App\Models\Logs\TransportBillingLog;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Tests\Traits\EventTrait;
use Tests\Traits\UserTrait;

class FacilityReportTest extends ApiTestBase
{
    use UserTrait, EventTrait;

    public function setUp()
    {
        Carbon::setTestNow(Carbon::createFromFormat('Y-m-d H:i:s', '2018-05-20 12:00:00'));
        parent::setUp();
    }

    /**
     * @group facility-report
     */
    public function testFacilityReport()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $this->facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $this->login($upperManagement->email);
        $this->facility = $organizationTree['organizationOne']['facilities'][1]['facility'];
        $response = $this->getJsonRequest(route('facility-reports.index'));
        $jsonData = $response->decodeResponseJson();
        foreach ($jsonData['data'] as $facility) {
            $this->assertEquals(228, $facility['attributes']['mtd']['cost']);
            $this->assertEquals(38, $facility['attributes']['mtd']['passengers']);

            $this->assertEquals(152, $facility['attributes']['projected']['cost']);
            $this->assertEquals(26, $facility['attributes']['projected']['passengers']);
        }
        foreach ($organizationTree['organizationOne']['facilities'][0]['users'] as $user) {
            $this->login($user->email);
            $response = $this->getJsonRequest(route('facility-reports.index'));
            if ($user->role_id === 6) {
                $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
                continue;
            }
            $response->assertStatus(JsonResponse::HTTP_OK);
            $jsonData = $response->decodeResponseJson();
            $this->assertCount(1, $jsonData['data']);
        }
    }

    /**
     * @group facility-report
     */
    public function testFacilityReportYTD()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $this->facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $this->login($upperManagement->email);
        $this->facility = $organizationTree['organizationOne']['facilities'][1]['facility'];
        $response = $this->getJsonRequest(route('facility-reports.index'));
        $jsonData = $response->decodeResponseJson();
        foreach ($jsonData['data'] as $facility) {
            $this->assertEquals(360, $facility['attributes']['ytd']['cost']);
            $this->assertEquals(60, $facility['attributes']['ytd']['passengers']);
        }
    }

    /**
     * @group facility-report
     */
    public function testFacilityDrilldown()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $this->facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $this->login($upperManagement->email);
        $this->facility = $organizationTree['organizationOne']['facilities'][1]['facility'];
        $response = $this->getJsonRequest(route('facility-reports.show', ['id' => $this->facility->id]));
        $jsonData = $response->decodeResponseJson();
        $this->assertCount(30, $jsonData['data']['attributes']['ytd']);
        $this->assertCount(19, $jsonData['data']['attributes']['mtd']);
        $this->assertCount(12, $jsonData['data']['attributes']['projected']);
        $this->assertCount(2, $jsonData['data']['attributes']['projected']['2018-05-23']);
    }

    /**
     * @group facility-report
     */
    public function testFacilityDailyView()
    {
        $organizationTree = $this->createOrganizationTree();
        $this->createTestEvents($organizationTree);
        $upperManagement = $organizationTree['organizationOne']['users'][1];
        $this->facility = $organizationTree['organizationOne']['facilities'][0]['facility'];
        $this->login($upperManagement->email);
        $this->facility = $organizationTree['organizationOne']['facilities'][1]['facility'];
        for ($i = 10; $i < 30; $i++) {
            $response = $this->getJsonRequest(route('facility-reports.daily-view', [
                'id' => $this->facility->id,
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
