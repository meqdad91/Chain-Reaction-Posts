<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition($user_id = 1)
    {
        return [
            'user_id' => $user_id,
            'title' => fake()->title(),
            'description' => fake()->text(),
        ];
    }
}
