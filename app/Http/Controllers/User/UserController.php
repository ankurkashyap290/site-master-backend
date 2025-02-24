<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\User\ListUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Request;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserExistsRequest;
use App\Http\Requests\User\UserResetPasswordRequest;
use App\Mail\ForgotPasswordEmail;
use App\Mail\ResetLinkEmail;
use App\Mail\ResetPasswordEmail;
use App\Mail\UserActivation;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiBaseController
{
    /**
     * @api {post} /users Add new user
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Add new user
     *
     * @apiParam {String="users"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.first_name User first name.
     * @apiParam {String} attributes.middle_name User middle name.
     * @apiParam {String} attributes.last_name User last name.
     * @apiParam {String} attributes.email User email address.
     * @apiParam {String} attributes.phone User phone number.
     * @apiParam {Number} attributes.role_id User role id.
     * @apiParam {Number/null} [attributes.color_id] User color id (used for Master Users or ETC).
     * @apiParam {Object} attributes.organization
     * @apiParam {Number/null} attributes.organization.id User Organization id.
     * @apiParam {Object} attributes.facility
     * @apiParam {Number/null} attributes.facility.id User Facility id.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "users",
     *            "attributes": {
     *                "first_name": "Greenfield",
     *                "middle_name": "",
     *                "last_name": "Jones",
     *                "email": "jones.greenfield@journey.test",
     *                "phone": "123-456",
     *                "role_id": 1,
     *                "color_id": null,
     *                "organization": {
     *                    "id": 1
     *                },
     *                "facility": {
     *                    "id": null
     *                }
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String/null} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {String} attributes.phone User phone number.
     * @apiSuccess {Number} attributes.role_id User role id.
     * @apiSuccess {Object/null} attributes.color_id User color id (used for Master Users or ETC).
     * @apiSuccess {Object} attributes.organization
     * @apiSuccess {Number/null} attributes.organization.id User Organization id.
     * @apiSuccess {String} attributes.organization.name User Organization name.
     * @apiSuccess {Object} attributes.facility
     * @apiSuccess {Number/null} attributes.facility.id User Facility id.
     * @apiSuccess {String} attributes.facility.name User Facility name.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "users",
     *            "id": "4",
     *            "attributes": {
     *                "first_name": "Greenfield",
     *                "middle_name": null,
     *                "last_name": "Jones",
     *                "email": "jones.greenfield@journey.test",
     *                "phone": "123-789",
     *                "role_id": 1,
     *                "color_id": null,
     *                "organization": {
     *                    "id": 1,
     *                    "name": "Silver Pine Ltd."
     *                },
     *                "facility": {
     *                    "id": null,
     *                    "name": ""
     *                }
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/users/4"
     *            }
     *        }
     *    }
     *
     * @apiError Unique-email Same email not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Unique email
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.email"
     *                  },
     *                  "detail": "User email must be unique."
     *              }
     *          ]
     *      }
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
     *                  "detail": "The data.attributes must contain 7 items."
     *              },
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.email"
     *                  },
     *                  "detail": "The data.attributes.email field is required."
     *              }
     *          ]
     *      }
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return Response
     */
    public function store(StoreUserRequest $request): Response
    {
        $user = $this->repository->store($request->only('data'));
        Mail::to($user->email)->send(new UserActivation($user, $user->getNewActivationToken()));
        return $this->item($user, Response::HTTP_CREATED);
    }

    /**
     * @api {get} /users Get user list
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup Users
     * @apiName Get user list (filterable)
     *
     * @apiParam {Number} [role_id] Filter by role id.
     * @apiParam {String="first_name","email","role_id"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {String} attributes.phone User phone number.
     * @apiSuccess {Number} attributes.role_id User role id.
     * @apiSuccess {Number/null} attributes.color_id User color id (used for Master Users or ETC).
     * @apiSuccess {Object} attributes.organization
     * @apiSuccess {Number/null} attributes.organization.id User Organization id.
     * @apiSuccess {String} attributes.organization.name User Organization name.
     * @apiSuccess {Object} attributes.facility
     * @apiSuccess {Number/null} attributes.facility.id User Facility id.
     * @apiSuccess {String} attributes.facility.name User Facility name.
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
     *                "type": "users",
     *                "id": "1",
     *                "attributes": {
     *                    "first_name": "Clark",
     *                    "middle_name": "",
     *                    "last_name": "Kent",
     *                    "email": "sa@journey.test",
     *                    "phone": "123-456",
     *                    "role_id": 1,
     *                    "color_id": null,
     *                    "organization": {
     *                        "id": null,
     *                        "name": ""
     *                    },
     *                    "facility": {
     *                        "id": null,
     *                        "name": ""
     *                    }
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/users/1"
     *                }
     *            },
     *            {
     *                "type": "users",
     *                "id": "2",
     *                "attributes": {
     *                    "first_name": "Sylvester",
     *                    "middle_name": "Silver",
     *                    "last_name": "Pine",
     *                    "email": "oa@silverpine.test",
     *                    "phone": "123-456",
     *                    "role_id": 2,
     *                    "color_id": null,
     *                    "organization": {
     *                        "id": 1,
     *                        "name": "Silver Pine Ltd."
     *                    },
     *                    "facility": {
     *                        "id": null,
     *                        "name": ""
     *                    }
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/users/2"
     *                }
     *            },
     *            {
     *                "type": "users",
     *                "id": "3",
     *                "attributes": {
     *                    "first_name": "Sylvia",
     *                    "middle_name": "Silver",
     *                    "last_name": "Pine",
     *                    "email": "id@silverpine.test",
     *                    "phone": "123-456",
     *                    "role_id": 5,
     *                    "color_id": 1,
     *                    "organization": {
     *                        "id": 1,
     *                        "name": "Silver Pine Ltd."
     *                    },
     *                    "facility": {
     *                        "id": 1,
     *                        "name": "Evergreen Retirement Home"
     *                    }
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/users/3"
     *                }
     *            }
     *        ]
     *    }
     */
    /**
     * Display all resources.
     *
     * @param ListUserRequest $request
     * @return Response
     */
    public function index(ListUserRequest $request)
    {
        $users = $this->repository->listByFilters($request->all());
        return $this->pagination($users);
    }

    /**
     * @api {get} /users/:id Get user by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Get specified user
     *
     * @apiParam {Number} id User id
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {Number} attributes.role_id User role id.
     * @apiSuccess {Number/null} attributes.color_id User color id (used for Master Users or ETC).
     * @apiSuccess {Object} attributes.organization
     * @apiSuccess {Number/null} attributes.organization.id User Organization id.
     * @apiSuccess {String} attributes.organization.name User Organization name.
     * @apiSuccess {Object} attributes.facility
     * @apiSuccess {Number/null} attributes.facility.id User Facility id.
     * @apiSuccess {String} attributes.facility.name User Facility name.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "data": {
     *            "type": "users",
     *            "id": "1",
     *            "attributes": {
     *                "first_name": "Clark",
     *                "middle_name": "",
     *                "last_name": "Kent",
     *                "email": "sa@journey.test",
     *                "phone": "123-456",
     *                "role_id": 1,
     *                "color_id": null,
     *                "organization": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facility": {
     *                    "id": null,
     *                    "name": ""
     *                }
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/users/1"
     *            }
     *        }
     *    }
     */
    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  int $id
     *
     * @SuppressWarnings("unused")
     * @return Response
     */
    public function show(Request $request, $id)
    {
        return $this->item($this->repository->find($id));
    }
    /**
     * @api {put/patch} /users/:id Update user
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Update user
     *
     * @apiParam {Number} id User id.
     *
     * @apiParam {String="users"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.first_name User first name.
     * @apiParam {String} attributes.middle_name User middle name.
     * @apiParam {String} attributes.last_name User last name.
     * @apiParam {String} attributes.phone User phone number.
     * @apiParam {Number/null} [attributes.color_id] User color id (used for Master Users or ETC).
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "users",
     *            "attributes": {
     *                "first_name": "Yellowfield",
     *                "middle_name": "",
     *                "last_name": "Jones",
     *                "phone": "123-456"
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String/null} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {String} attributes.phone User phone number.
     * @apiSuccess {Number} attributes.role_id User role id.
     * @apiSuccess {Number} attributes.color_id User color id (used for calendar
     * and we only use for Master Users or ETC).
     * @apiSuccess {Object} attributes.organization
     * @apiSuccess {Number/null} attributes.organization.id User Organization id.
     * @apiSuccess {String} attributes.organization.name User Organization name.
     * @apiSuccess {Object} attributes.facility
     * @apiSuccess {Number/null} attributes.facility.id User Facility id.
     * @apiSuccess {String} attributes.facility.name User Facility name.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "users",
     *            "id": "4",
     *            "attributes": {
     *                "first_name": "Yellowfield",
     *                "middle_name": null,
     *                "last_name": "Jones",
     *                "email": "jones.grenfield@journey.test",
     *                "phone": "123-456",
     *                "role_id": 1,
     *                "color_id": null,
     *                "organization": {
     *                    "id": 1,
     *                    "name": "Silver Pine Ltd."
     *                },
     *                "facility": {
     *                    "id": null,
     *                    "name": ""
     *                }
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/users/4"
     *            }
     *        }
     *    }
     *
     * @apiError Unique-email Same email not allowed
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Unique email
     *      HTTP/1.1 400 Bad Request
     *      {
     *          "errors": [
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.email"
     *                  },
     *                  "detail": "User email must be unique."
     *              }
     *          ]
     *      }
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
     *                  "detail": "The data.attributes must contain 7 items."
     *              },
     *              {
     *                  "status": "400",
     *                  "source": {
     *                      "pointer": "data.attributes.email"
     *                  },
     *                  "detail": "The data.attributes.email field is required."
     *              }
     *          ]
     *      }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        return $this->item($this->repository->update($request->only('data'), $id), Response::HTTP_OK);
    }

    /**
     * @api {put} /users/reset-password/:id Reset user password
     * @apiPermission Organization Admin/Facility Admin
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Reset user password
     *
     * @apiParam {Number} id User id.
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": null
     *    }
     */
    /**
     * @param UserResetPasswordRequest $request
     * @param $id
     * @return Response
     *
     * @SuppressWarnings("unused")
     */
    public function resetPassword(UserResetPasswordRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = null;
        $user->saveOrFail();

        $user->deleteResetEmailToken();
        Mail::to($user->email)
            ->send(new ResetPasswordEmail(auth()->user()->getFullName(), $user, $user->getNewResetEmailToken()));

        return $this->null();
    }

    /**
     * @api {delete} /users/:id Delete User
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Users
     * @apiName Delete facility
     *
     * @apiParam {Number} id User id.
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     *
     * @SuppressWarnings("unused")
     */
    public function destroy(Request $request, $id)
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
        return 'App\Repositories\User\UserRepository';
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\User\UserTransformer';
    }
}
