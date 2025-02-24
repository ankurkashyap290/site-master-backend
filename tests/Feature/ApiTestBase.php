<?php

/**
 * Test APIs.
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class ApiTestBase extends TestCase
{
    use RefreshDatabase;

    protected $longText = <<<'KAFKA'
         One morning, when Gregor Samsa woke from troubled dreams,
         he found himself transformed in his bed into a horrible vermin.
         He lay on his armour-like back, and if he lifted his head a little he could see his brown belly,
         slightly domed and divided by arches into stiff sections. The bedding was hardly.
KAFKA;

    /**
     * @var User email address
     */
    protected $email = 'sa@journey.test';

    /**
     * @var User password
     */
    protected $password = 'secret';

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Load a config file manually, since facades do not work when setting up tests
     * @param string $file
     * @return mixed
     */
    protected function config($file)
    {
        return include "config/$file.php";
    }

    /**
     * Login test user.
     */
    protected function login($email = null)
    {
        $credential = ['email' => $email ?: $this->email, 'password' => $this->password];
        $this->loggedToken = auth()->attempt($credential);
    }

    /**
     * Logout test user.
     */
    protected function logout()
    {
        auth()->logout();
    }

    /**
     * Create a json request.
     *
     * @param string $type
     * @param string $url
     * @param array $jsonData
     * @param array $header
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function jsonRequest($type, $url, $jsonData = [], $header = [])
    {
        $header = $header + $this->getHeaderData();
        $response = $this->json(
            $type,
            $url,
            $jsonData,
            $header
        );

        // If response with content.
        if ($response->getStatusCode() != Response::HTTP_NO_CONTENT) {
            $this->assertValidJsonResponse($response->content());
        }
        return $response;
    }

    /**
     * Create a json post request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function postJsonRequest($url, $jsonData, $header = [])
    {
        return $this->jsonRequest('POST', $url, $jsonData, $header);
    }

    /**
     * Create a json put request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function putJsonRequest($url, $jsonData, $header = [])
    {
        return $this->jsonRequest('PUT', $url, $jsonData, $header);
    }

    /**
     * Create a json put request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function getJsonRequest($url, $jsonData = [], $header = [])
    {
        return $this->jsonRequest('GET', $url, $jsonData, $header);
    }

    /**
     * Create a json delete request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function deleteJsonRequest($url, $jsonData = [], $header = [])
    {
        return $this->jsonRequest('DELETE', $url, $jsonData, $header);
    }

    /**
     * Get default header data.
     *
     * @return array
     */
    protected function getHeaderData()
    {
        $header = [
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];
        if (!empty($this->loggedToken)) {
            $header['Authorization'] = 'Bearer ' . $this->loggedToken;
        }

        return $header;
    }
}
