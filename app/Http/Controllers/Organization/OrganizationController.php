<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\Organization\ListOrganizationRequest;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Requests\Organization\GetOrganizationRequest;
use App\Repositories\Organization\OrganizationRepository;
use App\Transformers\Organization\OrganizationTransformer;
use Illuminate\Http\Response;

class OrganizationController extends ApiBaseController
{
    /**
     * @api {post} /organizations Add new organization
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Organizations
     * @apiName Add new organization
     *
     * @apiParam {String="organizations"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name Organization name.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "organizations",
     *            "attributes": {
     *                "name": "Orange Clinics"
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="organizations"} type Response type.
     * @apiSuccess {Number} id Organization id
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Organization name.
     * @apiSuccess {Number} attributes.facility_limit Facility limit.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "organizations",
     *            "id": "3",
     *            "attributes": {
     *                "name": "Orange Clinics",
     *                "facility_limit": 2
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/organizations/3"
     *            }
     *        }
     *    }
     *
     * @apiError Unique-organization Same name not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Unique name
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.name"
     *                  },
     *                  "detail": "Organization name must be unique."
     *              }
     *          ]
     *      }
     *
     * @apiErrorExample {json} Missing attributes
     *     HTTP/1.1 400 Bad Request
     *     {
     *         "errors": [
     *             {
     *                 "status": "400",
     *                 "source": {
     *                     "pointer": "data.attributes"
     *                 },
     *                 "detail": "The data.attributes field is required."
     *             },
     *             {
     *                 "status": "400",
     *                 "source": {
     *                     "pointer": "data.attributes.name"
     *                 },
     *                 "detail": "The data.attributes.name field is required."
     *             }
     *         ]
     *     }
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrganizationRequest $request
     * @return Response
     */
    public function store(StoreOrganizationRequest $request): Response
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /organizations Get organization list
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup Organizations
     * @apiName Get organization list
     *
     * @apiParam {String="id","name"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {String="organizations"} type Response type.
     * @apiSuccess {Number} id Organization id
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Organization name.
     * @apiSuccess {Number} attributes.facility_limit Facility limit.
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
     *                "type": "organizations",
     *                "id": "3",
     *                "attributes": {
     *                    "name": "Orange Clinics"
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/organizations/3"
     *                }
     *            },
     *            {
     *                "type": "organizations",
     *                "id": "2",
     *                "attributes": {
     *                    "name": "Golden Years Inc.",
     *                    "facility_limit: 2
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/organizations/2"
     *                }
     *            },
     *            {
     *                "type": "organizations",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Silver Pine Ltd.",
     *                    "facility_limit: 2
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/organizations/1"
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
     * @param ListOrganizationRequest $request
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function index(ListOrganizationRequest $request)
    {
        return $this->pagination($this->repository->list($request->all()));
    }

    /**
     * @api {get} /organizations/:id Get organization by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Organizations
     * @apiName Get specified organization
     *
     * @apiParam {Number} id Organization id
     *
     * @apiSuccess {String="organizations"} type Response type.
     * @apiSuccess {Number} id Organization id
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Organization name.
     * @apiSuccess {Number} attributes.facility_limit Facility limit.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": {
     *             "type": "organizations",
     *             "id": "1",
     *             "attributes": {
     *                 "name": "Silver Pine Ltd.",
     *                 "facility_limit: 2
     *             },
     *             "links": {
     *                 "self": "http://api.journey.local/organizations/1"
     *             }
     *         }
     *     }
     *
     */
    /**
     * Display the specified resource.
     *
     * @param GetOrganizationRequest $request
     * @param int $id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function show(GetOrganizationRequest $request, $id)
    {
        return $this->item($this->repository->find($id));
    }

    /**
     * @api {put/patch} /organizations/:id Update organization
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Organizations
     * @apiName Update organization
     *
     * @apiParam {Number} id Organization id.
     *
     * @apiParam {String="organizations"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.name Organization name.
     * @apiParam {Number} attributes.facility_limit Facility limit.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "organizations",
     *            "attributes": {
     *                "name": "Apple Clinics",
     *                "facility_limit: 2
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="organizations"} type Response type.
     * @apiSuccess {Number} id Organization id
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.name Organization name.
     * @apiSuccess {Number} attributes.facility_limit Facility limit.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "organizations",
     *            "id": "3",
     *            "attributes": {
     *                "name": "Apple Clinics",
     *                "facility_limit: 2
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/organizations/3"
     *            }
     *        }
     *    }
     *
     * @apiError Unique-organization Same name not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Unique name
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "errors": [
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.name"
     *                },
     *                "detail": "Organization name must be unique."
     *            }
     *        ]
     *     }
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
     *            }
     *        ]
     *    }
     *
     */
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrganizationRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateOrganizationRequest $request, $id)
    {
        return $this->item($this->repository->update($request->only('data'), $id), Response::HTTP_OK);
    }

    /**
     * @api {delete} /organizations/:id Delete Organization
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Organizations
     * @apiName Delete organization
     *
     * @apiParam {Number} id Organization id.
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
        return OrganizationRepository::class;
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return OrganizationTransformer::class;
    }
}
