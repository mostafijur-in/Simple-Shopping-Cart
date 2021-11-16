<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => strtoupper(Str::random(5)),
            'title' => ucfirst($this->faker->words(3, true)),
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(0,100,999),
            'qty' => $this->faker->randomNumber(3, true),
        ];
    }
}
