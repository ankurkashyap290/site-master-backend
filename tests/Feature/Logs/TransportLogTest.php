<?php

namespace Tests\Feature\Location;

use App\Models\Logs\TransportLog;
use Illuminate\Http\Response;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Tests\Traits\UserTrait;

class TransportLogTest extends ApiTestBase
{
    public function createProvider()
    {
        $provider = include 'logProviders/createProvider.php';
        return $provider();
    }

    /**
     * @group transport-log
     * @dataProvider createProvider
     */
    public function testWeCanAddTransportLog($authEmail, $facilityId, $responseStatus)
    {
        $this->login($authEmail);

        $logData = $this->getTransportLogData($facilityId);
        $response = $this->postJsonRequest(route('transport-logs.store'), [
            'data' => [
                'type' => 'transport-logs',
                'attributes' => $logData,
            ]
        ]);
        $response->assertStatus($responseStatus);

        if ($responseStatus === JsonResponse::HTTP_CREATED) {
            $jsonData = $response->decodeResponseJson();
            $this->assertSame([
                'data' => [
                    'type' => 'transport-logs',
                    'id' => '1',
                    'attributes' => $logData,
                    'links' => [
                        'self' => env('APP_URL') . '/transport-logs/1',
                    ],
                ],
            ], $jsonData);
        }
    }

    /**
     * @group transport-log
     */
    public function testWeCantAddTransportLogToWrongUser()
    {
        $this->login('fa@silverpine.test');
        $logData = $this->getTransportLogData(auth()->user()->facility->id);
        $logData['user_id']++;
        $response = $this->postJsonRequest(route('transport-logs.store'), [
            'data' => [
                'type' => 'transport-logs',
                'attributes' => $logData,
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group transport-log
     */
    public function testListTransportLog()
    {
        $this->login('fa@silverpine.test');
        $user = auth()->user();

        factory(TransportLog::class, 20)->create([
            'user_id' => $user->id,
            'facility_id' => $user->facility->id
        ]);
        $response = $this->getJsonRequest(route('transport-logs.index'), [
            'page' => 1,
            'facilityId' => $user->facility->id
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals(15, count($jsonData['data']));

        $response = $this->getJsonRequest(route('transport-logs.index'), [
            'page' => 2,
            'facilityId' => $user->facility->id
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals(5, count($jsonData['data']));
    }

    /**
     * @group transport-log
     */
    public function testWeCanPaginateTransportLogList()
    {
        $this->login("fa@silverpine.test");
        $user = auth()->user();
        $perPage = (new TransportLog())->getPerPage();
        $recordCount = $perPage + 3;

        // Bulk insert
        factory(TransportLog::class, $recordCount)->create([
            'user_id' => $user->id,
            'facility_id' => $user->facility->id,
        ]);

        $totalPage = (int) ceil($recordCount / $perPage);

        // First page
        $this
            ->getJsonRequest(route('transport-logs.index', ['facilityId' => $user->facility->id, 'page' => 1]))
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
                route('transport-logs.index', ['facilityId' => $user->facility->id, 'page' => $totalPage])
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
     * @group transport-log
     */
    public function testWeCanGetTransportLogListWithoutPaginate()
    {
        $this->markTestSkipped("This feature is not implemented");
        $this->login('fa@silverpine.test');
        $user = auth()->user();
        $perPage = (new TransportLog())->getPerPage();
        $recordCount =  $perPage + 3;

        // Bulk insert
        factory(TransportLog::class, $recordCount)->create([
            'user_id' => $user->id,
            'facility_id' => $user->facility->id,
        ]);

        $this
            ->getJsonRequest(route('transport-logs.index', ['facilityId' => $user->facility->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($recordCount, 'data')
            ->assertDontSee('pagination');
    }

    public function deleteProvider()
    {
        $provider = include 'logProviders/deleteProvider.php';
        return $provider();
    }

    /**
     * @group transport-log
     * @dataProvider deleteProvider
     */
    public function testWeCanDeleteTransportLog($authEmail, $facilityId, $responseStatus)
    {
        $this->login($authEmail);

        $log = factory(TransportLog::class)->make([
            'user_id' => auth()->user()->id,
            'facility_id' => $facilityId
        ]);
        $log->save(['unprotected' => true]);

        $response = $this->deleteJsonRequest(route('transport-logs.destroy', ['id' => $log->id]));
        $response->assertStatus($responseStatus);
        if ($responseStatus === JsonResponse::HTTP_OK) {
            $this->assertSoftDeleted('transport_logs', ['id' => $log->id]);
        }
    }

    protected function getTransportLogData($facilityId)
    {
        return [
            'location_name' => $this->faker->name(),
            'client_name' => $this->faker->name(),
            'equipment' => 'ambulatory',
            'equipment_secured' => 1,
            'signature' => $this->faker->name(),
            'date' => date('Y-m-d H:i:s'),
            'user_id' => auth()->user()->id,
            'facility_id' => $facilityId,
        ];
    }
}
