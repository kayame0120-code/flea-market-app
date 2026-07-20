<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment_method' => $this->faker->numberBetween(1, 2),
            'shipping_postal_code' => $this->faker->numerify('#######'),
            'shipping_address' => $this->faker->address(),
            'shipping_building' => $this->faker->optional()->secondaryAddress(),
        ];
    }
}
