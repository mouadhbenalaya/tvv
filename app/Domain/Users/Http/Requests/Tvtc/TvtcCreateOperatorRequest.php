<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\Tvtc;

use App\Common\Http\Controllers\FormRequest;
use App\Common\Models\Country;
use App\Domain\Users\Models\Department;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Validation\Rule;

class TvtcCreateOperatorRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'first_name' => ['string', 'required'],
                'second_name' => ['string', 'nullable'],
                'third_name' => ['string', 'nullable'],
                'last_name' => ['string', 'required'],
                'id_number' => ['string', 'required', Rule::notIn(User::select('id_number')->pluck('id_number'))],
                'email' => ['string', 'required', 'email', Rule::notIn(User::select('email')->pluck('email'))],
                'ad_user_name' => ['string', 'required'],
                'department_id' => ['integer', 'required', Rule::in(Department::select('id')->pluck('id'))],
                'lives_in_saudi_arabi' => ['boolean', Rule::in([true, false]), 'required'],
                'country_id' => ['integer', 'required', Rule::in(Country::select('id')->pluck('id'))],
                'mobile_number' => ['string', 'required'],
            ],
            default => []
        };
    }

    public function getProfileData(): array
    {
        return [
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TVTC_OPERATOR)->first()?->id,
            'ad_user_name' => $this->input('ad_user_name'),
            'department_id' => $this->input('department_id'),
        ];
    }

    public function getUserFields(): array
    {
        return [
            'first_name',
            'second_name',
            'third_name',
            'last_name',
            'id_number',
            'email',
            'lives_in_saudi_arabi',
            'country_id',
            'mobile_number',
        ];
    }
}
