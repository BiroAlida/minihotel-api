<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->numberBetween(101, 399),
            'floor' => fake()->numberBetween(1, 3),
            'status' => fake()->randomElement([
                'available',
                'occupied',
                'cleaning',
            ]),
        ];
    }
}
