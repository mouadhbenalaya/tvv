<?php

namespace Database\Factories\Domain\Users\Models;

use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'employee_number' => $this->faker->numberBetween(1, 9999),
            'ad_user_name' => $this->faker->userName(),
            'department_id' => 1,
            'facility_id' => 1,
            'user_type_id' => UserType::all()->random()->id,
            'user_id' => User::all()->random()->id
        ];
    }

    public function forUser(User $user): self
    {
        return $this->state(fn () => ['user_id' => $user->id]);
    }

    public function trainee(): self
    {
        return $this->state(fn () => [
            'employee_number' => 12345,
            'ad_user_name' => 'username_1',
            'department_id' => 1,
            'facility_id' => 1,
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TRAINEE)->first()
        ]);
    }

    public function trainer(): self
    {
        return $this->state(fn () => [
            'employee_number' => 23456,
            'ad_user_name' => 'username_2',
            'department_id' => 1,
            'facility_id' => 1,
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TRAINER)->first()
        ]);
    }

    public function investor(): self
    {
        return $this->state(fn () => [
            'employee_number' => 34567,
            'ad_user_name' => 'username_3',
            'department_id' => 1,
            'facility_id' => 1,
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::ESTABLISHMENT_OPERATOR)->first()
        ]);
    }

    public function tvtcOperator(): self
    {
        return $this->state(fn () => [
            'employee_number' => 34567,
            'ad_user_name' => 'username_4',
            'department_id' => 1,
            'facility_id' => 1,
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TVTC_OPERATOR)->first()
        ]);
    }
}
