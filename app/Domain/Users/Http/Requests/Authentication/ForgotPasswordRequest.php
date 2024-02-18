<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\Authentication;

use App\Common\Http\Controllers\FormRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
        ];
    }

    public function emailLinkStatus(): string
    {
        return Password::sendResetLink($this->all());
    }
}
