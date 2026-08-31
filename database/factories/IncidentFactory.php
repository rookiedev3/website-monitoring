<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'website_id' => Website::inRandomOrder()->first()?->id,
            'assigned_to' => User::inRandomOrder()->first()?->id,
            'incident_type' => fake()->randomElement(['down', 'timeout', 'http_error', 'ssl', 'slow']),
            'status' => fake()->randomElement(['open', 'on_progress', 'solved']),
            'started_at' => now()->subMinutes(fake()->numberBetween(5, 5000)),
        ];
    }
}
