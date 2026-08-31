<?php

namespace Database\Factories;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidentNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'incident_id' => Incident::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
            'note' => fake()->sentence(10),
        ];
    }
}
