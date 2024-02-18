<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\Authentication;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use function __;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_type_id' => ['required', 'integer', Rule::in(
                UserType::select('id')->pluck('id')->toArray()
            )],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        if (!Auth::attempt($this->all(['email', 'password']))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
