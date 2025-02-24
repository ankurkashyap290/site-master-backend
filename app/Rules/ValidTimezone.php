<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidTimezone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     *
     * @SuppressWarnings("unused")
     */
    public function passes($attribute, $value): bool
    {
        return in_array($value, \DateTimeZone::listIdentifiers());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Must be a valid timezone.';
    }
}
