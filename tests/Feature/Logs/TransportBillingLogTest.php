<?php

namespace Tests\Feature\Location;

use App\Models\Logs\TransportBillingLog;
use Illuminate\Http\Response;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class TransportBillingLogTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
        $this->facility = \App\Models\Organization\Facility::withoutGlobalScopes()->first();
        $this->login('fa@silverpine.test');
    }

    /**
     * @group transport-billing-log
     */
    public function testWeCanAddTransportBillingLog()
    {
        $logData = $this->getTransportBillingLogData();
        $response = $this->postJsonRequest(route('transport-billing-logs.store'), [
            'data' => [
                'type' => 'transport-billing-logs',
                'attributes' => $logData,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame([
            'data' => [
                'type' => 'transport-billing-logs',
                'id' => '1',
                'attributes' => $logData,
                'links' => [
                    'self' => env('APP_URL') . '/transport-billing-logs/1',
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group transport-billing-log
     */
    public function testWeCantAddTransportBillingLogToWrongUser()
    {
        $logData = $this->getTransportBillingLogData();
        $logData['user_id']++;
        $response = $this->postJsonRequest(route('transport-billing-logs.store'), [
            'data' => [
                'type' => 'transport-billing-logs',
                'attributes' => $logData,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group transport-billing-log
     */
    public function testWeCantAddTransportBillingLogToWrongFacility()
    {
        $logData = $this->getTransportBillingLogData();
        $logData['facility_id']++;
        $response = $this->postJsonRequest(route('transport-billing-logs.store'), [
            'data' => [
                'type' => 'transport-billing-logs',
                'attributes' => $logData,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group transport-billing-log
     */
    public function testListTransportBillingLog()
    {
        factory(TransportBillingLog::class, 20)->create([
            'user_id' => auth()->user()->id,
            'facility_id' => $this->facility->id
        ]);
        $response = $this->getJsonRequest(route('transport-billing-logs.index'), [
            'page' => 1,
            'facilityId' => $this->facility->id
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals(15, count($jsonData['data']));


        $response = $this->getJsonRequest(route('transport-billing-logs.index'), [
            'page' => 2,
            'facilityId' => $this->facility->id
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals(5, count($jsonData['data']));
    }

    /**
     * @group transport-billing-log
     */
    public function testWeCanPaginateTransportBillingLogList()
    {
        $perPage = (new TransportBillingLog())->getPerPage();
        $recordCount = $perPage + 3;

        // Bulk insert
        factory(TransportBillingLog::class, $recordCount)->create([
            'user_id' => auth()->user()->id,
            'facility_id' => $this->facility->id,
        ]);

        $totalPage = (int) ceil($recordCount / $perPage);

        // First page
        $this
            ->getJsonRequest(route('transport-billing-logs.index', ['facilityId' => $this->facility->id, 'page' => 1]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($perPage, 'data')
            ->assertJsonFragment([
                'pagination' => [
                    'total' => $recordCount,
                    'count' => $perPage,
                    'per_page' => $perPage,
                    'current_page' => 1,
                    'total_pages' => $totalPage,
                ],
            ], 'meta');

        // Last page
        $lastPageItemCount = $recordCount - ($totalPage - 1) * $perPage;

        $this
            ->getJsonRequest(
                route('transport-billing-logs.index', ['facilityId' => $this->facility->id, 'page' => $totalPage])
            )
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($lastPageItemCount, 'data')
            ->assertJsonFragment([
                'pagination' => [
                    'total' => $recordCount,
                    'count' => $lastPageItemCount,
                    'per_page' => $perPage,
                    'current_page' => $totalPage,
                    'total_pages' => $totalPage,
                ],
            ], 'meta');
    }

    /**
     * @group transport-billing-log
     */
    public function testWeCanGetTransportBillingLogListWithoutPaginate()
    {
        $this->markTestSkipped("This feature is not implemented");
        $perPage = (new TransportBillingLog())->getPerPage();
        $recordCount =  $perPage + 3;

        // Bulk insert
        factory(TransportBillingLog::class, $recordCount)->create();

        $this
            ->getJsonRequest(route('transport-billing-logs.index', ['facilityId' => $this->facility->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($recordCount, 'data')
            ->assertDontSee('pagination');
    }

    /**
     * @group transport-billing-log
     */
    public function testWeCanDeleteTransportBillingLog()
    {
        $log = factory(TransportBillingLog::class)->create([
            'user_id' => auth()->user()->id,
            'facility_id' => $this->facility->id
        ]);
        $response = $this->deleteJsonRequest(route('transport-billing-logs.destroy', ['id' => $log->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('transport_billing_logs', ['id' => $log->id]);
    }

    protected function getTransportBillingLogData()
    {
        return [
            'location_name' => $this->faker->name(),
            'client_name' => $this->faker->name(),
            'destination_type' => $this->faker->text(30),
            'transport_type' => 'ambulatory',
            'equipment' => 'ambulatory',
            'mileage_to_start' => 1,
            'mileage_to_end' => 10,
            'mileage_return_start' => 11,
            'mileage_return_end' => 20,
            'fee' => $this->faker->randomDigitNotNull(),
            'date' => date('Y-m-d H:i:s'),
            'user_id' => auth()->user()->id,
            'facility_id' => $this->facility->id,
        ];
    }
}
