<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

trait RequestValidationTrait
{
    /**
     * Customize the response for validation errors.
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => [
                'message' => 'Validation failed',
                'status_code' => 422,
                'fields' => $validator->errors()
            ]
        ], 422);

        throw new ValidationException($validator, $response);
    }

    /**
     * Handle failed authorization attempts.
     *
     * @throws HttpResponseException
     */
    protected function failedAuthorization()
    {
        $response = response()->json([
            'error' => [
                'message' => 'You are not authorized to perform this action.',
                'status_code' => 403,
            ]
        ]);

        throw new HttpResponseException($response);
    }

}
