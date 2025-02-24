<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Location\ImportLocationRequest;
use App\Http\Requests\Location\ListLocationRequest;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Requests\Location\DeleteLocationRequest;
use App\Http\Requests\Location\GetLocationRequest;
use Illuminate\Http\Response;

class LocationController extends ApiBaseController
{
    /**
     * @api {get} /locations Get location list
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup Locations
     * @apiName Get location list
     *
     * @apiParam {Number} [facility_id] Filter by facility id.
     * @apiParam {String="name","phone","address","city","state","postcode"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {String="locations"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Location name.
     * @apiSuccess {String} attributes.phone Location phone Number.
     * @apiSuccess {String} attributes.address Location full address.
     * @apiSuccess {String} attributes.city Location city name.
     * @apiSuccess {String} attributes.state Location state code.
     * @apiSuccess {String} attributes.postcode Location postal code.
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
     *                "type": "locations",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Huels Ltd",
     *                    "phone": "+1.215.419.2907",
     *                    "address": "28523 Emile Vista\nPort Ryanstad, HI 01638-6705",
     *                    "city": "West Everardoshire",
     *                    "state": "CA",
     *                    "postcode": "50253"
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/locations/1"
     *                }
     *            },
     *            {
     *                "type": "locations",
     *                "id": "2",
     *                "attributes": {
     *                    "name": "Ullrich, Eichmann and Aufderhar",
     *                    "phone": "1-307-850-7206",
     *                    "address": "824 Arnaldo Meadow Suite 923\nNorth Gastonland, PA 55879",
     *                    "city": "Verlahaven",
     *                    "state": "CA",
     *                    "postcode": "12719"
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/locations/2"
     *                }
     *            }
     *        ]
     *    }
     *
     *
     */
    /**
     * Display all resources.
     *
     * @param ListLocationRequest $request
     * @return Response
     */
    public function index(ListLocationRequest $request)
    {
        return $this->pagination($this->repository->getLocationsOfFacility($request->all()));
    }

