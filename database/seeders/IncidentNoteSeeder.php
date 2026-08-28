<?php

namespace Database\Seeders;

use App\Models\IncidentNote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidentNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncidentNote::factory()->count(30)->create();
    }
}
