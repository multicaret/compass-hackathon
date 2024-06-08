<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Team;
use App\Models\User;
use App\Utilities\Numbers;
use Carbon\Carbon;
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

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'info@yallaplay.com',
        ]);

        $genres = ['MOBA', 'MMO', 'FPS', 'TPS', 'Casual'];
        foreach ($genres as $genre) {
            Genre::create([
                'title' => $genre,
            ]);
        }


        $teams = [
            'MOUZ',
            'FaZe Clan',
            'G2 Esports',
            'Team Spirit',
            'The Mongolz'
        ];
        foreach ($teams as $title) {
            Team::create([
                'title' => $title,
                'tournaments_won' => mt_rand(0, 100),
                'tournaments_lost' => mt_rand(0, 100),
            ]);
        }

        $games = [
            'Fortnite',
            'Apex LEGENDS',
            'Overwatch',
            'Call of Duty',
            'CSGO',
        ];
        foreach ($games as $game) {
            Game::create([
                'title' => $game,
                'monthly_players' => Numbers::toReadable(mt_rand(0, 100000)),
                'yearly_players' => Numbers::toReadable(mt_rand(100000, 100000000)),
            ]);
        }

        $activities = json_decode(file_get_contents(public_path('data.json')))->data;
        foreach ($activities as $activity) {
            try {

                Activity::create([
                    'title' => $activity->title,
                    'description' => $activity->description,
                    'location' => $activity->location ?? '',
                    'type' => strtolower($activity->type),
                    'compass_points' => $activity->compass_points,
                    'is_used' => $activity->is_used,
                    'start_date' => Carbon::parse($activity->start_date),
                    'end_date' => Carbon::parse($activity->end_date),
                ]);
            } catch (\Exception $exception) {
                dd($activity, $exception->getMessage());
            }
        }

    }
}
