<?php

namespace Tests;

use Tests\Constraints\IsValidJsonResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    public function setUp()
    {
        parent::setUp();
    }

    public function assertValidJsonResponse($response)
    {
        self::assertThat($response, new IsValidJsonResponse());
    }
}
