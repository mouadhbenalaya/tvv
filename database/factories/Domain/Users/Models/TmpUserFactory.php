<?php

namespace Database\Factories\Domain\Users\Models;

use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TmpUserFactory extends Factory
{
    protected $model = TmpUser::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'user_type_id' => UserType::all()->random(),
            'validation_token' => $this->faker->regexify('[A-Za-z0-9]{64}'),
            'validated_at' => $this->faker->dateTimeBetween('now', '+1 day'),
            'first_validation' => true,
        ];
    }

    public function jim(): self
    {
        return $this->state(fn () => [
            'email' => 'jim@example.com',
            'user_type_id' => UserType::all()->first(),
            'validation_token' => 'somerandomtokenforjim',
            'validated_at' => '2023-12-01 00:22:44',
            'first_validation' => true,
        ]);
    }

    public function pam(): self
    {
        return $this->state(fn () => [
            'email' => 'pam@q.agency',
            'user_type_id' => UserType::all()->random(),
            'validation_token' => 'somerandomtokenforpam',
            'validated_at' => '2023-01-01 22:00:44',
            'first_validation' => false,
        ]);
    }
}
