<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->text(),
            'content' => $this->faker->paragraph(30),
            'user_id' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->boolean(),
        ];
    }
}
