<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $genres = ['MOBA', 'MMO', 'FPS', 'TPS', 'Casual'];
        foreach ($genres as $genre) {
            Genre::create([
                'title' => $genre,
            ]);
        }

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'info@yallaplay.com',
        ]);
    }
}
