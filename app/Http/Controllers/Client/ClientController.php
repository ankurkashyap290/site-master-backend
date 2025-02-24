<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Client\DeleteClientRequest;
use App\Http\Requests\Client\GetClientRequest;
use App\Http\Requests\Client\ImportClientRequest;
use App\Http\Requests\Client\ListClientRequest;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Repositories\Client\ClientRepository;
use App\Transformers\Client\ClientTransformer;
use Illuminate\Http\Response;

class ClientController extends ApiBaseController
{
    /**
     * @api {get} /clients Get client list
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup Clients
     * @apiName Get client list (filterable)
     *
     * @apiParam {Number} [facility_id] Filter by facility id.
     * @apiParam {String="first_name","room_number","responsible_party_email"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {String="clients"} type Response type.
     * @apiSuccess {Number} id Client id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name Client first name.
     * @apiSuccess {String} attributes.middle_name Client middle name.
     * @apiSuccess {String} attributes.last_name Client last name.
     * @apiSuccess {Number} attributes.room_number Client room number.
     * @apiSuccess {String} attributes.responsible_party_email Client Responsible Party email.
     * @apiSuccess {Number} attributes.facility_id Client facility id.
     * @apiSuccess {String} attributes.transport_status Transport status: "on" or "off".
     * @apiSuccess {Object} attributes.ongoing_event Ongoing Event or NULL.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     * @apiSuccess {Object} [meta] Only if sent a page GET parameter
     * @apiSuccess {Object} [meta.pagination] Contains a data for pagination
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": [
     *            {
     *                "type": "clients",
     *                "id": "1",
     *                "attributes": {
     *                    "first_name": "Anika",
     *                    "middle_name": "Mayert",
     *                    "last_name": "Willms",
     *                    "room_number": 34,
     *                    "responsible_party_email": "anika.junior@gmail.test",
     *                    "facility_id": 1,
     *                    "transport_status": "off",
     *                    "ongoing_event": null,
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/clients/1"
     *                }
     *            },
     *            {
     *                "type": "clients",
     *                "id": "2",
     *                "attributes": {
     *                    "first_name": "Kurtis",
     *                    "middle_name": "Lakin",
     *                    "last_name": "Bailey",
     *                    "room_number": 6,
     *                    "responsible_party_email": "kurtis.junior@gmail.test",
     *                    "facility_id": 1,
     *                    "transport_status": "off",
     *                    "ongoing_event": null,
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/clients/2"
     *                }
     *            },
     *            {
     *                "type": "clients",
     *                "id": "3",
     *                "attributes": {
     *                    "first_name": "Betty",
     *                    "middle_name": "Mohr",
     *                    "last_name": "Kautzer",
     *                    "room_number": 19,
     *                    "responsible_party_email": "betty.junior@gmail.test",
     *                    "facility_id": 2,
     *                    "transport_status": "off",
     *                    "ongoing_event": {
     *                        "id": 5,
     *                        "name": "Damion goes to the Dentist",
     *                        "date": "2018-05-25",
     *                        "start_time": "12:46:03",
     *                        "end_time": "05:58:35",
     *                        "transport_type": "passenger",
     *                        "transportation_type": "2",
     *                        "description": "",
     *                        "user": {
     *                             "id": 4,
     *                             "email": "fa@silverpine.test",
     *                             "first_name": "Sylvia",
     *                             "middle_name": "Silver",
     *                             "last_name": "Pine"
     *                         },
     *                        "facility_id": 1
     *                    },
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/clients/3"
     *                }
     *            }
     *        ]
     *    }
     */
    /**
     * Display all resources.
     *
     * @param  ListClientRequest  $request
     *
     * @return Response
     */
    public function index(ListClientRequest $request)
    {
        $client = $this->repository->listByFilters($request->all());
        return $this->pagination($client);
    }

