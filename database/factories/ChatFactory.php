<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::inRandomOrder()->take(2)->get();
        return [
            'User_1_id' => $users->get(0)->id,
            'User_2_id' => $users->get(1)->id,
        ];
    }
}
