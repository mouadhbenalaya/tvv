<?php

namespace Database\Factories\Common\Models;

use App\Common\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'code_alpha_2' => $this->faker->word,
            'code_alpha_3' => $this->faker->word,
            'code_numeric' => $this->faker->numberBetween(10, 500),
            'name' => $this->faker->country,
        ];
    }

    public function saudiArabia(): self
    {
        return $this->state(fn () => [
            'code_alpha_2' => 'SA',
            'code_alpha_3' => 'SAU',
            'code_numeric' => 682,
            'name' => 'Saudi Arabia',
        ]);
    }

    public function croatia(): self
    {
        return $this->state(fn () => [
            'code_alpha_2' => 'HR',
            'code_alpha_3' => 'HRV',
            'code_numeric' => 192,
            'name' => 'Croatia',
        ]);
    }

    public function denmark(): self
    {
        return $this->state(fn () => [
            'code_alpha_2' => 'DK',
            'code_alpha_3' => 'DNK',
            'code_numeric' => 208,
            'name' => 'Denmark',
        ]);
    }
}
