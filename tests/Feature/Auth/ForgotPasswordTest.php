<?php

namespace Tests\Feature;

use App\Models\Auth\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordTest extends ApiTestBase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        Mail::fake();
        $this->user = User::withoutGlobalScopes()->first();
    }

    /**
     * @group forgot-password
     */
    public function testWeCanGotForgotPasswordToken()
    {
        $response = $this->postJsonRequest(
            route('auth.forgot-password'),
            [
                "data" => [
                    "attributes" => [
                        "email" => $this->user->email,
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertNotEmpty(PasswordReset::where('email', '=', $this->user->email)->first());
    }

    /**
    * @group forgot-password
    */
    public function testWeCanGotNewForgotPasswordTokenAfterWeRequestNew()
    {
        $response = $this->postJsonRequest(
            route('auth.forgot-password'),
            [
                "data" => [
                    "attributes" => [
                        "email" => $this->user->email,
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $db_token_row = PasswordReset::where('email', '=', $this->user->email)->first();
        $this->assertNotEmpty($db_token_row);
        $token = $db_token_row->token;
        $response = $this->postJsonRequest(
            route('auth.forgot-password'),
            [
                "data" => [
                    "attributes" => [
                        "email" => $this->user->email,
                    ]
                ]
            ]
        );
        $db_token_row = PasswordReset::where('email', '=', $this->user->email)->first();
        $this->assertNotEmpty($db_token_row);
        $this->assertNotEquals($token, $db_token_row->token);
    }

    /**
     * @group forgot-password
     */
    public function testWeCantGotForgotPasswordTokenWithWrongEmail()
    {
        $response = $this->postJsonRequest(
            route('auth.forgot-password'),
            [
                "data" => [
                    "attributes" => [
                        "email" => "wrong@email.com",
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group forgot-password
     */
    public function testWeCanResetPassword()
    {
        $response = $this->postJsonRequest(
            route('auth.forgot-password'),
            [
                "data" => [
                    "attributes" => [
                        "email" => $this->user->email,
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        $token = PasswordReset::where('email', '=', $this->user->email)->first()->token;
        $password = "tooSecret";
        $response = $this->postJsonRequest(
            route('auth.reset-password'),
            [
                "data" => [
                    "attributes" => [
                        "token" => $token,
                        "password" => $password
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertNull(PasswordReset::where('email', '=', $this->user->email)->first());
        $this->assertTrue(
            Hash::check(
                $password,
                User::withoutGlobalScopes()->where('email', '=', $this->user->email)->first()->password
            )
        );
    }

    /**
     * @group forgot-password
     */
    public function testWeCantResetPasswordWithWrongToken()
    {
        $response = $this->postJsonRequest(
            route('auth.forgot-password'),
            [
                "data" => [
                    "attributes" => [
                        "email" => $this->user->email,
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        $password = "tooSecret";
        $response = $this->postJsonRequest(
            route('auth.reset-password'),
            [
                "data" => [
                    "attributes" => [
                        "token" => "wrong token",
                        "password" => $password
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }
}
