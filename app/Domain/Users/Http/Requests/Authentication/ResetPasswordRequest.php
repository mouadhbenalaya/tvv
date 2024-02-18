<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\Authentication;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\User;
use Illuminate\Support\Facades\Password;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed'],
            'token' => ['required', 'string'],
        ];
    }

    public function changePasswordStatus(): mixed
    {
        return Password::reset($this->all(), static function (User $user, string $password) {
            $user->password = $password;
            $user->save();
        });
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['token'] = $this->route('token');

        return $data;
    }
}
