<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Facility\GetFacilityRequest;
use App\Http\Requests\Facility\ListFacilityRequest;
use App\Http\Requests\Facility\StoreFacilityRequest;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\Request;
use App\Http\Requests\Facility\UpdateFacilityRequest;
use App\Repositories\Organization\FacilityRepository;
use App\Transformers\Organization\FacilityTransformer;
use Illuminate\Http\Response;

class FacilityController extends ApiBaseController
{
    /**
     * @api {get} /facilities Get facility list
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup Facilities
     * @apiName Get facility list
     *
     * @apiParam {Number} [organization_id] Filter facility list by Organization ID
     * @apiParam {String="id","name"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {Number} id Facility id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Facility name.
     * @apiSuccess {Number} attributes.organization_id Parent organization id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     * @apiSuccess {Object} [meta] Only if sent a page GET parameter
     * @apiSuccess {Object} [meta.pagination] Contains a data for pagination
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": [
     *             {
     *                 "type": "facilities",
     *                 "id": "1",
     *                 "attributes": {
     *                     "name": "Evergreen Retirement Home",
     *                     "organization_id": 1
     *                 },
     *                 "links": {
     *                     "self": "http://api.journey.local/facilities/1"
     *                 }
     *             },
     *             {
     *                 "type": "facilities",
     *                 "id": "2",
     *                 "attributes": {
     *                     "name": "Silver Leaves Retirement Home",
     *                     "organization_id": 1
     *                 },
     *                 "links": {
     *                     "self": "http://api.journey.local/facilities/2"
     *                 }
     *             }
     *         ]
     *     }
     *
     *
     */
    /**
     * Display all resources.
     *
     * @param ListFacilityRequest $request
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function index(ListFacilityRequest $request)
    {
        return $this->pagination($this->repository->list($request->all()));
    }

    /**
     * @api {post} /facilities Add new facility
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Facilities
     * @apiName Add new facility
     *
     * @apiParam {String="facilities"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name Facility name.
     * @apiParam {Number} attributes.organization_id Parent organization id.
     *
     * @apiParamExample {json} Example usage:
     *      body:
     *      {
     *          "data": {
     *              "type": "facilities",
     *              "attributes": {
     *                  "name": "Apple Clinics",
     *                  "organization_id": 1
     *              }
     *          }
     *      }
     *
     * @apiSuccess {String="facilities"} type Response type.
     * @apiSuccess {Number} id Facility id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Facility name.
     * @apiSuccess {Number} attributes.organization_id Parent organization id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": [
     *             {
     *                 "type": "facilities",
     *                 "id": "1",
     *                 "attributes": {
     *                     "name": "Evergreen Retirement Home",
     *                     "organization_id": 1
     *                 },
     *                 "links": {
     *                     "self": "http://api.journey.local/facilities/1"
     *                 }
     *             }
     *         ]
     *     }
     *
     * @apiError Unique-name Same name not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample Unique name
     *     HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.name"
     *                  },
     *                  "detail": "Facility name must be unique."
     *              }
     *          ]
     *      }
     *
     * @apiErrorExample Missing attributes
     *     HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes"
     *                  },
     *                  "detail": "The data.attributes field is required."
     *              },
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.name"
     *                  },
     *                  "detail": "The data.attributes.name field is required."
     *              }
     *          ]
     *      }
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFacilityRequest $request
     * @return Response
     */
    public function store(StoreFacilityRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /facilities/:id Get facility by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Facilities
     * @apiName Get specified facility
     *
     * @apiParam {Number} id Facility id

     * @apiSuccess {String="facilities"} type Response type.
     * @apiSuccess {Number} id Facility id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Facility name.
     * @apiSuccess {Number} attributes.organization_id Parent organization id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": [
     *             {
     *                 "type": "facilities",
     *                 "id": "1",
     *                 "attributes": {
     *                     "name": "Evergreen Retirement Home",
     *                     "organization_id": 1
     *                 },
     *                 "links": {
     *                     "self": "http://api.journey.local/facilities/1"
     *                 }
     *             }
     *         ]
     *     }
     */
    /**
     * Display the specified resource.
     *
     * @param  GetFacilityRequest  $request
     * @param  int  $id
     * @return Response
     *
     * @SuppressWarnings("unused")
     */
    public function show(GetFacilityRequest $request, $id)
    {
        return $this->item($this->repository->find($id));
    }

    /**
     * @api {put/patch} /facilities/:id Update facility
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Facilities
     * @apiName Update facility
     *
     * @apiParam {Number} id Facility id
     * @apiParam {String="facilities"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name Facility name.
     *
     * @apiParamExample {json} Example usage:
     *      body:
     *      {
     *          "data": {
     *              "type": "facilities",
     *              "attributes": {
     *                  "name": "Orange Clinics",
     *              }
     *          }
     *      }
     *
     * @apiSuccess {String="facilities"} type Request type.
     * @apiSuccess {Number} id Facility id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Facility name.
     * @apiSuccess {Number} attributes.organization_id Parent organization id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": [
     *             {
     *                 "type": "facilities",
     *                 "id": "1",
     *                 "attributes": {
     *                     "name": "Silver Leaves Retirement Home",
     *                     "organization_id": 1
     *                 },
     *                 "links": {
     *                     "self": "http://api.journey.local/facilities/1"
     *                 }
     *             }
     *         ]
     *     }
     *
     * @apiError Unique-name Same name not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample Unique name
     *     HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.name"
     *                  },
     *                  "detail": "Facility name must be unique."
     *              }
     *          ]
     *      }
     *
     * @apiErrorExample Missing attributes
     *     HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes"
     *                  },
     *                  "detail": "The data.attributes field is required."
     *              },
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.name"
     *                  },
     *                  "detail": "The data.attributes.name field is required."
     *              }
     *          ]
     *      }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFacilityRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateFacilityRequest $request, $id)
    {
        return $this->item($this->repository->update($request->only('data'), $id), Response::HTTP_OK);
    }

    /**
     * @api {delete} /facilities/:id Delete facility
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Facilities
     * @apiName Delete facility
     *
     * @apiParam {Number} id Facility id.
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
     * @param LoggedInRequest $request
     * @param int $id
     * @return Response
     *
     * @SuppressWarnings("unused")
     */
    public function destroy(LoggedInRequest $request, $id)
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
        return FacilityRepository::class;
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return FacilityTransformer::class;
    }
}
