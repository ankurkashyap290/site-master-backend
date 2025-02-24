<?php

namespace Tests\Feature;

use App\Models\Auth\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordTest extends ApiTestBase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = User::withoutGlobalScopes()->first();
        $this->email = $this->user->email;
        $this->password = 'secret';
        $this->login();
    }

    /**
     * @group change-password
     */
    public function testWeCanChangePassword()
    {
        $password = "tooSecret";
        $response = $this->postJsonRequest(
            route('auth.change-password'),
            [
                "data" => [
                    "attributes" => [
                        "old_password" => $this->password,
                        "new_password" => $password
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertTrue(
            Hash::check($password, User::where('email', '=', $this->user->email)->firstOrFail()->password)
        );
    }

    /**
     * @group change-password
     */
    public function testWeCantResetPasswordWithInvalidOldPassword()
    {
        $password = "tooSecret";
        $response = $this->postJsonRequest(
            route('auth.change-password'),
            [
                "data" => [
                    "attributes" => [
                        "old_password" => "wrongOldPw",
                        "new_password" => $password
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @group change-password
     */
    public function testWeCantResetPasswordWhenLoggedOut()
    {
        $this->logout();

        $password = "tooSecret";
        $response = $this->postJsonRequest(
            route('auth.change-password'),
            [
                "data" => [
                    "attributes" => [
                        "old_password" => $this->password,
                        "new_password" => $password
                    ]
                ]
            ]
        );
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
