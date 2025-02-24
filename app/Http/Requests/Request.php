<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Add custom rules.
     *
     * @return array
     */
    protected function addRules(): array
    {
        return [];
    }

    /**
     * Define validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [] + $this->addRules();
    }

    /**
     * Handle invalid json format.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \App\Exceptions\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            $validator,
            $this->jsonResponse($validator->getMessageBag()->toArray())
        );
    }

    /**
     * Get the proper failed validation JSON response for the request.
     *
     * @param  array  $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResponse(array $errors): JsonResponse
    {
        return new JsonResponse([
            'errors' => array_map(function ($field, $error) {
                return [
                    'status' => (string)JsonResponse::HTTP_BAD_REQUEST,
                    'source' => ['pointer' => $field],
                    'detail' => array_shift($error),
                ];
            }, array_keys($errors), $errors),
        ], JsonResponse::HTTP_BAD_REQUEST);
    }
}
