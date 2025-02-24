<?php

namespace Tests\Feature\User;

use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use App\Models\Color;
use App\Models\Policy;
use App\Models\Organization\Organization;
use App\Models\Organization\Facility;

class PolicyTest extends ApiTestBase
{
    /**
     * Data provider for updating policies
     */
    public function updateProvider()
    {
        $provider = include 'policyProviders/updateProvider.php';
        return $provider();
    }

    /**
     * @group policy
     * @dataProvider updateProvider
     */
    public function testModifyPolicy($authEmail, $facilityId, $responseStatus)
    {
        $this->login($authEmail);

        $facility = \App\Models\Organization\Facility::withoutGlobalScopes()->find($facilityId);
        $policy = $facility->policies()->withoutGlobalScopes()->first();
        $response = $this->putJsonRequest(
            route('policies.update', ['id' => $policy->id]),
            [
                'data' => [
                    'type' => 'policy',
                    'attributes' => [
                        'view' => 1,
                        'create' => 1,
                        'update' => 1,
                        'delete' => 1,
                    ]
                ]
            ]
        );

        $response->assertStatus($responseStatus);

        if ($responseStatus == JsonResponse::HTTP_OK) {
            $attributes = $response->decodeResponseJson()['data']['attributes'];
            $this->assertSame($facilityId, $attributes['facility_id']);
            $this->assertSame(1, $attributes['view']);
            $this->assertSame(1, $attributes['create']);
            $this->assertSame(1, $attributes['update']);
            $this->assertSame(1, $attributes['delete']);
        }
    }

    /**
     * @group policy
     */
    public function testPolicyClassNameCannotBeChanged()
    {
        $this->login('oa@silverpine.test');
        $policy = \App\Models\Organization\Facility::first()->policies()->first();

        $response = $this->putJsonRequest(route('policies.update', ['id' => $policy->id]), [
            'data' => [
                'type' => 'policy',
                'attributes' => [
                    'class_name' => 'App\\Models\\User',
                    'view' => 1,
                    'create' => 1,
                    'update' => 1,
                    'delete' => 1,
                ],
            ]
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Data provider for listing policies
     */
    public function listProvider()
    {
        $provider = include 'policyProviders/listProvider.php';
        return $provider();
    }

    /**
     * @group policy
     * @dataProvider listProvider
     */
    public function testPoliciesCanBeListed($authEmail, $count)
    {
        $this->login($authEmail);

        $response = $this->getJsonRequest(route('policies.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($count, count($jsonData['data']));
    }

    /**
     * @group policy
     */
    public function testPoliciesCanBeListedByRoleId()
    {
        $this->login('fa@silverpine.test');
        $response = $this->getJsonRequest(route('policies.index'), ['role_id' => config('roles')['Master User']]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSame(9, count($response->decodeResponseJson()['data']));
    }

    /**
     * @group policy
     */
    public function testPoliciesCanBeListedByFacilityId()
    {
        // log in with Silver Pine Org. Admin
        $this->login('oa@silverpine.test');
        $response = $this->getJsonRequest(route('policies.index'), ['facility_id' => 1]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSame(18, count($response->decodeResponseJson()['data']));

        // log in with Golden Years Org. Admin
        $this->login('oa@goldenyears.test');
        $response = $this->getJsonRequest(route('policies.index'), ['facility_id' => 1]);
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSame(0, count($response->decodeResponseJson()['data']));
    }
}
