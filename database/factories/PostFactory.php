<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Post\Entity\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = fake()->realtext(20),
            'content' => fake()->realtext(300),
            'image' => fake()->url(),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 10000),
            'user_id' => fake()->randomNumber(1, 10),
            'community_id' => fake()->randomNumber(1, 10),
        ];
    }
}
