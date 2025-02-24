<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidPassengers implements Rule
{
    protected $message = 'Invalid passenger data.';

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
            $this->message = 'No passengers assigned.';
            return false;
        }
        $names = [];
        foreach ($value as $item) {
            if (empty($item)) {
                $this->message = 'Missing passenger data.';
                return false;
            }
            $validator = Validator::make($item, [
                'id' => 'nullable|integer|exists:passengers',
                'client_id' => 'nullable|integer|exists:clients,id',
                'name' => 'required|string|max:255',
                'room_number' => 'nullable|string|max:255',
                'appointments' => 'required',
            ]);
            if ($validator->fails()) {
                $this->message = implode(' ', $validator->messages()->all());
                return false;
            }

            if (in_array($item['name'], $names)) {
                $this->message = 'Duplicated passenger data.';
                return false;
            }
            $names[] = $item['name'];

            $appointmentsRule = new ValidAppointments();
            if (!$appointmentsRule->passes('appointments', $item['appointments'])) {
                $this->message = $appointmentsRule->message();
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
