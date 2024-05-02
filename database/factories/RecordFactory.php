<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'customer_id' => $this->faker->numberBetween($min = 1, $max = 20),
            'price' => 620,
            'amount' => $amount = $this->faker->numberBetween($min = 5000, $max = 1000000),
            'cost_price' => 600,
            'profit'=> $amount - ($amount/620)*600,
            'created_at' => $created_at =$this->faker->dateTimeThisYear($max = 'now', $timezone = null),
            'updated_at' => $created_at,


        ];
    }
}
