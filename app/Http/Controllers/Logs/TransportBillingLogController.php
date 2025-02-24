<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Logs\ListTransportBillingLogRequest;
use App\Http\Requests\Logs\StoreTransportBillingLogRequest;
use App\Http\Requests\Request;
use Illuminate\Http\Response;

class TransportBillingLogController extends ApiBaseController
{
    /**
     * @api {get} /transport-billing-logs Get transport billing log list
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportBillingLog
     * @apiName Get transport billing log list
     *
     * @apiParam {Integer} facilityId Mandatory facility id.
     * @apiParam {Integer} page Mandatory page number, starts with 1.
     * @apiParam {String} [from]      Optional date parameter, format: "Y-m-d H:i:s"
     * @apiParam {String} [to]      Optional date parameter, format: "Y-m-d H:i:s"
     *
     * @apiSuccess {String="transport-billing-logs"} type Response type.
     * @apiSuccess {number} id Transport log id.
     * @apiSuccess {object} attributes
     * @apiSuccess {String} attributes.location_name Location name.
     * @apiSuccess {String} attributes.client_name Client name.
     * @apiSuccess {String} attributes.destination_type Indicate type of location.
     * @apiSuccess {String} attributes.transport_type Transport type.
     * @apiSuccess {String} attributes.equipment_type Equipment type.
     * @apiSuccess {Integer} attributes.mileage_to_start To Trip Destination Mileage: Start.
     * @apiSuccess {Integer} attributes.mileage_to_end To Trip Destination Mileage: End.
     * @apiSuccess {Integer} attributes.mileage_return_start Return Trip Destination Mileage: Start.
     * @apiSuccess {Integer} attributes.mileage_return_end Return Trip Destination Mileage: End.
     * @apiSuccess {Integer} attributes.fee Transport Fee.
     * @apiSuccess {String} attributes.date Transport billing log date.
     * @apiSuccess {object} links
     * @apiSuccess {object} pagination
     * @apiSuccess {Integer} pagination.total Number of all result.
     * @apiSuccess {Integer} pagination.count Number of result of the actual page.
     * @apiSuccess {Integer} pagination.per_page Maximum number of result per page.
     * @apiSuccess {Integer} pagination.current_page Current page number.
     * @apiSuccess {Integer} pagination.total_pages Number of available pages.
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *      "data": [
     *        {
     *          "type": "transport-billing-logs",
     *          "id": "2",
     *          "attributes": {
     *            "location_name": "171 Vandervort Springs Apt. 476",
     *            "client_name": "Michele Witting",
     *            "destination_type": "Ipsum sint aut sint porro.",
     *            "transport_type": "passenger",
     *            "equipment": "ambulatory",
     *            "mileage_to_start": "1",
     *            "mileage_to_end": "10",
     *            "mileage_return_start": "11",
     *            "mileage_return_end": "20",
     *            "fee": "5",
     *            "date": "2011-04-19 18:04:22",
     *            "user_id": "7",
     *            "facility_id": "4"
     *          },
     *          "links": {
     *            "self": "http://api.journey.local/transport-billing-logs/2"
     *          }
     *        },
     *       {
     *          "type": "transport-billing-logs",
     *          "id": "1",
     *          "attributes": {
     *            "location_name": "49427 Bernier Loaf Apt. 148",
     *            "client_name": "Jena Farrell",
     *            "destination_type": "Neque ut a possimus aut.",
     *            "transport_type": "wheelchair",
     *            "equipment": "ambulatory",
     *            "mileage_to_start": "1",
     *            "mileage_to_end": "10",
     *            "mileage_return_start": "11",
     *            "mileage_return_end": "20",
     *            "fee": "2",
     *            "date": "1975-01-14 00:07:14",
     *            "user_id": "7",
     *            "facility_id": "4"
     *          },
     *          "links": {
     *            "self": "http://api.journey.local/transport-billing-logs/1"
     *          }
     *       }
     *      ],
     *      "meta": {
     *        "pagination": {
     *          "total": 2,
     *          "count": 2,
     *          "per_page": 15,
     *          "current_page": 1,
     *          "total_pages": 1
     *        }
     *      },
     *      "links": {
     *        "self": "http://api.journey.local/api/transport-billing-logs?limit=15&from=&to=&page=1",
     *        "first": "http://api.journey.local/api/transport-billing-logs?limit=15&from=&to=&page=1",
     *        "last": "http://api.journey.local/api/transport-billing-logs?limit=15&from=&to=&page=1"
     *      }
     *    }
     *
     *
     */
    /**
     * Display all resources.
     *
     * @param ListTransportBillingLogRequest $request
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function index(ListTransportBillingLogRequest $request)
    {
        return $this->pagination($this->repository->getFilteredList($request->all()));
    }

    /**
     * @api {post} /transport-billing-logs Add new transport billing log
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportBillingLog
     * @apiName Add new transport billing log entry.
     *
     * @apiParam {String="transport-billing-logs"} type Request type.
     * @apiParam {object} attributes
     * @apiParam {object} attributes
     * @apiParam {String} attributes.location_name Location name.
     * @apiParam {String} attributes.client_name Client name.
     * @apiParam {String} attributes.destination_type Indicate type of location.
     * @apiParam {String} attributes.transport_type Transport type.
     * @apiParam {String} attributes.equipment_type Equipment type.
     * @apiParam {Integer} attributes.mileage_to_start To Trip Destination Mileage: Start.
     * @apiParam {Integer} attributes.mileage_to_end To Trip Destination Mileage: End.
     * @apiParam {Integer} attributes.mileage_return_start Return Trip Destination Mileage: Start.
     * @apiParam {Integer} attributes.mileage_return_end Return Trip Destination Mileage: End.
     * @apiParam {Integer} attributes.fee Transport Fee.
     * @apiParam {String} attributes.date Transport billing log date.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *      "data": {
     *        "type": "transport-billing-logs",
     *        "attributes": {
     *          "location_name": "Royce Spinka",
     *          "client_name": "Ivory Kautzer",
     *          "destination_type": "Aut id quo minima.",
     *          "transport_type": "ambulatory",
     *          "equipment": "ambulatory",
     *          "mileage_to_start": 1,
     *          "mileage_to_end": 10,
     *          "mileage_return_start": 11,
     *          "mileage_return_end": 20,
     *          "fee": 8,
     *          "date": "2018-05-06 17:38:01",
     *          "user_id": 7,
     *          "facility_id": 4
     *        }
     *      }
     *    }
     *
     * @apiSuccess {String="transport-billing-logs"} type Response type.
     * @apiSuccess {object} attributes
     * @apiSuccess {String} attributes.location_name Location name.
     * @apiSuccess {String} attributes.client_name Client name.
     * @apiSuccess {String} attributes.destination_type Indicate type of location.
     * @apiSuccess {String} attributes.transport_type Transport type.
     * @apiSuccess {String} attributes.equipment_type Equipment type.
     * @apiSuccess {Integer} attributes.mileage_to_start To Trip Destination Mileage: Start.
     * @apiSuccess {Integer} attributes.mileage_to_end To Trip Destination Mileage: End.
     * @apiSuccess {Integer} attributes.mileage_return_start Return Trip Destination Mileage: Start.
     * @apiSuccess {Integer} attributes.mileage_return_end Return Trip Destination Mileage: End.
     * @apiSuccess {Integer} attributes.fee Transport Fee.
     * @apiSuccess {String} attributes.date Transport billing log date.
     * @apiSuccess {object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *      "data": {
     *        "type": "transport-billing-logs",
     *        "id": "1",
     *        "attributes": {
     *          "location_name": "Erich Mertz",
     *          "client_name": "Rory Stokes",
     *          "destination_type": "Aliquam a impedit corrupti.",
     *          "transport_type": "ambulatory",
     *          "equipment": "ambulatory",
     *          "mileage_to_start": 1,
     *          "mileage_to_end": 10,
     *          "mileage_return_start": 11,
     *          "mileage_return_end": 20,
     *          "fee": 9,
     *          "date": "2018-05-06 17:30:52",
     *          "user_id": 7,
     *          "facility_id": 4
     *        },
     *        "links": {
     *          "self": "http://api.journey.local/transport-billing-logs/1"
     *        }
     *      }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample Missing attributes
     *    HTTP/1.1 400 Bad Request
     *    {
     *        "errors": [
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes"
     *                },
     *                "detail": "The data.attributes field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.location_name"
     *                },
     *                "detail": "The data.attributes.location_name field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.client_name"
     *                },
     *                "detail": "The data.attributes.client_name field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.destination_type"
     *                },
     *                "detail": "The data.attributes.destination_type field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.transport_type"
     *                },
     *                "detail": "The data.attributes.transport_type field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.equipment_type"
     *                },
     *                "detail": "The data.attributes.equipment_type field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_to_start"
     *                },
     *                "detail": "The data.attributes.mileage_to_start field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_to_end"
     *                },
     *                "detail": "The data.attributes.mileage_to_end field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_return_start"
     *                },
     *                "detail": "The data.attributes.mileage_return_start field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_return_end"
     *                },
     *                "detail": "The data.attributes.mileage_return_end field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.fee"
     *                },
     *                "detail": "The data.attributes.fee field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.date"
     *                },
     *                "detail": "The data.attributes.date field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.user_id"
     *                },
     *                "detail": "The data.attributes.user_id field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.facility_id"
     *                },
     *                "detail": "The data.attributes.facility_id field is required."
     *            }
     *        ]
     *    }
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Organization\StoreTransportBillingLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransportBillingLogRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /transport-billing-logs/:id Delete transport billing log
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportBillingLog
     * @apiName Delete transport billing log
     *
     * @apiParam {number} id  TransportLog id.
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SuppressWarnings("unused")
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);
        return $this->null();
    }

    /**
     * @api {put/patch} /transport-billing-logs/:id Update transport billing log
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportBillingLog
     * @apiName Update transport billing log
     *
     *
     * @apiParam {String="transport-billing-logs"} type Request type.
     * @apiParam {object} attributes
     * @apiParam {object} attributes
     * @apiParam {String} attributes.location_name Location name.
     * @apiParam {String} attributes.client_name Client name.
     * @apiParam {String} attributes.destination_type Indicate type of location.
     * @apiParam {String} attributes.transport_type Transport type.
     * @apiParam {String} attributes.equipment_type Equipment type.
     * @apiParam {Integer} attributes.mileage_to_start To Trip Destination Mileage: Start.
     * @apiParam {Integer} attributes.mileage_to_end To Trip Destination Mileage: End.
     * @apiParam {Integer} attributes.mileage_return_start Return Trip Destination Mileage: Start.
     * @apiParam {Integer} attributes.mileage_return_end Return Trip Destination Mileage: End.
     * @apiParam {Integer} attributes.fee Transport Fee.
     * @apiParam {String} attributes.date Transport billing log date.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *      "data": {
     *        "type": "transport-billing-logs",
     *        "attributes": {
     *          "location_name": "Royce Spinka",
     *          "client_name": "Ivory Kautzer",
     *          "destination_type": "Aut id quo minima.",
     *          "transport_type": "ambulatory",
     *          "equipment": "ambulatory",
     *          "mileage_to_start": 1,
     *          "mileage_to_end": 10,
     *          "mileage_return_start": 11,
     *          "mileage_return_end": 20,
     *          "fee": 8,
     *          "date": "2018-05-06 17:38:01",
     *          "user_id": 7,
     *          "facility_id": 4
     *        }
     *      }
     *    }
     *
     * @apiSuccess {String="transport-billing-logs"} type Response type.
     * @apiSuccess {object} attributes
     * @apiSuccess {String} attributes.location_name Location name.
     * @apiSuccess {String} attributes.client_name Client name.
     * @apiSuccess {String} attributes.destination_type Indicate type of location.
     * @apiSuccess {String} attributes.transport_type Transport type.
     * @apiSuccess {String} attributes.equipment_type Equipment type.
     * @apiSuccess {Integer} attributes.mileage_to_start To Trip Destination Mileage: Start.
     * @apiSuccess {Integer} attributes.mileage_to_end To Trip Destination Mileage: End.
     * @apiSuccess {Integer} attributes.mileage_return_start Return Trip Destination Mileage: Start.
     * @apiSuccess {Integer} attributes.mileage_return_end Return Trip Destination Mileage: End.
     * @apiSuccess {Integer} attributes.fee Transport Fee.
     * @apiSuccess {String} attributes.date Transport billing log date.
     * @apiSuccess {object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *      "data": {
     *        "type": "transport-billing-logs",
     *        "id": "1",
     *        "attributes": {
     *          "location_name": "Erich Mertz",
     *          "client_name": "Rory Stokes",
     *          "destination_type": "Aliquam a impedit corrupti.",
     *          "transport_type": "ambulatory",
     *          "equipment": "ambulatory",
     *          "mileage_to_start": 1,
     *          "mileage_to_end": 10,
     *          "mileage_return_start": 11,
     *          "mileage_return_end": 20,
     *          "fee": 9,
     *          "date": "2018-05-06 17:30:52",
     *          "user_id": 7,
     *          "facility_id": 4
     *        },
     *        "links": {
     *          "self": "http://api.journey.local/transport-billing-logs/1"
     *        }
     *      }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample Missing attributes
     *    HTTP/1.1 400 Bad Request
     *    {
     *        "errors": [
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes"
     *                },
     *                "detail": "The data.attributes field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.location_name"
     *                },
     *                "detail": "The data.attributes.location_name field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.client_name"
     *                },
     *                "detail": "The data.attributes.client_name field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.destination_type"
     *                },
     *                "detail": "The data.attributes.destination_type field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.transport_type"
     *                },
     *                "detail": "The data.attributes.transport_type field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.equipment_type"
     *                },
     *                "detail": "The data.attributes.equipment_type field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_to_start"
     *                },
     *                "detail": "The data.attributes.mileage_to_start field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_to_end"
     *                },
     *                "detail": "The data.attributes.mileage_to_end field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_return_start"
     *                },
     *                "detail": "The data.attributes.mileage_return_start field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.mileage_return_end"
     *                },
     *                "detail": "The data.attributes.mileage_return_end field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.fee"
     *                },
     *                "detail": "The data.attributes.fee field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.date"
     *                },
     *                "detail": "The data.attributes.date field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.user_id"
     *                },
     *                "detail": "The data.attributes.user_id field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.facility_id"
     *                },
     *                "detail": "The data.attributes.facility_id field is required."
     *            }
     *        ]
     *    }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTransportBillingLogRequest $request, $id)
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
        return 'App\Repositories\Logs\TransportBillingLogRepository';
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\Logs\TransportBillingLogTransformer';
    }
}
