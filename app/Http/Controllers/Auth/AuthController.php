<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Config;

class AuthController extends ApiBaseController
{
    /**
     * @api {post} /auth/login Login user
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Login user
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *          "Accept":"application/json",
     *          "Content-Type":"application/json"
     *     }
     *
     * @apiParam {String="login"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.email User login email address.
     * @apiParam {String} attributes.password User login password.
     *
     * @apiParamExample {json} Login request:
     *    body:
     *    {
     *        "data": {
     *            "type": "login",
     *            "attributes": {
     *                "email": "test@example.com",
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
     * @apiSuccess {Object} attributes.role
     * @apiSuccess {Number} attributes.role.id User role id.
     * @apiSuccess {String} attributes.role.name User role name.
     * @apiSuccess {Object/null} attributes.color User color (for Master Users only).
     * @apiSuccess {Number} [attributes.color.id] User color id.
     * @apiSuccess {Char} [attributes.color.value] User color value must be a HEX without # (hashtag).
     * @apiSuccess {Enum="internal", "external"} [attributes.color.type] Driver type (Color depends on Driver type).
     * @apiSuccess {Object} attributes.organization
     * @apiSuccess {Number/null} attributes.organization.id User Organization id.
     * @apiSuccess {String} attributes.organization.name User Organization name.
     * @apiSuccess {Object} attributes.facility
     * @apiSuccess {Number/null} attributes.facility.id User Facility id.
     * @apiSuccess {String} attributes.facility.name User Facility name.
     * @apiSuccess {Object[]} attributes.facilities All Facilities related to the User.
     * @apiSuccess {Object[]} attributes.policies User policies.
     * @apiSuccess {Number} attributes.policies.facility_id Facility ID.
     * @apiSuccess {Number} attributes.policies.role_id Role ID.
     * @apiSuccess {String} attributes.policies.entity Entity name.
     * @apiSuccess {Number} attributes.policies.view View access boolean.
     * @apiSuccess {Number} attributes.policies.create Create access boolean.
     * @apiSuccess {Number} attributes.policies.update Update access boolean.
     * @apiSuccess {Number} attributes.policies.delete Delete access boolean.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "users",
     *            "id": "1",
     *            "attributes": {
     *                "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
     *                "token_type": "bearer",
     *                "expires_in": 1800,
     *                "first_name": "Clark",
     *                "middle_name": "",
     *                "last_name": "Kent",
     *                "email": "sa@journey.test",
     *                "role": {
     *                    "id": 1,
     *                    "name": "Super Admin"
     *                },
     *                "color": null,
     *                "organization": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facility": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facilities": [],
     *                "policies": [
     *                    {
     *                        "id": 2,
     *                        "facility_id": 1,
     *                        "role_id": 6,
     *                        "entity": "TransportLog",
     *                        "view": 1,
     *                        "create": 0,
     *                        "update": 0,
     *                        "delete": 0,
     *                    },
     *                ]
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/user/1"
     *            }
     *        }
     *    }
     *
     * @apiError Unauthorized Login failed.
     * @apiError BadRequest Missing/Wrong api parameters.
     *
     * @apiErrorExample Unauthorized
     *     HTTP/1.1 401 Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "detail": "Unauthorized"
     *            }
     *        ]
     *    }
     *
     * @apiErrorExample {json} BadRequest
     *    {
     *        "errors": [
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes"
     *                },
     *                "detail": "The data.attributes must contain 2 items."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.password"
     *                },
     *                "detail": "The data.attributes.password field is required."
     *            }
     *        ]
     *    }
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('data')['data']['attributes'];
        $user = User::getByEmail($credentials['email']);

        if (!$user) {
            throw new AuthorizationException('Invalid email!');
        }

        if ($user->isBlocked()) {
            $blockTime = Config::get('auth.attempts.block_time');
            throw new AuthorizationException("Too many login attempts! Please try again in {$blockTime} minutes.");
        }

        if (!auth()->attempt($credentials)) {
            $user->logLoginAttempt(false);
            throw new AuthorizationException('Invalid password!');
        }

        if (!$user->isAuthorizedForLogin()) {
            $user->logLoginAttempt(false);
            throw new AuthorizationException('Inactivated user!');
        }
        
        $user->logLoginAttempt(true);
        return $this->item($user);
    }

    /**
     * @api {get} /auth/me Get logged in user info
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Get user info
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json",
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
     *     }
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {Object} attributes.role
     * @apiSuccess {Number} attributes.role.id User role id.
     * @apiSuccess {String} attributes.role.name User role name.
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
     * @apiSuccess {Object[]} attributes.facilities All Facilities related to the User.
     * @apiSuccess {Object[]} attributes.policies User policies.
     * @apiSuccess {Number} attributes.policies.facility_id Facility ID.
     * @apiSuccess {Number} attributes.policies.role_id Role ID.
     * @apiSuccess {String} attributes.policies.entity Entity name.
     * @apiSuccess {Number} attributes.policies.view View access boolean.
     * @apiSuccess {Number} attributes.policies.create Create access boolean.
     * @apiSuccess {Number} attributes.policies.update Update access boolean.
     * @apiSuccess {Number} attributes.policies.delete Delete access boolean.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "user",
     *            "id": "1",
     *            "attributes": {
     *                "first_name": "Clark",
     *                "middle_name": "",
     *                "last_name": "Kent",
     *                "email": "sa@journey.test",
     *                "role": {
     *                    "id": 1,
     *                    "name": "Super Admin"
     *                },
     *                "color": null,
     *                "organization": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facility": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facilities": [],
     *                "policies": [
     *                    {
     *                        "id": 2,
     *                        "facility_id": 1,
     *                        "role_id": 6,
     *                        "entity": "TransportLog",
     *                        "view": 1,
     *                        "create": 0,
     *                        "update": 0,
     *                        "delete": 0,
     *                    },
     *                ],
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/user/1"
     *            }
     *        }
     *    }
     *
     * @apiError Unauthorized User not logged in
     *
     * @apiErrorExample {json} Unauthorized
     *     HTTP/1.1 401  Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "source": {
     *                    "pointer": "Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"
     *                },
     *                "detail": "Token not provided"
     *            }
     *        ]
     *    }
     */
    public function getUser()
    {
        return $this->item(auth()->user());
    }

