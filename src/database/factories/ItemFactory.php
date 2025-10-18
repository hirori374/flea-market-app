<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 10000),
            'description' => $this->faker->sentence(),
            'image' => 'default.png',
            'condition' => $this->faker->randomElement(['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い']),
            'seller_id' => null,
        ];
    }
}
