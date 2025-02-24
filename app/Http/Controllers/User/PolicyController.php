<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Request;
use App\Http\Requests\User\UpdatePolicyRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PolicyController extends ApiBaseController
{
    /**
     * @api {get} /policies Get policy list
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Policies
     * @apiName Get policy list (filterable)
     *
     * @apiParam {Number} [facility_id] Filter by facility id.
     * @apiParam {Number} [role_id] Filter by role id.
     *
     * @apiSuccess {String="policies"} type Response type.
     * @apiSuccess {Number} id Policy id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {Number} attributes.facility_id Facility ID.
     * @apiSuccess {Number} attributes.role_id Role ID.
     * @apiSuccess {String} attributes.entity Entity name.
     * @apiSuccess {Number} attributes.view View access boolean.
     * @apiSuccess {Number} attributes.create Create access boolean.
     * @apiSuccess {Number} attributes.update Update access boolean.
     * @apiSuccess {Number} attributes.delete Delete access boolean.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": [
     *            {
     *                "type": "policies",
     *                "id": "1",
     *                "attributes": {
     *                    "facility_id": 1,
     *                    "role_id": 6,
     *                    "entity": "BillingLog",
     *                    "view": 1,
     *                    "create": 0,
     *                    "update": 0,
     *                    "delete": 0,
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/policies/1"
     *                }
     *            },
     *            {
     *                "type": "policies",
     *                "id": "2",
     *                "attributes": {
     *                    "facility_id": 1,
     *                    "role_id": 6,
     *                    "entity": "BillingLog",
     *                    "view": 0,
     *                    "create": 0,
     *                    "update": 0,
     *                    "delete": 0,
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/policies/2"
     *                }
     *            },
     *        ]
     *    }
     */
    /**
     * Display all resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @SuppressWarnings("unused")
     */
    public function index(Request $request)
    {
        $policies = $this->repository->listByFilters($request->only(['facility_id', 'role_id']));
        return $this->collection($policies);
    }

    /**
     * @api {put/patch} /policies/:id Update policy
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Policies
     * @apiName Update policy
     *
     * @apiParam {Number} id Policy id.
     *
     * @apiParam {String="policies"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {Number} attributes.view View access boolean.
     * @apiParam {Number} attributes.create Create access boolean.
     * @apiParam {Number} attributes.update Update access boolean.
     * @apiParam {Number} attributes.delete Delete access boolean.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "policies",
     *            "attributes": {
     *                "view": 1,
     *                "create": 1,
     *                "update": 1,
     *                "delete": 0,
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="policies"} type Response type.
     * @apiSuccess {Number} id Policy id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {Number} attributes.facility_id Facility ID.
     * @apiSuccess {Number} attributes.role_id Role ID.
     * @apiSuccess {String} attributes.entity Entity name.
     * @apiSuccess {Number} attributes.view View access boolean.
     * @apiSuccess {Number} attributes.create Create access boolean.
     * @apiSuccess {Number} attributes.update Update access boolean.
     * @apiSuccess {Number} attributes.delete Delete access boolean.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "policies",
     *            "id": "4",
     *            "attributes": {
     *                "facility_id": 1,
     *                "role_id": 6,
     *                "entity": "TransportLog",
     *                "view": 1,
     *                "create": 0,
     *                "update": 0,
     *                "delete": 0,
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/policies/4"
     *            }
     *        }
     *    }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePolicyRequest $request, $id)
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
        return 'App\Repositories\User\PolicyRepository';
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\User\PolicyTransformer';
    }
}
