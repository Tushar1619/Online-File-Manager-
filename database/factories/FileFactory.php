<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        echo User::factory()->create()->id;
        return [
            'name' => $this->faker->word,
            'path' => $this->faker->url,
            'is_folder' => $this->faker->boolean,
            'mime' => $this->faker->mimeType,
            'size' => $this->faker->numberBetween(100, 10000),
            'created_by' => User::factory()->create()->id,
            'updated_by' => User::factory()->create()->id,
        ];
    }
}
