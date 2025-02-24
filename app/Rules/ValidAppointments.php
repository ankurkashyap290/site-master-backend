<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidAppointments implements Rule
{
    protected $message = 'Invalid appointment data.';

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
        if (!count($value)) {
            $this->message = 'No appointments assigned.';
            return false;
        }
        foreach ($value as $item) {
            if (empty($item)) {
                $this->message = 'Missing appointment data.';
                return false;
            }
            $validator = Validator::make($item, [
                'id' => 'nullable|integer|exists:appointments',
                'time' => 'required|date_format:H:i:s',
                'location_id' => 'required|integer|exists:locations,id',
            ]);
            if ($validator->fails()) {
                $this->message = implode(' ', $validator->messages()->all());
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