    /**
     * @api {post} /clients Add new client
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Clients
     * @apiName Add new client
     *
     * @apiParam {String="clients"} type Request type.
     * @apiParam {Number} id Client id.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.first_name Client first name.
     * @apiParam {String} attributes.middle_name Client middle name.
     * @apiParam {String} attributes.last_name Client last name.
     * @apiParam {Number} attributes.room_number Client room number.
     * @apiParam {String} attributes.responsible_party_email Client Responsible Party email.
     * @apiParam {Number} attributes.facility_id Client facility id.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "clients",
     *            "attributes": {
     *                "first_name": "Betty",
     *                "middle_name": "Mohr",
     *                "last_name": "Kautzer",
     *                "room_number": 19,
     *                "responsible_party_email": "betty.junior@gmail.test",
     *                "facility_id": 2
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="clients"} type Response type.
     * @apiSuccess {Number} id Client id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name Client first name.
     * @apiSuccess {String} attributes.middle_name Client middle name.
     * @apiSuccess {String} attributes.last_name Client last name.
     * @apiSuccess {String} attributes.responsible_party_email Client Responsible Party email.
     * @apiSuccess {Number} attributes.room_number Client room number.
     * @apiSuccess {Number} attributes.facility_id Client facility id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "clients",
     *            "id": "8",
     *            "attributes": {
     *                "first_name": "Betty",
     *                "middle_name": "Mohr",
     *                "last_name": "Kautzer",
     *                "room_number": 19,
     *                "responsible_party_email": "betty.junior@gmail.test",
     *                "facility_id": 2
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/clients/8"
     *            }
     *        }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Missing attributes
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes"
     *                  },
     *                  "detail": "The data.attributes must contain 6 items."
     *              },
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.room_number"
     *                  },
     *                  "detail": "The data.attributes.room_number field is required."
     *              }
     *          ]
     *      }
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * Import multiple clients from CSV
     *
     * @param ImportClientRequest $request
     * @return Response
     */
    public function import(ImportClientRequest $request)
    {
        $path = $request->file('csv');
        $response = $this->repository->import($path);
        if ($response) {
            return $response;
        }
        return $this->pagination($this->repository->all());
    }

    /**
     * @api {delete} /clients/:id Delete client
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Clients
     * @apiName Delete client
     *
     * @apiParam {Number} id Client id.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": null
     *     }
     *
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SuppressWarnings("unused")
     */
    public function destroy(DeleteClientRequest $request, $id)
    {
        $this->repository->delete($id);
        return $this->null();
    }

    /**
     * @api {get} /clients/:id Get client by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Clients
     * @apiName Get specified client
     *
     * @apiParam {Number} id Client id

     * @apiSuccess {String="clients"} type Response type.
     * @apiSuccess {Number} id Client id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name Client first name.
     * @apiSuccess {String} attributes.middle_name Client middle name.
     * @apiSuccess {String} attributes.last_name Client last name.
     * @apiSuccess {Number} attributes.room_number Client room number.
     * @apiSuccess {String} attributes.responsible_party_email Client Responsible Party email.
     * @apiSuccess {Number} attributes.facility_id Client facility id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "clients",
     *            "id": "8",
     *            "attributes": {
     *                "first_name": "Betty",
     *                "middle_name": "Mohr",
     *                "last_name": "Kautzer",
     *                "room_number": 19,
     *                "responsible_party_email": "betty.junior@gmail.test",
     *                "facility_id": 2
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/clients/8"
     *            }
     *        }
     *    }
     */
    /**
     * Display the specified resource.
     *
     * @param  GetClientRequest $request
     * @param  int  $id
     * @return Response
     *
     * @SuppressWarnings("unused")
     */
    public function show(GetClientRequest $request, $id)
    {
        return $this->item($this->repository->find($id));
    }

    /**
     * @api {put/patch} /clients/:id Update client
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Clients
     * @apiName Update client
     *
     * @apiParam {Number} id Client id.
     *
     * @apiParam {String="clients"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.first_name Client first name.
     * @apiParam {String} attributes.middle_name Client middle name.
     * @apiParam {String} attributes.last_name Client last name.
     * @apiParam {String} attributes.responsible_party_email Client Responsible Party email.
     * @apiParam {Number} attributes.room_number Client room number.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "clients",
     *            "attributes": {
     *                "first_name": "Betty",
     *                "middle_name": "Mohr",
     *                "last_name": "Kautzer",
     *                "responsible_party_email": "betty.junior@gmail.test",
     *                "room_number": 23
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="clients"} type Response type.
     * @apiSuccess {Number} id Client id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name Client first name.
     * @apiSuccess {String} attributes.middle_name Client middle name.
     * @apiSuccess {String} attributes.last_name Client last name.
     * @apiSuccess {Number} attributes.room_number Client room number.
    * @apiSuccess {String} attributes.responsible_party_email Client Responsible Party email.
     * @apiSuccess {Number} attributes.facility_id Client facility id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "clients",
     *            "id": "8",
     *            "attributes": {
     *                "first_name": "Betty",
     *                "middle_name": "Mohr",
     *                "last_name": "Kautzer",
     *                "room_number": 23,
     *                "responsible_party_email": "betty.junior@gmail.test",
     *                "facility_id": 2
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/clients/8"
     *            }
     *        }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Missing attributes
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes"
     *                  },
     *                  "detail": "The data.attributes must contain 6 items."
     *              },
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.room_number"
     *                  },
     *                  "detail": "The data.attributes.room_number field is required."
     *              }
     *          ]
     *      }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {
        return $this->item($this->repository->update($request->only('data'), $id), Response::HTTP_OK);
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return ClientRepository::class;
    }

    /**
     * Get transformer type.
     *
     * @return string
     */
    protected function getTransformerType(): string
    {
        return ClientTransformer::class;
    }
}
