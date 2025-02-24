<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiBaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\ActivableUserRequest;
use App\Http\Requests\Auth\ActivateUserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Transformers\User\UserTransformer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Access\AuthorizationException;

class ActivationController extends ApiBaseController
{
    /**
     * @api {get} /activation/activable-user Get activable user info
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiGroup Activation
     * @apiName Get pre-activated user info
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json",
     *       "Content-Type": "application/json"
     *     }
     *
     * @apiParam {String="users"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {Number} attributes.id User id.
     * @apiParam {String} attributes.token User access token (sent by email).

     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "users",
     *            "attributes": {
     *                "id": 4,
     *                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
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
     * @apiSuccess {Object/null} attributes.color User color (used for calendar
     * and we only use for Master Users or ETC).
     * @apiSuccess {Number} [attributes.color.id] User color id.
     * @apiSuccess {Char} [attributes.color.value] User color value must be a HEX without # (hashtag).
     * @apiSuccess {Enum="internal", "external"} [attributes.color.type] Driver type (Color depends on Driver type).
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
     *            "id": "4",
     *            "attributes": {
     *                "first_name": "Greenfield",
     *                "middle_name": null,
     *                "last_name": "Jones",
     *                "email": "jones.greenfield@journey.test",
     *                "role_id": 1,
     *                "color": null,
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
     * @apiError Unauthorized Wrong token sent.
     * @apiError BadRequest Missing/Wrong api parameters.
     *
     * @apiErrorExample {json} Unauthorized
     *    HTTP/1.1 401 Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "detail": "Unauthorized Activation Token"
     *            }
     *        ]
     *    }
     *
     * @apiErrorExample {json} BadRequest
     *     HTTP/1.1 400 BadRequest
     *     {
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
     *                    "pointer": "data.attributes.id"
     *                },
     *                "detail": "The data.attributes.id field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.token"
     *                },
     *                "detail": "The data.attributes.token field is required."
     *            }
     *        ]
     *     }
     */
    public function getActivableUser(ActivableUserRequest $request)
    {
        $data = $request->all()['data'];
        $user = User::withoutGlobalScopes()->findOrFail($data['attributes']['id']);
        if (!$user->checkActivationToken($data['attributes']['token'])) {
            throw new AuthorizationException('Invalid activation token!');
        }
        $this->setTransformer('App\Transformers\User\UserTransformer');
        return $this->item($user);
    }

    /**
     * @api {post} /activation/activate-user Activate user
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiGroup Activation
     * @apiName Activate user and log in to system
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json"
     *       "Content-Type": "application/json"
     *     }
     *
     * @apiParam {String="users"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {Number} attributes.id User id.
     * @apiParam {String} attributes.token User access token (sent by email).
     * @apiParam {String} attributes.password User password.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "type": "users",
     *            "attributes": {
     *                "id": 4,
     *                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
     *                "password": "secret"
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.access_token Access token.
     * @apiSuccess {String="Bearer"} attributes.token_type Access token type.
     * @apiSuccess {Number} attributes.expires_in Access token expire time.
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String/null} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {String} attributes.phone User phone number.
     * @apiSuccess {Number} attributes.role_id User role id.
     * @apiSuccess {Object/null} attributes.color User color (used for calendar
     * and we only use for Master Users or ETC).
     * @apiSuccess {Number} [attributes.color.id] User color id.
     * @apiSuccess {Char} [attributes.color.value] User color value must be a HEX without # (hashtag).
     * @apiSuccess {Enum="internal", "external"} [attributes.color.type] Driver type (Color depends from Driver type).
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
     *                "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
     *                "token_type": "bearer",
     *                "expires_in": 1800,
     *                "first_name": "Greenfield",
     *                "middle_name": null,
     *                "last_name": "Jones",
     *                "email": "jones.greenfield@journey.test",
     *                "role_id": 1,
     *                "color": null,
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
     *                "self": "http://api.journey.local/user/4"
     *            }
     *        }
     *    }
     *
     * @apiError Unauthorized Wrong token sent.
     * @apiError BadRequest Missing/Wrong api parameters.
     *
     * @apiErrorExample {json} Unauthorized
     *    HTTP/1.1 401 Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "detail": "Unauthorized Activation Token"
     *            }
     *        ]
     *    }
     *
     * @apiErrorExample {json} BadRequest
     *     HTTP/1.1 400 BadRequest
     *     {
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
     *                    "pointer": "data.attributes.id"
     *                },
     *                "detail": "The data.attributes.id field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.token"
     *                },
     *                "detail": "The data.attributes.token field is required."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.password"
     *                },
     *                "detail": "The data.attributes.password field is required."
     *            }
     *        ]
     *     }
     */
    public function activateUser(ActivateUserRequest $request)
    {
        // activate
        $data = $request->all()['data'];
        $user = User::withoutGlobalScopes()->findOrFail($data['attributes']['id']);
        if (!$user->checkActivationToken($data['attributes']['token'])) {
            throw new AuthorizationException('Invalid activation token!');
        }
        $user->password = Hash::make($data['attributes']['password']);
        $user->saveOrFail(['unprotected' => true]);
        $user->deleteActivationToken();

        // send email
        Mail::to($user->email)->send(new \App\Mail\UserActivated($user));

        // log in
        if (!auth()->attempt(['email' => $user->email, 'password' => $data['attributes']['password']])) {
            return response()->json(['errors' => [[
                'status' => (string)JsonResponse::HTTP_UNAUTHORIZED,
                'detail' =>'Unauthorized'
            ]]], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->item($user);
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
        return 'App\Transformers\Auth\AuthUserTransformer';
    }
}
