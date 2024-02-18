<?php

namespace App\Common\Http\Controllers;

use App\Application\Exceptions\FormValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        throw new FormValidationException($validator);
    }
}
