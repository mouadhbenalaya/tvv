<?php

namespace Database\Factories\Domain\Users\Models;

use App\Domain\Users\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTypeFactory extends Factory
{
    protected $model = UserType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'can_register' => true,
        ];
    }

    public function trainee(): self
    {
        return $this->state(fn () => [
            'name' => \App\Domain\Users\Enums\UserType::TRAINEE->value,
            'can_register' => true,
        ]);
    }

    public function trainer(): self
    {
        return $this->state(fn () => [
            'name' => \App\Domain\Users\Enums\UserType::TRAINER->value,
            'can_register' => false,
        ]);
    }

    public function investor(): self
    {
        return $this->state(fn () => [
            'name' => \App\Domain\Users\Enums\UserType::ESTABLISHMENT_OPERATOR->value,
            'can_register' => true,
        ]);
    }

    public function tvtcOperator(): self
    {
        return $this->state(fn () => [
            'name' => \App\Domain\Users\Enums\UserType::TVTC_OPERATOR->value,
            'can_register' => false,
        ]);
    }
}
