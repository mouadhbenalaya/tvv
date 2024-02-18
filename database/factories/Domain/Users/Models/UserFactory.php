<?php

namespace Database\Factories\Domain\Users\Models;

use App\Common\Models\Country;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'second_name' => $this->faker->firstName(),
            'third_name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'secretPassword',
            'remember_token' => Str::random(10),
            'id_number' => $this->faker->unique()->numberBetween(1, 99999),
            'mobile_number' => $this->faker->phoneNumber(),
            'lives_in_saudi_arabi' => $this->faker->randomElement([true, false]),
            'country_id' => Country::all()->random()->id,
        ];
    }

    public function jim(): self
    {
        return $this->state(fn () => [
            'first_name' => 'Jim',
            'last_name' => 'Jim',
            'second_name' => 'Jim',
            'third_name' => 'Jim',
            'email' => 'jim@example.com',
            'email_verified_at' => now(),
            'password' => 'secretPassword',
            'remember_token' => Str::random(10),
            'id_number' => 321,
            'mobile_number' => '41111111',
            'lives_in_saudi_arabi' => false,
            'country_id' => Country::where('code_alpha_2', 'HR')->first(),
        ]);
    }

    public function pam(): self
    {
        return $this->state(fn () => [
            'first_name' => 'Pam',
            'last_name' => 'Pam',
            'second_name' => 'Pam',
            'third_name' => 'Pam',
            'email' => 'pam@example.com',
            'email_verified_at' => now(),
            'password' => 'secretPassword',
            'remember_token' => Str::random(10),
            'id_number' => 123,
            'mobile_number' => '2222222',
            'lives_in_saudi_arabi' => true,
            'country_id' => Country::where('code_alpha_2', 'SA')->first(),
        ]);
    }
}
