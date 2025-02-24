<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ValidDrivers implements Rule
{
    protected $message = 'Invalid driver data.';
    protected $requiredFields;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($requiredFields = [])
    {
        $this->requiredFields = $requiredFields;
    }

    protected function isRequired($fieldName)
    {
        return in_array($fieldName, $this->requiredFields);
    }

    protected function required($fieldName)
    {
        return $this->isRequired($fieldName) ? 'required' : 'nullable';
    }

    protected function getValidator($item)
    {
        if (isset($item['etc_id'])) {
            $this->requiredFields = ['etc_id'];
        } elseif (isset($item['user_id'])) {
            $this->requiredFields[] = ['user_id'];
        } elseif (isset($item['name'])) {
            $this->requiredFields = ['name', 'emails', 'pickup_time', 'fee'];
        }
        return Validator::make($item, [
            'id' => $this->required('id') . '|integer|exists:drivers',
            'etc_id' => $this->required('etc_id') . '|integer|exists:external_transportation_companies,id',
            'user_id' => $this->required('user_id') . '|integer|exists:users,id',
            'status' => $this->required('status') . '|string|max:255',
            'name' => $this->required('name') . '|string|max:255',
            'emails' => $this->required('emails') . '|string|max:255',
            'pickup_time' => $this->required('pickup_time') . '|regex:/[0-2][0-9]:[0-5][0-9]:[0-5][0-9]/',
            'fee' => $this->required('fee') . '|regex:/[+-]?([0-9]*[.])?[0-9]+/',
        ]);
    }

    protected function hasDuplicatedData($item, $etcIds, $userIds, $names)
    {
        return (
            !empty($item['etc_id']) && in_array($item['etc_id'], $etcIds)
        ) || (
            !empty($item['user_id']) && in_array($item['user_id'], $userIds)
        ) || (
            !empty($item['name']) && in_array($item['name'], $names)
        );
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     *
     * @SuppressWarnings(PHPMD)
     */
    public function passes($attribute, $value): bool
    {
        if (!count($value)) {
            $this->message = 'No drivers assigned.';
            return false;
        }
        $etcIds = [];
        $userIds = [];
        $names = [];
        foreach ($value as $item) {
            if (empty($item)) {
                $this->message = 'Missing driver data.';
                return false;
            }
            $validator = $this->getValidator($item);
            if ($validator->fails()) {
                $this->message = implode(' ', $validator->messages()->all());
                return false;
            }
            if ($this->hasDuplicatedData($item, $etcIds, $userIds, $names)) {
                $this->message = 'Duplicated driver data.';
                return false;
            }
            if (!empty($item['etc_id'])) {
                $etcIds[] = $item['etc_id'];
            }
            if (!empty($item['user_id'])) {
                $userIds[] = $item['user_id'];
            }
            if (!empty($item['name'])) {
                $names[] = $item['name'];
            }
            if (empty($item['etc_id']) && empty($item['user_id']) && empty($item['name'])) {
                $this->message = 'Missing driver name.';
                return false;
            }
        }
        if (count($names) > 1) {
            $this->message = 'Only one unapproved external driver allowed.';
            return false;
        }
        if (count($userIds) > 1) {
            $this->message = 'Only one internal driver allowed.';
            return false;
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
