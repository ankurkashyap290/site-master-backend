<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Logs\ListTransportLogRequest;
use App\Http\Requests\Logs\StoreTransportLogRequest;
use App\Http\Requests\Logs\DeleteTransportLogRequest;
use App\Http\Requests\Request;
use App\Models\Logs\TransportLog;
use Illuminate\Http\Response;

class TransportLogController extends ApiBaseController
{
    /**
     * @api {get} /transport-logs Get transport log list
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportLog
     * @apiName Get transport log list
     *
     * @apiParam {Integer} facilityId Mandatory facility id.
     * @apiParam {Integer} page Mandatory page number, starts with 1.
     * @apiParam {String} [from]      Optional date paramter, format: "Y-m-d H:i:s"
     * @apiParam {String} [to]      Optional date paramter, format: "Y-m-d H:i:s"
     *
     * @apiSuccess {String="transport-logs"} type Response type.
     * @apiSuccess {number} id Transport log id.
     * @apiSuccess {object} attributes
     * @apiSuccess {String} attributes.location_name Location name.
     * @apiSuccess {String} attributes.client_name Client name.
     * @apiSuccess {String} attributes.signature Signature.
     * @apiSuccess {String} attributes.equipment_type Equipment type.
     * @apiSuccess {Boolean} attributes.equipment_secured Equipment secured.
     * @apiSuccess {String} attributes.date Transport log date time.
     * @apiSuccess {object} links
     * @apiSuccess {String} links.self Resource URL
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
     *          "type": "transport-logs",
     *          "id": "180",
     *          "attributes": {
     *            "location_name": "3151 Hahn Islands",
     *            "client_name": "Prof. Lois Baumbach DVM",
     *            "equipment": "wheelchair",
     *            "equipment_secured": 0,
     *            "signature": "Justyn Stamm MD",
     *            "date": "2018-04-20 07:18:31",
     *            "user_id": 1,
     *            "facility_id": 1
     *          },
     *          "links": {
     *            "self": "http://api.journey.local/transport-logs/180"
     *          }
     *        }
     *      ],
     *      "meta": {
     *        "pagination": {
     *          "total": 1,
     *          "count": 1,
     *          "per_page": 15,
     *          "current_page": 1,
     *          "total_pages": 1
     *        }
     *      }
     *    }
     *
     *
     */
    /**
     * Display all resources.
     *
     * @param ListTransportLogRequest $request
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function index(ListTransportLogRequest $request)
    {
        return $this->pagination($this->repository->getFilteredList($request->all()));
    }

    /**
     * @api {post} /transport-log Add new transport log
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportLog
     * @apiName Add new transport log entry.
     *
     * @apiParam {String="transport-logs"} type Request type.
     * @apiParam {object} attributes
     * @apiParam {String} attributes.location_name Location name.
     * @apiParam {String} attributes.client_name Client name.
     * @apiParam {String} attributes.signature Signature.
     * @apiParam {String} attributes.equipment_type Equipment type.
     * @apiParam {Boolean} attributes.equipment_secured Equipment secured.
     * @apiParam {String} attributes.date Transport log date time, format "Y-m-d H:i:s"
     * @apiParam {Integer} attributes.user_id Current user id.
     * @apiParam {Integer} attributes.facility_id Current facility id.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *       "data": {
     *         "type": "transport-logs",
     *         "attributes": {
     *           "location_name": "Everett Schaefer",
     *           "client_name": "Olen Renner",
     *           "equipment": "ambulatory",
     *           "equipment_secured": 1,
     *           "signature": "Leopold Collins",
     *           "date": "2018-05-03 06:17:54",
     *           "user_id": 7,
     *           "facility_id": 4
     *         }
     *       }
     *    }
     *
     * @apiSuccess {String="transport-logs"} type Response type.
     * @apiSuccess {number} id Transport log id.
     * @apiSuccess {object} attributes
     * @apiSuccess {String} attributes.location_name Location name.
     * @apiSuccess {String} attributes.client_name Client name.
     * @apiSuccess {String} attributes.signature Signature.
     * @apiSuccess {String} attributes.equipment_type Equipment type.
     * @apiSuccess {Boolean} attributes.equipment_secured Equipment secured.
     * @apiSuccess {String} attributes.date Transport log date time, format "Y-m-d H:i:s"
     * @apiSuccess {Integer} attributes.user_id Current user id.
     * @apiSuccess {Integer} attributes.facility_id Current facility id.
     * @apiSuccess {object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *      "data": {
     *        "type": "transport-logs",
     *        "id": "1",
     *        "attributes": {
     *          "location_name": "Zack Mitchell",
     *          "client_name": "Miss Rosalinda Shanahan",
     *          "equipment": "ambulatory",
     *          "equipment_secured": 1,
     *          "signature": "Renee Durgan",
     *          "date": "2018-05-03 06:21:15",
     *          "user_id": 7,
     *          "facility_id": 4
     *        },
     *        "links": {
     *          "self": "http://api.journey.local/transport-logs/1"
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
     *                    "pointer": "data.attributes.signature"
     *                },
     *                "detail": "The data.attributes.signature field is required."
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
     *                    "pointer": "data.attributes.equipment_secured"
     *                },
     *                "detail": "The data.attributes.equipment_secured field is required."
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
     * @param StoreTransportLogRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransportLogRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /transport-logs/:id Delete transport log
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportLog
     * @apiName Delete transport log
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
     * @api {put/patch} /transport-logs/:id Update transport log
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup TransportLog
     * @apiName Update transport log
     *
     * @apiParam {number} id  Transport log id.
     * @apiParam {String="transport-logs"} type Request type.
     * @apiParam {object} attributes
     * @apiParam {String} attributes.location_name Location name.
     * @apiParam {String} attributes.client_name Client name.
     * @apiParam {String} attributes.signature Signature.
     * @apiParam {String} attributes.equipment_type Equipment type.
     * @apiParam {Boolean} attributes.equipment_secured Equipment secured.
     * @apiParam {String} attributes.date Transport log date time, format "Y-m-d H:i:s"
     * @apiParam {Integer} attributes.user_id Current user id.
     * @apiParam {Integer} attributes.facility_id Current facility id.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *       "data": {
     *         "type": "transport-logs",
     *         "attributes": {
     *           "location_name": "Everett Schaefer",
     *           "client_name": "Olen Renner",
     *           "equipment": "ambulatory",
     *           "equipment_secured": 1,
     *           "signature": "Leopold Collins",
     *           "date": "2018-05-03 06:17:54",
     *           "user_id": 7,
     *           "facility_id": 4
     *         }
     *       }
     *    }
     *
     * @apiSuccess {String="transport-logs"} type Response type.
     * @apiSuccess {number} id Transport log id.
     * @apiSuccess {object} attributes
     * @apiSuccess {String} attributes.location_name Location name.
     * @apiSuccess {String} attributes.client_name Client name.
     * @apiSuccess {String} attributes.signature Signature.
     * @apiSuccess {String} attributes.equipment_type Equipment type.
     * @apiSuccess {Boolean} attributes.equipment_secured Equipment secured.
     * @apiSuccess {String} attributes.date Transport log date time, format "Y-m-d H:i:s"
     * @apiSuccess {Integer} attributes.user_id Current user id.
     * @apiSuccess {Integer} attributes.facility_id Current facility id.
     * @apiSuccess {object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *      "data": {
     *        "type": "transport-logs",
     *        "id": "1",
     *        "attributes": {
     *          "location_name": "Zack Mitchell",
     *          "client_name": "Miss Rosalinda Shanahan",
     *          "equipment": "ambulatory",
     *          "equipment_secured": 1,
     *          "signature": "Renee Durgan",
     *          "date": "2018-05-03 06:21:15",
     *          "user_id": 7,
     *          "facility_id": 4
     *        },
     *        "links": {
     *          "self": "http://api.journey.local/transport-logs/1"
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
     *                    "pointer": "data.attributes.signature"
     *                },
     *                "detail": "The data.attributes.signature field is required."
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
     *                    "pointer": "data.attributes.equipment_secured"
     *                },
     *                "detail": "The data.attributes.equipment_secured field is required."
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTransportLogRequest $request, $id)
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
        return 'App\Repositories\Logs\TransportLogRepository';
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\Logs\TransportLogTransformer';
    }
}
