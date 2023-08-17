<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_name' => fake()->word(),
            'admin_id' => User::inRandomOrder()->where(['is_admin' => true])->first()->id
        ];
    }
}
