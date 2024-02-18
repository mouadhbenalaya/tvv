<?php

namespace App\Domain\Users\Http\Requests\User;

use App\Common\Http\Controllers\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST', 'PUT', 'PATCH' => [
                'name' => ['required', 'string'],
            ],
            default => []
        };
    }
}
