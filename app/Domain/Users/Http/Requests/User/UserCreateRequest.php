<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\User;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use App\Domain\Users\Rules\PasswordRule;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'first_name' => ['string', 'required'],
                'second_name' => ['string', 'nullable'],
                'third_name' => ['string', 'nullable'],
                'last_name' => ['string', 'required'],
                'email' => ['string', 'required', 'email', Rule::notIn(User::select('email')->pluck('email'))],
                'id_number' => ['string', 'required', Rule::notIn(User::select('id_number')->pluck('id_number'))],
                'mobile_number' => ['string', 'required'],
                'password' => ['string', 'required', new PasswordRule()],
                'lives_in_saudi_arabi' => ['boolean', Rule::in([true, false]), 'required'],
                'country_id' => ['integer', 'required'],
                'user_type_id' => ['integer' ,'required', Rule::in(UserType::select('id')->pluck('id'))],
            ],
            default => []
        };
    }

    public function getUserTypeId(): int
    {
        return $this->request->getInt('user_type_id');
    }

    public function getFields(): array
    {
        return [
            'first_name',
            'second_name',
            'third_name',
            'last_name',
            'email',
            'id_number',
            'password',
            'mobile_number',
            'lives_in_saudi_arabi',
            'country_id',
        ];
    }
}
