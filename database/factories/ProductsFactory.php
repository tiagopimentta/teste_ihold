<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Merchants;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'merchant_id' => Merchants::inRandomOrder()->first()->id,
            'price'=> fake()->randomDigit(),
            'status'=>'Ativo'
        ];
    }
}
