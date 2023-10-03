<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'channel_id' => \App\Models\User::all()->random()->id,
            'name' => fake()->name(),
            'color' => fake()->colorName(),
            'slug' => fake()->slug(),
        ];
    }
}
