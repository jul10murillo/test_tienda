<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->name,
            'price' => $this->faker->randomNumber(4),
            'slug' => $this->faker->slug,
            'thumbnail' => "https://picsum.photos/200/300?grayscale",
            'description' => $this->faker->text,
        ];
    }
}
