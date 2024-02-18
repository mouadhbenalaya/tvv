<?php

namespace Database\Factories\Domain\Users\Models;

use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Users\Enums\Permission as PermissionEnum;
use App\Domain\Users\Enums\UserType as UserTypeEnum;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(PermissionEnum::cases()),
            'guard_name' => 'api',
        ];
    }

    public function superAdmin(): self
    {
        return $this->state(fn () => [
            'name' => 'superAdmin',
        ]);
    }

    public function tvtcEmployee(): self
    {
        return $this->state(fn () => [
            'name' => 'tvtcEmployee',
        ]);
    }

    public function trainee(): self
    {
        return $this->state(fn () => [
            'name' => 'trainee',
            'user_type_id' => UserType::where('name', UserTypeEnum::TRAINEE->value)->first()?->id
        ]);
    }

    public function trainer(): self
    {
        return $this->state(fn () => [
            'name' => 'trainer',
            'user_type_id' => UserType::where('name', UserTypeEnum::TRAINER->value)->first()?->id
        ]);
    }

    public function investor(): self
    {
        return $this->state(fn () => [
            'name' => 'investor',
            'user_type_id' => UserType::where('name', UserTypeEnum::ESTABLISHMENT_OPERATOR->value)->first()?->id
        ]);
    }

    public function tvtcOperator(): self
    {
        return $this->state(fn () => [
            'name' => 'tvtc_operator',
            'user_type_id' => UserType::where('name', UserTypeEnum::TVTC_OPERATOR->value)->first()?->id
        ]);
    }
}
