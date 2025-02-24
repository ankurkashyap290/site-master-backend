<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\ForgotPasswordEmail;
use App\Models\Auth\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends ApiBaseController
{
    /**
     * @api {post} /auth/forgot-password Get reset token by e-mail
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Send reset token e-mail
     *
     * @apiParam {String} attributes.email User email.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "attributes": {
     *                "email": "jones.greenfield@journey.test"
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
     * @apiError BadRequest Missing/Wrong api parameters.
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
     *                    "pointer": "data.attributes.email"
     *                },
     *                "detail": "The data.attributes.email field is required."
     *            }
     *        ]
     *     }
     */
    /**
     * @param ForgotPasswordRequest $request
     * @return Response
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $email = $request->only('data')['data']['attributes']['email'];
        $user = User::withoutGlobalScopes()->where('email', $email)->first();

        $user->deleteResetEmailToken();

        Mail::to($email)->send(new ForgotPasswordEmail($user, $user->getNewResetEmailToken()));

        return $this->null();
    }

    /**
     * @api {post} /auth/reset-password Reset password
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiGroup Authentication
     * @apiName Reset password using reset token
     *
     * @apiParam {String} attributes.token Reset password token (sent by email)
     * @apiParam {String} attributes.password New password for user
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data": {
     *            "attributes": {
     *                "token": "JDJ5JDEwJGh1dThydDguanMxWFZ2NkQwcy4uRU83RHdrYjFXeTk4QjduQ0RqZWQ0cGI3UDRZNUt6Y20u",
     *                "password": "secret"
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
     * @apiError Bad-Request Wrong token sent.
     * @apiError Bad-Request Missing/Wrong api parameters.
     *
     * @apiErrorExample {json} Bad-Request
     *    HTTP/1.1 400 Bad-Request
     *    {
     *      "errors": [
     *        {
     *          "status": "400",
     *          "source": {
     *            "pointer": "data.attributes.token"
     *          },
     *          "detail": "The selected data.attributes.token is invalid."
     *        }
     *      ]
     *    }
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
    /**
     * @param ResetPasswordRequest $request
     * @return Response
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        PasswordReset::dropExpiredResetEmailTokens();

        $dataAttributes = $request->only('data')['data']['attributes'];
        $user = User::getUserByResetLinkToken($dataAttributes['token']);
        $user->password = Hash::make($dataAttributes['password']);
        $user->saveOrFail(['unprotected' => true]);
        $user->deleteResetEmailToken();

        return $this->null();
    }
}
