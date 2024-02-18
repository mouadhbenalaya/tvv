<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\User;

use App\Application\Contracts\TmpUserRepository;
use App\Application\Contracts\UserRepository;
use App\Common\Http\Controllers\FormRequest;
use App\Common\Models\City;
use App\Common\Models\Country;
use App\Common\Models\Region;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use App\Domain\Users\Rules\PasswordRule;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function __construct(
        private readonly UserRepository    $userRepository,
        private readonly TmpUserRepository $tmpUserRepository,
    ) {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $existingUser = $this->findExistingUser($this->request->getString('token'));
        return match ($this->getMethod()) {
            'POST' => [
                'token' => ['required', 'string', Rule::in(TmpUser::select('validation_token')->pluck('validation_token'))],
                'first_name' => ['string', Rule::requiredIf(null === $existingUser)],
                'second_name' => ['string', 'nullable'],
                'third_name' => ['string', 'nullable'],
                'last_name' => ['string', Rule::requiredIf(null === $existingUser)],
                'id_number' => ['string', Rule::requiredIf(null === $existingUser),
                    function ($attribute, $value, $fail) {
                        if (null !== $this->findUser($this->request->getString('token'), $attribute, $value)) {
                            $fail(sprintf('The %s must be unique', $attribute));
                        }
                    },
                ],
                'mobile_number' => ['string', Rule::requiredIf(null === $existingUser)],
                'password' => ['string', Rule::requiredIf(null === $existingUser), new PasswordRule()],
                'lives_in_saudi_arabi' => ['boolean', Rule::in([true, false]), Rule::requiredIf(null === $existingUser)],
                'country_id' => ['integer', Rule::requiredIf(null === $existingUser), Rule::in(Country::select('id')->pluck('id'))],
            ],
            'PUT', 'PATCH' => [
                'second_name' => ['string', 'nullable'],
                'third_name' => ['string', 'nullable'],
                'email' => ['email', 'unique:users,email, ' . $this->user()?->id .',id'],
                'mobile_number' => ['string'],
                'birth_date' => ['date_format:Y-m-d', 'nullable'],
                'gender' => ['string', Rule::in(['m', 'f'])],
                'nationality_id' => ['integer', Rule::in(Country::select('id')->pluck('id'))],
                'region_id' => ['integer', 'nullable', Rule::in(Region::select('id')->pluck('id'))],
                'city_id' => ['integer', 'nullable', function ($attribute, $value, $fail) {
                    $city = City::where('id', $value)
                        ->where('region_id', $this->request->getInt('region_id'))
                        ->first();
                    if (null === $city) {
                        $fail('City does not belong to region');
                    }
                }],
                'locale' => ['string', Rule::in(['ar', 'en'])],
            ],
            default => []
        };
    }

    private function findUser(string $token, string $attribute, string $value): ?User
    {
        $tmpUser = $this->tmpUserRepository->findValidatedTmpUser($token);
        if ($tmpUser?->email) {
            return $this->userRepository->findExistingUserWithAttribute($tmpUser->email, $attribute, $value);
        }
        return null;
    }

    private function findExistingUser(string $token): ?User
    {
        $tmpUser = $this->tmpUserRepository->findValidatedTmpUser($token);
        if ($tmpUser?->email) {
            return $this->userRepository->findExistingUser($tmpUser->email);
        }
        return null;
    }

    public function getFields(): array
    {
        return [
            'token',
            'first_name',
            'second_name',
            'third_name',
            'last_name',
            'id_number',
            'password',
            'mobile_number',
            'lives_in_saudi_arabi',
            'country_id'
        ];
    }
}
