<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $description = fake()->paragraph();
        $image = fake()->image("public/storage/images/advertisements", 640, 480, null, false);
        $image = "storage/images/advertisements/".$image;
        $allUserId = User::all()->pluck('id');
        $user_id = fake()->randomElement($allUserId);

        return [
            "title" => $title,
            "description" => $description,
            "image" => $image,
            "user_id" => $user_id,
        ];
    }
}
