<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname' => $this->faker->name,
            'phone' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->address,
            // 'created_at' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
            // 'updated_at' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
        ];
    }
}
