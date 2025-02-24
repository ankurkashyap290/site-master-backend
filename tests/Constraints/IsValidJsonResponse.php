<?php

/**
 * Validate json response.
 */

namespace Tests\Constraints;

use League\JsonGuard\Validator;
use PHPUnit\Framework\Constraint\Constraint;
use League\JsonReference\Dereferencer;

class IsValidJsonResponse extends Constraint
{

    /**
     * Run json schema validator.
     *
     * @param $other string
     * @return bool
     */
    protected function matches($other): bool
    {
        $response = json_decode($other);
        $dereferencer = new Dereferencer();
        $schema = $dereferencer->dereference('file://' . __DIR__ . '/JsonSchema.json');
        $validator = new Validator($response, $schema);
        return $validator->passes();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString(): string
    {
        return 'is a valid json response';
    }
}
