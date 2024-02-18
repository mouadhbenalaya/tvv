<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\User;

use App\Common\Http\Controllers\FormRequest;

class UserValidateRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'GET' => [
                'token' => ['required', 'string'],
            ],
            default => []
        };
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['token'] = $this->route('token');

        return $data;
    }
}
