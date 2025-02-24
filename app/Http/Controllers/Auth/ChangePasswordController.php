<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Mail\ChangeLinkEmail;
use App\Models\Auth\PasswordChange;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Auth\SendsPasswordChangeEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ChangePasswordController extends ApiBaseController
{
    /**
     * @api {post} /auth/change-password Change password
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Change password of authenticated user
     *
     * @apiParam {String} attributes.password New password for user
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "attributes": {
     *                "old_password": "secret",
     *                "new_password": "super-secret"
     *            }
     *        }
     *    }
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "data": null,
     *    }
     *
     * @apiError Bad-Request Missing/Wrong api parameters.
     *
     * @apiErrorExample {json} Bad-Request
     *     HTTP/1.1 400 Bad-Request
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
     *                    "pointer": "data.attributes.old_password"
     *                },
     *                "detail": "The data.attributes.old_password field is required."
     *            }
     *        ]
     *     }
     */
    /**
     * @param ChangePasswordRequest $request
     * @return Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $dataAttributes = $request->only('data')['data']['attributes'];
        $user = auth()->user();
        $user->password = Hash::make($dataAttributes['new_password']);
        $user->saveOrFail();

        return $this->null();
    }
}
