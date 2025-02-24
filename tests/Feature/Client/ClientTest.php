<?php

namespace Tests\Feature\Client;

use App\Http\Requests\Request;
use App\Models\Client\Client;
use App\Models\Organization\Facility;
use App\Models\Organization\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\ApiTestBase;
use Tests\Traits\UserTrait;

class ClientTest extends ApiTestBase
{
    use UserTrait;
    protected $facility;

    public function setUp()
    {
        parent::setUp();
        $this->facility = factory(Facility::class)->make();
        $this->facility->save(['unprotected' => true]);
        $user = $this->createTestUser(4, 1, $this->facility->id);
        $this->login($user->email);
    }
    /**
     * @group clients
     */
    public function testWeCanCreateClient()
    {
        $firstName = $this->faker->firstName;
        $middleName = '';
        $lastName = $this->faker->lastName;
        $respPartyEmail = $this->faker->email;
        $response = $this->postJsonRequest(
            route('clients.store'),
            [
                'data' => [
                    'type' => 'client',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'room_number' => 'A302',
                        'responsible_party_email' => $respPartyEmail,
                        'facility_id' => $this->facility->id,
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $jsonData = $response->decodeResponseJson();

        $clientId = (string)$jsonData['data']['id'];

        $this->assertSame([
            'data' => [
                'type' => 'clients',
                'id' => $clientId,
                'attributes' => [
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'room_number' => 'A302',
                    'responsible_party_email' => $respPartyEmail,
                    'facility_id' => $this->facility->id,
                    'transport_status' => 'off',
                    'ongoing_event' => null,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/clients/' . $clientId,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group clients
     */
    public function testWeCanSortClientList()
    {
        $this->login('oa@silverpine.test');

        $testClients = [
            [
                'first_name' => 'Jane',
                'room_number' => 'A51',
                'responsible_party_email' => 'jane.doe.cousin@example.com',
            ],
            [
                'first_name' => 'John',
                'room_number' => 'A52',
                'responsible_party_email' => 'john.doe.cousin@example.com',
            ],
        ];

        foreach ($testClients as $testClient) {
            factory(Client::class)
                ->create($testClient + [
                    'facility_id' => 2,
                ]);
        }

        foreach (array_keys($testClients[0]) as $field) {
            // Ascending order
            $this
                ->getJsonRequest(route('clients.index', ['facility_id' => 2, 'order_by' => $field, 'order' => 'ASC']))
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testClients[0][$field], $testClients[1][$field]]);

            // Descending order
            $this
                ->getJsonRequest(route('clients.index', ['facility_id' => 2, 'order_by' => $field, 'order' => 'DESC']))
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeTextInOrder([$testClients[1][$field], $testClients[0][$field]]);
        }
    }

    /**
     * @group clients
     */
    public function testWeCanPaginateClientList()
    {
        $perPage = (new Client())->getPerPage();
        $recordCount = $perPage + 3;

        // Bulk insert
        factory(Client::class, $recordCount)->create(
            [
                'first_name' => $this->faker->firstName,
                'middle_name' => '',
                'last_name' => $this->faker->lastName,
                'room_number' => 'A302',
                'responsible_party_email' => $this->faker->email,
                'facility_id' => $this->facility->id,
            ]
        );

        $totalPage = (int) ceil($recordCount / $perPage);

        $this
            ->getJsonRequest(route('clients.index', ['page' => 1]))
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

        $lastPageItemCount = $recordCount - ($totalPage - 1) * $perPage;

        $this
            ->getJsonRequest(route('clients.index'), ['page' => $totalPage])
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
     * @group clients
     */
    public function testWeCanGetClientListWithoutPaginate()
    {
        $perPage = (new Client())->getPerPage();
        $recordCount =  $perPage + 3;

        // Bulk insert
        factory(Client::class, $recordCount)->create(
            [
                'first_name' => $this->faker->firstName,
                'middle_name' => '',
                'last_name' => $this->faker->lastName,
                'room_number' => 'A302',
                'responsible_party_email' => $this->faker->email,
                'facility_id' => $this->facility->id,
            ]
        );

        $this
            ->getJsonRequest(route('clients.index', ['facility_id' => $this->facility->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertDontSee('pagination')
            ->assertJsonCount($recordCount, 'data');
    }

    /**
     * @group clients
     */
    public function testWeCanSearchForClient()
    {
        factory(Client::class)->create(
            [
                'first_name' => 'John',
                'middle_name' => '',
                'last_name' => 'Doe',
                'room_number' => 'A302',
                'responsible_party_email' => 'johndoe@test.it',
                'facility_id' => $this->facility->id,
            ]
        );
        factory(Client::class)->create(
            [
                'first_name' => 'Jane',
                'middle_name' => '',
                'last_name' => 'Doe',
                'room_number' => 'A301',
                'responsible_party_email' => 'janedoe@test.it',
                'facility_id' => $this->facility->id,
            ]
        );

        $this
            ->getJsonRequest(route('clients.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data');

        $this
            ->getJsonRequest(
                route('clients.index', ['facility_id' => $this->facility->id, 'search_key' => 'Jane'])
            )
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonCount(1, 'data');
    }

    /**
     * @group clients
     */
    public function testWeCanListClientsWithEmptySearchKey()
    {
        $response = $this->getJsonRequest(
            route('clients.index', ['facility_id' => $this->facility->id, 'search_key' => ''])
        );

        $response->assertStatus(JsonResponse::HTTP_OK);
    }

    /**
     * @group clients
     */
    public function testWeCanModifyDatas()
    {
        $client = factory(Client::class)->make(['facility_id' => $this->facility->id]);
        $client->save(['unprotected' => true]);

        $firstName = $this->faker->firstName;
        $middleName = '';
        $lastName = $this->faker->lastName;
        $respPartyEmail = $this->faker->email;
        $response = $this->putJsonRequest(
            route('clients.update', ['id' => $client->id]),
            [
                'data' => [
                    'type' => 'client',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'room_number' => 'A305',
                        'responsible_party_email' => $respPartyEmail,
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();

        $this->assertSame([
            'data' => [
                'type' => 'clients',
                'id' => (string)$client->id,
                'attributes' => [
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'room_number' => 'A305',
                    'responsible_party_email' => $respPartyEmail,
                    'facility_id' => $this->facility->id,
                    'transport_status' => 'off',
                    'ongoing_event' => null,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/clients/' . $client->id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group clients
     */
    public function testWeCanGetSpecificClient()
    {
        $client = factory(Client::class)->create(['facility_id' => $this->facility->id]);

        $response = $this->getJsonRequest(route('clients.show', ['id' => $client->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame([
            'data' => [
                'type' => 'clients',
                'id' => (string)$client->id,
                'attributes' => [
                    'first_name' => $client->first_name,
                    'middle_name' => $client->middle_name,
                    'last_name' => $client->last_name,
                    'room_number' => (string)$client->room_number,
                    'responsible_party_email' => $client->responsible_party_email,
                    'facility_id' => $this->facility->id,
                    'transport_status' => 'off',
                    'ongoing_event' => null,
                ],
                'links' => [
                    'self' => env('APP_URL') . '/clients/' . $client->id,
                ],
            ],
        ], $jsonData);
    }

    /**
     * @group clients
     */
    public function testWeCanDeleteClient()
    {
        $client = factory(Client::class)->create(['facility_id' => $this->facility->id]);
        $response = $this->deleteJsonRequest(route('clients.destroy', ['id' => $client->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    /**
     * @group clients
     */
    public function testListAllClients()
    {
        $clientCount = Client::count();
        $response = $this->getJsonRequest(route('clients.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($clientCount, count($jsonData['data']));
    }

    /**
     * @group clients
     */
    public function testListAllClientsByFacility()
    {
        $clientCount = Client::where('facility_id', $this->facility->id)->count();
        $response = $this->getJsonRequest(route('clients.index', ['facility_id' => $this->facility->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertSame($clientCount, count($jsonData['data']));
    }

    /**
     * @group clients
     */
    public function testWeCantListClientsWithWrongFacilityId()
    {
        $facilityCount = Facility::count();
        $response = $this->getJsonRequest(route('clients.index', ['facility_id' => $facilityCount + 1 ]));
        $this->assertCount(0, $response->decodeResponseJson()['data']);
        $response = $this->getJsonRequest(route('clients.index', ['facility_id' => 0 ]));
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group clients
     */
    public function testWeCantGetSpecifiedClientsWithWrongId()
    {
        $clientCount = Client::count();
        $response = $this->getJsonRequest(route('clients.show', ['id' => $clientCount + 1 ]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->getJsonRequest(route('clients.show', ['id' => 0 ]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @group clients
     */
    public function testWeCantCreateClientWithWrongOrLessParameters()
    {
        $firstName = $this->faker->firstName;
        $middleName = '';
        $lastName = $this->faker->lastName;
        $response = $this->postJsonRequest(
            route('clients.store'),
            [
                'data' => [
                    'type' => 'client',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'room_number' => 302,
                        'facility_id' => null,
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $firstName = $this->faker->firstName;
        $middleName = '';
        $lastName = $this->faker->lastName;
        $response = $this->postJsonRequest(
            route('clients.store'),
            [
                'data' => [
                    'type' => 'client',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'facility_id' => $this->facility->id,
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group clients
     */
    public function testWeCantDeleteClientsWithWrongId()
    {
        $clientId = Client::count();
        $response = $this->deleteJsonRequest(route('clients.destroy', ['id' => $clientId + 1]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->deleteJsonRequest(route('clients.destroy', ['id' => 0]));
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->deleteJsonRequest(route('clients.destroy', ['id' => null]));
        $response->assertStatus(JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * @group clients
     */
    public function testWeCantModifyData()
    {
        $client = factory(Client::class)->create(['facility_id' => $this->facility->id]);

        $firstName = $this->faker->firstName;
        $middleName = '';
        $lastName = $this->faker->lastName;
        $respPartyEmail = $this->faker->email;
        $response = $this->putJsonRequest(
            route('clients.update', ['id' => $client->id]),
            [
                'data' => [
                    'type' => 'client',
                    'attributes' => [
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'room_number' => 'A305',
                        'responsible_party_email' => $respPartyEmail,
                        'facility_id' => $this->facility->id,
                    ],
                ],
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $response = $this->putJsonRequest(route('clients.update', ['id' => $client->id]), []);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group clients
     */
    public function testWeCantModifyDataWithWrongId()
    {
        $clientCount = Client::count();

        $response = $this->putJsonRequest(route('clients.update', ['id' => $clientCount + 1]), []);
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->putJsonRequest(route('clients.update', ['id' => 0]), []);
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response = $this->putJsonRequest(route('clients.update', ['id' => null]), []);
        $response->assertStatus(JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * @group clients
     * @group import
     */
    public function testWeCanImportClientsAsFacilityAdmin()
    {
        $this->login('fa@silverpine.test');
        $clientCount = Client::count();
        $firstClient = $this->getFirstImportedClientData();
        $path = __DIR__ . '/src/good.csv';
        $file = new UploadedFile($path, 'good.csv', 'text/csv', null, null, true);
        $response = $this->post(route('clients.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertCount($clientCount + 15, Client::get());
        $this->assertCount(1, Client::where([
            ['first_name', $firstClient['first_name']],
            ['middle_name', $firstClient['middle_name']],
            ['last_name', $firstClient['last_name']],
            ['room_number', $firstClient['room_number']],
            ['responsible_party_email', $firstClient['responsible_party_email']],
        ])->get());
    }

    /**
     * @group clients
     * @group import
     */
    public function testWeCantImportClientsAsNotAuthorizedUser()
    {
        $this->login('ad@silverpine.test');
        $clientCount = Client::count();
        $path = __DIR__ . '/src/good.csv';
        $file = new UploadedFile($path, 'good.csv', 'text/csv', null, null, true);
        $response = $this->post(route('clients.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $this->assertCount($clientCount, Client::get());
    }

    /**
     * @group clients
     * @group import
     */
    public function testWeCantImportClientsWithWrongExtension()
    {
        $clientCount = Client::count();
        $path = __DIR__ . '/src/wrong.extension';
        $file = new UploadedFile($path, 'wrong.extension', null, null, null, true);
        $response = $this->post(route('clients.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertSame(
            'Wrong file type given, please upload a CSV file.',
            $response->decodeResponseJson()['errors'][0]['detail']
        );
        $this->assertCount($clientCount, Client::get());
    }

    /**
     * @group clients
     * @group import
     */
    public function testWeCantImportClientsWhenSixColumnsReceived()
    {
        $clientCount = Client::count();
        $path = __DIR__ . '/src/6_columns.csv';
        $file = new UploadedFile($path, '6_columns.csv', 'text/csv', null, null, true);
        $response = $this->post(route('clients.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertSame(
            'The file must contain 5 columns.',
            $response->decodeResponseJson()['errors'][0]['detail']
        );
        $this->assertCount($clientCount, Client::get());
    }

    /**
     * @group clients
     * @group import
     */
    public function testWeCantImportClientsWhenNamesAreLongerThanExpected()
    {
        $clientCount = Client::count();
        $path = __DIR__ . '/src/long_names.csv';
        $file = new UploadedFile($path, 'long_names.csv', 'text/csv', null, null, true);
        $response = $this->post(route('clients.import'), ['csv' => $file], [
            'Authorization' => 'Bearer ' . $this->loggedToken,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $this->assertCount(2, $response->decodeResponseJson()['errors']);
        $this->assertCount($clientCount, Client::get());
    }

    /**
     * Client Import test data
     * @return array
     */
    public function getFirstImportedClientData()
    {
        return [
            'first_name' => 'Nomi',
            'middle_name' => 'Katherina',
            'last_name' => 'Overell',
            'room_number' => 2,
            'responsible_party_email' => 'nomi@example.com',
        ];
    }

    /**
     * @group clients
     */
    public function testWeCanGetClientWithOngoingEvent()
    {
        $this->login('mu@silverpine.test');
        $client = Client::first();
        $event = $client->passengers[0]->event;
        $event->date = date('Y-m-d');
        $event->start_time = '0:00:00';
        $event->end_time = '23:59:59';
        $event->rrule = null;
        $event->save();

        $response = $this->getJsonRequest(route('clients.show', ['id' => $client->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals('on', $jsonData['data']['attributes']['transport_status']);
        $this->assertNotEmpty($jsonData['data']['attributes']['ongoing_event']);
        $this->assertEquals($event->id, $jsonData['data']['attributes']['ongoing_event']['id']);
    }

    /**
     * @group clients
     */
    public function testWeCanGetClientWithOngoingRruleEvent()
    {
        $this->login('mu@silverpine.test');
        $client = Client::first();
        $event = $client->passengers[0]->event;
        $event->date = date('Y-m-d', strtotime('yesterday'));
        $event->start_time = '0:00:00';
        $event->end_time = '23:59:59';
        $event->rrule = 'FREQ=DAILY;INTERVAL=1';
        $event->save();

        $response = $this->getJsonRequest(route('clients.show', ['id' => $client->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonData = $response->decodeResponseJson();
        $this->assertEquals('on', $jsonData['data']['attributes']['transport_status']);
        $this->assertNotEmpty($jsonData['data']['attributes']['ongoing_event']);
        $this->assertEquals($event->id, $jsonData['data']['attributes']['ongoing_event']['id']);
    }
}