    /**
     * @api {post} /auth/logout Log out user
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Logout user
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json",
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
     *     }
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    {
     *        "data": null
     *    }
     *
     * @apiError  Unauthorized User not logged in
     * @apiError Repeated User multiple logout
     *
     * @apiErrorExample {json}  Unauthorized
     *     HTTP/1.1 401  Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "source": {
     *                    "pointer": "Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"
     *                },
     *                "detail": "Token not provided"
     *            }
     *        ]
     *    }
     *
     * @apiErrorExample {json} Repeated
     *     HTTP/1.1 401 Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "source": {
     *                    "pointer": "Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"
     *                },
     *                "detail": "The token has been blacklisted"
     *            }
     *        ]
     *    }
     *
     */
    public function logout()
    {
        auth()->logout();
        return $this->null();
    }

    /**
     * @api {post} /auth/refresh Get a fresh token
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Get a fresh token
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept": "application/json",
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
     *     }
     *
     * @apiSuccess {String="users"} type Response type.
     * @apiSuccess {Number} id User id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.first_name User first name.
     * @apiSuccess {String} attributes.middle_name User middle name.
     * @apiSuccess {String} attributes.last_name User last name.
     * @apiSuccess {String} attributes.email User email address.
     * @apiSuccess {Object} attributes.role
     * @apiSuccess {Number} attributes.role.id User role id.
     * @apiSuccess {String} attributes.role.name User role name.
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
     * @apiSuccess {Object[]} attributes.facilities All Facilities related to the User.
     * @apiSuccess {Object[]} attributes.policies User policies.
     * @apiSuccess {Number} attributes.policies.facility_id Facility ID.
     * @apiSuccess {Number} attributes.policies.role_id Role ID.
     * @apiSuccess {String} attributes.policies.entity Entity name.
     * @apiSuccess {Number} attributes.policies.view View access boolean.
     * @apiSuccess {Number} attributes.policies.create Create access boolean.
     * @apiSuccess {Number} attributes.policies.update Update access boolean.
     * @apiSuccess {Number} attributes.policies.delete Delete access boolean.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type": "user",
     *            "id": "1",
     *            "attributes": {
     *                "first_name": "Clark",
     *                "middle_name": "",
     *                "last_name": "Kent",
     *                "email": "sa@journey.test",
     *                "role": {
     *                    "id": 1,
     *                    "name": "Super Admin"
     *                },
     *                "color": null,
     *                "organization": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facility": {
     *                    "id": null,
     *                    "name": ""
     *                },
     *                "facilities": [],
     *                "policies": [
     *                    {
     *                        "id": 2,
     *                        "facility_id": 1,
     *                        "role_id": 6,
     *                        "entity": "TransportLog",
     *                        "view": 1,
     *                        "create": 0,
     *                        "update": 0,
     *                        "delete": 0,
     *                    },
     *                ],
     *            },
     *            "links": {
     *                "self": "http://api.journey.local/user/1"
     *            }
     *        }
     *    }
     *
     * @apiError Unauthorized User not logged in
     *
     * @apiErrorExample {json} Unauthorized
     *     HTTP/1.1 401  Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "source": {
     *                    "pointer": "Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"
     *                },
     *                "detail": "Token not provided"
     *            }
     *        ]
     *    }
     */
    public function refresh()
    {
        auth()->refresh();
        return $this->item(auth()->user());
    }

    /**
     * Get transformer type.
     */
    protected function getTransformerType(): string
    {
        return 'App\Transformers\Auth\AuthUserTransformer';
    }
}
