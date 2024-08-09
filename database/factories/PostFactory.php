<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $content = $this->faker->text();
        if ($this->faker->boolean()) {
            $content .= $this->faker->url();
        }

        return [
            'content' => $content,
            'likes' => random_int(0, 100),
        ];
    }
}
