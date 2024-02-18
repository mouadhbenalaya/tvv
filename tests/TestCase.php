<?php

declare(strict_types=1);

namespace Tests;

use App\Common\Models\Country;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Database\Factories\Domain\Users\Models\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public const USERS_CHECK_ENDPOINT = 'api/v1/users/check';
    public const USERS_VALIDATE_ENDPOINT = 'api/v1/users/validate';
    public const USERS_REGISTER_ENDPOINT = 'api/v1/users/register';
    public const USERS_CREATE_ENDPOINT = 'api/v1/users';
    public const USERS_ENDPOINT = 'api/v1/users/';
    public const USERS_PROFILE_ENDPOINT = 'api/v1/users/profiles/';
    public const USER_PROFILE_ENDPOINT = 'api/v1/auth/profile';
    public const REGISTRATION_TOKEN = 'somerandomtokenforjim';
    public const LOGIN_USER = 'api/v1/auth/login';
    public const SWITCH_USER = 'api/v1/auth/switch';
    public const LOGOUT_USER = 'api/v1/auth/logout';
    public const AUDIT_LOG = 'api/v1/audit-logs';

    protected Country $country;
    protected UserType $userType;
    protected UserType $lastUserType;
    protected TmpUser $tmpUser;
    protected Collection $users;
    protected User $user;
    protected Profile $profile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->country = Country::select()->get()->first();
        $this->userType = UserType::select()->get()->first();
        $this->lastUserType = UserType::select()->orderBy('id', 'DESC')->get()->first();
        $this->tmpUser = TmpUser::select()->get()->first();
        $this->users = User::all();
        $this->user = User::select()->get()->first();
        $this->profile = $this->user->profiles()->first();
    }

    public function withoutAuthorization(): static
    {
        \Gate::before(function () {
            return true;
        });

        return $this;
    }

    protected function getBearerToken($tokenName): string
    {
        return $this->user->createToken($tokenName)->plainTextToken;
    }

    protected function applyAuthHeaders(string $tokenName = 'api_token'): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getBearerToken($tokenName),
            'Accept' => 'application/json',
        ]);
    }

    protected function getUserArray(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@q.agency',
            'password' => 'password',
        ];
    }

    protected function getUserUpdateArray(): array
    {
        return [
            'second_name' => 'Jack',
            'third_name' => null,
            'email' => 'john.doe@example.com',
            'mobile_number' => '09876543210',
            'birth_date' => '1990-01-01',
            'gender' => 'm',
            'nationality_id' => 1,
            'region_id' => 1,
            'city_id' => 2
        ];
    }

    protected function getUserRegisterArray(string $token): array
    {
        return [
            'token' => $token,
            'first_name' => 'John',
            'second_name' => 'Doe',
            'third_name' => null,
            'last_name' => 'Doe',
            'id_number' => '012345678d9',
            'password' => 'Abc123!@#',
            'mobile_number' => '09876543210',
            'lives_in_saudi_arabi' => true,
            'country_id' => 1
        ];
    }

    protected function getUserCreateArray(): array
    {
        return [
            'first_name' => 'John',
            'second_name' => 'Doe',
            'third_name' => null,
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'id_number' => '012345678d9',
            'password' => 'Abc123!@#',
            'mobile_number' => '09876543210',
            'lives_in_saudi_arabi' => true,
            'country_id' => 1,
            'user_type_id' => 1,
        ];
    }

    protected function userStructure(): array
    {
        return [
            'id',
            'first_name',
            'second_name',
            'third_name',
            'last_name',
            'id_number',
            'email',
            'mobile_number',
            'lives_in_saudi_arabi',
            'country' => [
                'id',
                'code_alpha_2',
                'code_alpha_3',
                'code_numeric',
                'name',
            ],
            'profiles' => [
                '*' => [
                    'id',
                    'employee_number',
                    'ad_user_name',
                    'department_id',
                    'facility_id',
                    'user_type' => [
                        'id',
                        'name'
                    ],
                ],
            ],
        ];
    }

    protected function getUserResponse(): array
    {
        return [
            'id' => 1,
            "first_name" => "Jim",
            "second_name" => "Jack",
            "third_name" => null,
            "last_name" => "Jim",
            "id_number" => "321",
            "email" => "jim@example.com",
            "mobile_number" => "09876543210",
            "gender" => "m",
            "lives_in_saudi_arabi" => 0,
            "birth_date" => "1990-01-01T00:00:00+00:00",
            "country" => [
                "id" => 2,
                "code_alpha_2" => "HR",
                "code_alpha_3" => "HRV",
                "code_numeric" => 192,
                "name" => "Croatia",
            ],
            "region" => [
                "id" => 1,
                "code" => "0001",
                "name" => "Riyadh Region",
            ],
            "city" => [
                "id" => 2,
                "code" => "0101",
                "name" => "Diriyah",
            ],
            "nationality" => [
                "id" => 1,
                "code_alpha_2" => "SA",
                "code_alpha_3" => "SAU",
                "code_numeric" => 682,
                "name" => "Saudi Arabia",
            ],
            "current_profile" => null,
            "profiles" => [
                [
                    "id" => 1,
                    "employee_number" => "12345",
                    "ad_user_name" => "username_1",
                    "department_id" => 1,
                    "facility_id" => 1,
                    "user_type" => [
                        "id" => 3,
                        "name" => "Trainee",
                    ],
                ],
                [
                    "id" => 2,
                    "employee_number" => "23456",
                    "ad_user_name" => "username_2",
                    "department_id" => 1,
                    "facility_id" => 1,
                    "user_type" => [
                        "id" => 2,
                        "name" => "Trainer",
                    ],
                ],
                [
                    "id" => 3,
                    "employee_number" => "34567",
                    "ad_user_name" => "username_3",
                    "department_id" => 1,
                    "facility_id" => 1,
                    "user_type" => [
                        "id" => 1,
                        "name" => "Investor",
                    ],
                ],
            ],
        ];
    }
}
