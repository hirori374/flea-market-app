<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'delivery_post_code' => $this->faker->postcode(),
            'delivery_address' => $this->faker->streetAddress(),
            'delivery_building' => $this->faker->secondaryAddress(),
            'pay_method' =>$this->faker->randomElement(['カード払い', 'コンビニ払い']),
            'pay_status' =>$this->faker->randomElement(['pending', 'paid']),
        ];
    }
}
