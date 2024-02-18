<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\Authentication;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\UserType;
use Illuminate\Validation\Rule;

class SwapUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_type_id' => ['required', 'integer', Rule::in(
                UserType::select('id')->pluck('id')->toArray()
            )],
        ];
    }
}
