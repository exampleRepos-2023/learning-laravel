<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(5, true),
        ];
    }

    public function myTitle(): Factory {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'My title',
                'content' => 'My content',
            ];
        });
    }
}
