<?php

namespace App\Http\Controllers\ETC;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\ETC\ListETCRequest;
use App\Repositories\Event\DriverRepository;
use App\Http\Requests\ETC\StoreETCRequest;
use App\Http\Requests\ETC\DeleteETCRequest;
use App\Http\Requests\ETC\ShowETCRequest;
use App\Http\Requests\ETC\ShowEtcBidRequest;
use App\Http\Requests\ETC\UpdateEtcBidRequest;
use Illuminate\Http\Response;

class ETCController extends ApiBaseController
{
    /**
     * @api {get} /etcs Get E.T.C.s list
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup E.T.C.s
     * @apiName Get E.T.C. list
     *
     * @apiParam {Number} facility_id Facility id
     * @apiParam {String="first_name","room_number","responsible_party_email"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {String="etcs"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name E.T.C. name.
     * @apiSuccess {String} attributes.color_id Color id
     * @apiSuccess {String} attributes.emails comma separated email list.
     * @apiSuccess {String} attributes.phone E.T.C. phone Number.
     * @apiSuccess {String} attributes.location_id Location id.
     * @apiSuccess {Object} attributes.location Location details.
     * @apiSuccess {String} attributes.facility_id Facility id.
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
     *                "type": "etcs",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Ashlee Carter",
     *                    "color_id": 9,
     *                    "emails": "rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com",
     *                    "phone": "(855) 943-8060",
     *                    "location_id": 5,
     *                    "facility_id": 4,
     *                    "location": {
     *                      "id": 5,
     *                      "name": "Berge, Greenholt and Harris",
     *                      "phone": "328-486-8780",
     *                      "address": "79929 Junior Cove\nSouth Ayla, AK 76297",
     *                      "city": "Port Rhett",
     *                      "state": "CA",
     *                      "postcode": "38810",
     *                      "facility_id": 4
     *                    }
     *                  },
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/etcs/1"
     *                }
     *            },
     *            {
     *                "type": "etcs",
     *                "id": "2",
     *                "attributes": {
     *                    "name": "Ashlee Carter",
     *                    "color_id": 9,
     *                    "emails": "rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com",
     *                    "phone": "(855) 943-8060",
     *                    "location_id": 5,
     *                    "facility_id": 4,
     *                    "location": {
     *                      "id": 5,
     *                      "name": "Berge, Greenholt and Harris",
     *                      "phone": "328-486-8780",
     *                      "address": "79929 Junior Cove\nSouth Ayla, AK 76297",
     *                      "city": "Port Rhett",
     *                      "state": "CA",
     *                      "postcode": "38810",
     *                      "facility_id": 4
     *                    }
     *                  },
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/etcs/2"
     *                }
     *            },
     *        ]
     *    }
     *
     *
     */
    /**
     * Display all resources.
     *
     * @param ListETCRequest $request
     * @return Response
     */
    public function index(ListETCRequest $request)
    {
        $repositoryData = $this->repository->getETCByFacility($request->all());
        return $this->pagination($repositoryData);
    }

