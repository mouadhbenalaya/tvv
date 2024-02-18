<?php

namespace App\Domain\Users\Http\Requests\Permission;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\UserType;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST', 'PUT', 'PATCH' => [
                'name' => ['required', 'string'],
                'description' => ['string', 'nullable'],
            ],
            default => []
        };
    }
}
