<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\User;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\UserType;
use Illuminate\Validation\Rule;

class UserCheckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return match ($this->getMethod()) {
            'POST' => true,
            default => false
        };
    }

    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'email' => ['required', 'email'],
                'user_type_id' => ['required', 'integer', Rule::in(
                    UserType::where('can_register', true)->select('id')->pluck('id')->toArray()
                )],
            ],
            default => []
        };
    }
}