    /**
     * @api {get} /etcs/:id Get E.T.C. by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup E.T.C.s
     * @apiName Get specified E.T.C.
     *
     * @apiParam {Number} id E.T.C id
     *
     * @apiSuccess {String="etcs"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name E.T.C. name.
     * @apiSuccess {String} attributes.color_id Color id
     * @apiSuccess {String} attributes.emails comma separated email list.
     * @apiSuccess {String} attributes.phone E.T.C. phone Number.
     * @apiSuccess {String} attributes.location_id Location id.
     * @apiSuccess {Object} attributes.location Location details.
     * @apiSuccess {String} attributes.facility_id Facility id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *           {
     *                "type": "etcs",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Ashlee Carter",
     *                    "color_id": 9,
     *                    "emails": "rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com",
     *                    "phone": "(855) 943-8060",
     *                    "location_id": 5,
     *                    "facility_id": 4,
     *                    "location": {
     *                      "id": 5,
     *                      "name": "Berge, Greenholt and Harris",
     *                      "phone": "328-486-8780",
     *                      "address": "79929 Junior Cove\nSouth Ayla, AK 76297",
     *                      "city": "Port Rhett",
     *                      "state": "CA",
     *                      "postcode": "38810",
     *                      "facility_id": 4
     *                    }
     *                  },
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/etcs/1"
     *                }
     *            },
     *        }
     *    }
     *
     */
    /**
     * Display the specified resource.
     *
     * @param ShowETCRequest $request
     * @param  int $id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function show(ShowETCRequest $request, $id)
    {
        return $this->item($this->repository->find($id));
    }

    /**
     * @api {post} /etcs Add new E.T.C.
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup E.T.C.s
     * @apiName Add new E.T.C.
     *
     * @apiParam {String="etcs"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name E.T.C. name.
     * @apiParam {String} attributes.color_id Color id.
     * @apiParam {String} attributes.emails comma separated email list.
     * @apiParam {String} attributes.phone E.T.C. phone Number.
     * @apiParam {String} attributes.location_id Location id.
     * @apiParam {String} attributes.facility_id Facility id.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *        {
     *          "data": {
     *            "type": "etc",
     *            "attributes": {
     *              "name": "Prof. Moriah Considine",
     *              "color_id": 9,
     *              "emails": "king.cronin@hotmail.com,vivien.mckenzie@carter.biz,timmothy.treutel@schuster.com",
     *              "phone": "(800) 470 2565",
     *              "location_id": 5,
     *              "facility_id": 4
     *            }
     *          }
     *        }
     *
     * @apiSuccess {String="etcs"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name E.T.C. name.
     * @apiSuccess {String} attributes.color_id Color id
     * @apiSuccess {String} attributes.emails comma separated email list.
     * @apiSuccess {String} attributes.phone E.T.C. phone Number.
     * @apiSuccess {String} attributes.location_id Location id.
     * @apiSuccess {Object} attributes.location Location details.
     * @apiSuccess {String} attributes.facility_id Facility id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *           {
     *                "type": "etcs",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Ashlee Carter",
     *                    "color_id": 9,
     *                    "emails": "rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com",
     *                    "phone": "(855) 943-8060",
     *                    "location_id": 5,
     *                    "facility_id": 4,
     *                    "location": {
     *                      "id": 5,
     *                      "name": "Berge, Greenholt and Harris",
     *                      "phone": "328-486-8780",
     *                      "address": "79929 Junior Cove\nSouth Ayla, AK 76297",
     *                      "city": "Port Rhett",
     *                      "state": "CA",
     *                      "postcode": "38810",
     *                      "facility_id": 4
     *                    }
     *                  },
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/etcs/1"
     *                }
     *            },
     *        }
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
     *                    "pointer": "data.attributes.name"
     *                },
     *                "detail": "The data.attributes.name field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.emails"
     *                },
     *                "detail": "The data.attributes.emails field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.color_id"
     *                },
     *                "detail": "The data.attributes.color_id field is required."
     *            },
     *        ]
     *    }
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreETCRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreETCRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * @api {put/patch} /etcs/:id Update E.T.C.
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup E.T.C.s
     * @apiName Update E.T.C.
     *
     * @apiParam {String="etcs"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name E.T.C. name.
     * @apiParam {String} attributes.color_id Color id.
     * @apiParam {String} attributes.emails comma separated email list.
     * @apiParam {String} attributes.phone E.T.C. phone Number.
     * @apiParam {String} attributes.location_id Location id.
     * @apiParam {String} attributes.facility_id Facility id.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *        {
     *          "data": {
     *            "type": "etc",
     *            "attributes": {
     *              "name": "Prof. Moriah Considine",
     *              "color_id": 9,
     *              "emails": "king.cronin@hotmail.com,vivien.mckenzie@carter.biz,timmothy.treutel@schuster.com",
     *              "phone": "(800) 470 2565",
     *              "location_id": 5,
     *              "facility_id": 4
     *            }
     *          }
     *        }
     *
     * @apiSuccess {String="etcs"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name E.T.C. name.
     * @apiSuccess {String} attributes.color_id Color id
     * @apiSuccess {String} attributes.emails comma separated email list.
     * @apiSuccess {String} attributes.phone E.T.C. phone Number.
     * @apiSuccess {String} attributes.location_id Location id.
     * @apiSuccess {Object} attributes.location Location details.
     * @apiSuccess {String} attributes.facility_id Facility id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *           {
     *                "type": "etcs",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Ashlee Carter",
     *                    "color_id": 9,
     *                    "emails": "rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com",
     *                    "phone": "(855) 943-8060",
     *                    "location_id": 5,
     *                    "facility_id": 4,
     *                    "location": {
     *                      "id": 5,
     *                      "name": "Berge, Greenholt and Harris",
     *                      "phone": "328-486-8780",
     *                      "address": "79929 Junior Cove\nSouth Ayla, AK 76297",
     *                      "city": "Port Rhett",
     *                      "state": "CA",
     *                      "postcode": "38810",
     *                      "facility_id": 4
     *                    }
     *                  },
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/etcs/1"
     *                }
     *            },
     *        }
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
     *                    "pointer": "data.attributes.name"
     *                },
     *                "detail": "The data.attributes.name field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.emails"
     *                },
     *                "detail": "The data.attributes.emails field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.color_id"
     *                },
     *                "detail": "The data.attributes.color_id field is required."
     *            },
     *        ]
     *    }
     *
     */
    /**
     * Update the specified resource in storage.
     *
     * @param StoreETCRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreETCRequest $request, $id)
    {
        return $this->item($this->repository->update($request->only('data'), $id), Response::HTTP_OK);
    }

    /**
     * @api {delete} /etcs/:id Delete E.T.C.
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup E.T.C.s
     * @apiName Delete E.T.C.
     *
     * @apiParam {Number} id  E.T.C. id.
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
     * @param  DeleteETCRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @SuppressWarnings("unused")
     */
    public function destroy(DeleteETCRequest $request, $id)
    {
        $this->repository->delete($id);
        return $this->null();
    }

    /**
     * Show driver data for ETC
     * @SuppressWarnings("unused")
     * @param ShowEtcBidRequest $request
     * @param $hash
     * @return Response
     */
    public function showBid(ShowEtcBidRequest $request, $hash)
    {
        $repository = new DriverRepository();
        $this->setTransformer('\App\Transformers\Bidding\DriverTransformer');
        return $this->item($repository->getByHash($hash)->first());
    }

    /**
     * Update driver data by ETC.
     * @param UpdateEtcBidRequest $request
     * @param $driver
     * @return Response
     */
    public function updateBid(UpdateEtcBidRequest $request, $driver)
    {
        $repository = new DriverRepository();
        $this->setTransformer('\App\Transformers\Bidding\DriverTransformer');
        return $this->item($repository->updateByETC($driver, $request->only('data')));
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return 'App\Repositories\ETC\ETCRepository';
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\ETC\ETCTransformer';
    }
}