    /**
     * @api {get} /locations/:id Get location by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Locations
     * @apiName Get specified location
     *
     * @apiParam {Number} id Location id
     *
     * @apiSuccess {String="locations"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Location name.
     * @apiSuccess {String} attributes.phone Location phone Number.
     * @apiSuccess {String} attributes.address Location full address.
     * @apiSuccess {String} attributes.city Location city name.
     * @apiSuccess {String} attributes.state Location state code.
     * @apiSuccess {String} attributes.postcode Location postal code.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "locations",
     *            "id": "1",
     *            "attributes": {
     *                "name": "Huels Ltd",
     *                "phone": "+1.215.419.2907",
     *                "address": "28523 Emile Vista\nPort Ryanstad, HI 01638-6705",
     *                "city": "West Everardoshire",
     *                "state": "CA",
     *                "postcode": "50253"
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/locations/1"
     *            }
     *        }
     *    }
     *
     */
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @SuppressWarnings("unused")
     */
    public function show(GetLocationRequest $request, $id)
    {
        return $this->item($this->repository->find($id));
    }
    /**
     * @api {post} /locations Add new location
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Locations
     * @apiName Add new location
     *
     * @apiParam {String="locations"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name Location name.
     * @apiParam {String} attributes.phone Location phone Number.
     * @apiParam {String} attributes.address Location full address.
     * @apiParam {String} attributes.city Location city name.
     * @apiParam {String} attributes.state Location state code.
     * @apiParam {String} attributes.postcode Location postal code.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "locations",
     *            "attributes": {
     *                "name": "O'Keefe-Prosacco",
     *                "phone": "(310) 987-1709 x1007",
     *                "address": "9704 Dickens Ranch Apt. 589\n North Lew, IN 39427",
     *                "city": "North Jadenmouth",
     *                "state": "CA",
     *                "postcode": "06339-6007"
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="locations"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Location name.
     * @apiSuccess {String} attributes.phone Location phone Number.
     * @apiSuccess {String} attributes.address Location full address.
     * @apiSuccess {String} attributes.city Location city name.
     * @apiSuccess {String} attributes.state Location state code.
     * @apiSuccess {String} attributes.postcode Location postal code.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "locations",
     *            "id": "5",
     *            "attributes": {
     *                "name": "O'Keefe-Prosacco",
     *                "phone": "(310) 987-1709 x1007",
     *                "address": "9704 Dickens Ranch Apt. 589\n North Lew, IN 39427",
     *                "city": "North Jadenmouth",
     *                "state": "CA",
     *                "postcode": "06339-6007"
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/locations/5"
     *            }
     *        }
     *    }
     *
     * @apiError Unique-email Same email not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample Unique email
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.email"
     *                  },
     *                  "detail": "Location email must be unique."
     *              }
     *          ]
     *      }
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
     *                    "pointer": "data.attributes.city"
     *                },
     *                "detail": "The data.attributes.city field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.state"
     *                },
     *                "detail": "The data.attributes.state field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.address"
     *                },
     *                "detail": "The data.attributes.address field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.postcode"
     *                },
     *                "detail": "The data.attributes.postcode field is required."
     *            }
     *        ]
     *    }
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLocationRequest  $request
     * @return Response
     */
    public function store(StoreLocationRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * Import multiple locations from CSV
     *
     * @param ImportLocationRequest $request
     * @return Response
     */
    public function import(ImportLocationRequest $request)
    {
        $path = $request->file('csv');
        $response = $this->repository->import($path);
        if ($response) {
            return $response;
        }
        return $this->pagination($this->repository->all());
    }

    /**
     * @api {put/patch} /locations/:id Update location
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Locations
     * @apiName Update location
     *
     * @apiParam {Number} id  Location id.
     *
     * @apiParam {String="locations"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name Location name.
     * @apiParam {String} attributes.phone Location phone Number.
     * @apiParam {String} attributes.address Location full address.
     * @apiParam {String} attributes.city Location city name.
     * @apiParam {String} attributes.state Location state code.
     * @apiParam {String} attributes.postcode Location postal code.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data":
     *            {
     *                "type": "locations",
     *                "attributes": {
     *                    "name": "Huels Ltd",
     *                    "phone": "+1.215.419.2907",
     *                    "address": "28523 Emile Vista\nPort Ryanstad, HI 01638-6705",
     *                    "city": "West Everardoshire",
     *                    "state": "CA",
     *                    "postcode": "50253"
     *                }
     *            }
     *    }
     *
     * @apiSuccess {String="locations"} type Response type.
     * @apiSuccess {Number} id Location id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Location name.
     * @apiSuccess {String} attributes.phone Location phone Number.
     * @apiSuccess {String} attributes.address Location full address.
     * @apiSuccess {String} attributes.city Location city name.
     * @apiSuccess {String} attributes.state Location state code.
     * @apiSuccess {String} attributes.postcode Location postal code.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "locations",
     *            "id": "1",
     *            "attributes": {
     *                "name": "Huels Ltd",
     *                "phone": "+1.215.419.2907",
     *                "address": "28523 Emile Vista\nPort Ryanstad, HI 01638-6705",
     *                "city": "West Everardoshire",
     *                "state": "CA",
     *                "postcode": "50253"
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/locations/1"
     *            }
     *        }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Missing attributes
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
     *                    "pointer": "data.attributes.city"
     *                },
     *                "detail": "The data.attributes.city field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.state"
     *                },
     *                "detail": "The data.attributes.state field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.address"
     *                },
     *                "detail": "The data.attributes.address field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.postcode"
     *                },
     *                "detail": "The data.attributes.postcode field is required."
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
    public function update(UpdateLocationRequest $request, $id)
    {
        return $this->item($this->repository->update($request->only('data'), $id), Response::HTTP_OK);
    }

    /**
     * @api {delete} /locations/:id Delete location
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Locations
     * @apiName Delete location
     *
     * @apiParam {Number} id  Location id.
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
    public function destroy(DeleteLocationRequest $request, $id)
    {
        $this->repository->delete($id);
        return $this->null();
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return 'App\Repositories\Location\LocationRepository';
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\Location\LocationTransformer';
    }
}
