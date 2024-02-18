<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\User;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\User;
use Illuminate\Validation\Rule;

class UserEmailChangeRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'PUT', 'PATCH' => [
                'email' => [
                    'required',
                    'string',
                    'email',
                    Rule::notIn(User::select('email')->pluck('email')),
                ],
            ],
            default => []
        };
    }
}
