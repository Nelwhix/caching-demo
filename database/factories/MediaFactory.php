<?php

namespace Database\Factories;

use Database\Enums\FileType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_type' => $this->faker->randomElement(FileType::values()),
            'file_path' => Str::random(40) . $this->faker->randomElement(['jpg', 'mp4', 'png', 'gif', 'webp', 'mov']),
        ];
    }
}
