<?php

namespace Tests\Feature\Location;

use App\Models\Event\Driver;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class DriverTest extends ApiTestBase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @group driver
     */
    public function testWeCanGetEtcBid()
    {
        $response = $this->getJsonRequest(route('etcs.bid', ['hash' => $this->createDriverBid()->hash]));
        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    /**
     * @group driver
     */
    public function testWeCantGetEtcBidWithBadHash()
    {
        $response = $this->getJsonRequest(route('etcs.bid', ['hash' =>$this->createDriverBid()->hash . 'wrong']));
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group driver
     */
    public function testETCCanDeclineBid()
    {
        $driver = $this->createDriverBid();
        $response = $this->putJsonRequest(route('etcs.updatebid', ['driver' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'hash' => $driver->hash,
                    'status' => 'declined',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame('declined', $jsonData['data']['attributes']['status']);
    }

    /**
     * @group driver
     */
    public function testETCCantSetBidToAccepted()
    {
        $driver = $this->createDriverBid();
        $response = $this->putJsonRequest(route('etcs.updatebid', ['driver' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'hash' => $driver->hash,
                    'status' => 'accepted',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group driver
     */
    public function testETCCanSubmitBid()
    {
        $driver = $this->createDriverBid();
        $response = $this->putJsonRequest(route('etcs.updatebid', ['driver' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'hash' => $driver->hash,
                    'status' => 'submitted',
                    'pickup_time' => '08:15:00',
                    'fee' => '8.5',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame('submitted', $jsonData['data']['attributes']['status']);
        $this->assertSame('08:15:00', $jsonData['data']['attributes']['pickup_time']);
        $this->assertSame('8.5', $jsonData['data']['attributes']['fee']);
    }

    /**
     * @group driver
     */
    public function testETCCantModifySubmittedBid()
    {
        $driver = $this->createDriverBid(['status' => 'declined']);
        $response = $this->putJsonRequest(route('etcs.updatebid', ['driver' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'hash' => $driver->hash,
                    'status' => 'accepted',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        $driver = $this->createDriverBid(['status' => 'declined']);
        $response = $this->putJsonRequest(route('etcs.updatebid', ['driver' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'hash' => $driver->hash,
                    'status' => 'accepted',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        $driver = $this->createDriverBid(['status' => 'submitted']);
        $response = $this->putJsonRequest(route('etcs.updatebid', ['driver_id' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'hash' => $driver->hash,
                    'status' => 'submitted',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @group driver
     */
    public function testWeCanUpdateDriverFeeWithAcceptedDriver()
    {
        $this->login();
        $driver = Driver::withoutGlobalScopes()->where('status', 'accepted')->first();
        $initialFee = $driver->fee;

        $response = $this->putJsonRequest(route('bidding.update-fee', ['driver_id' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'fee' => 15.5,
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $updatedDriver = Driver::find($driver->id);

        $this->assertNotEquals((float)$initialFee, (float)$updatedDriver->fee);
        $this->assertSame(15.5, (float)$updatedDriver->fee);
    }

    /**
     * @group driver
     */
    public function testWeCantUpdateDriverFeeWithNotAcceptedDriver()
    {
        $this->login();
        $driver = Driver::withoutGlobalScopes()->where('status', '!=', 'accepted')->first();

        $response = $this->putJsonRequest(route('bidding.update-fee', ['driver_id' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'fee' => 15.5,
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group driver
     */
    public function testWeCantUpdateDriverFeeWithWrongFeeFormat()
    {
        $this->login();
        $driver = Driver::withoutGlobalScopes()->where('status', 'accepted')->first();

        $response = $this->putJsonRequest(route('bidding.update-fee', ['driver_id' => $driver->id]), [
            'data' => [
                'type' => 'drivers',
                'attributes' => [
                    'fee' => '15,5',
                ],
            ]
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    protected function createDriverBid($data = [])
    {
        $driver = factory(Driver::class)->make($data);
        $driver->save(['unprotected' => true]);
        return $driver;
    }
}
