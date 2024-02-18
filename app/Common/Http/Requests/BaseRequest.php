<?php

namespace App\Common\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        $response = new JsonResponse(
            [
                'status' => 'fail',
                'data' => $validator->errors()
            ],
            422
        );

        throw new ValidationException($validator, $response);
    }

    public function messages(): array
    {
        return [
            'required' => 'It is mandatory to inform the :attribute.'
        ];
    }
}
