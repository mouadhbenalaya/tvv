<?php

namespace Database\Factories\Common\Models;

use App\Common\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    protected $model = Region::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->numberBetween(1000, 10000),
            'name' => $this->faker->words(2, true),
        ];
    }
}
