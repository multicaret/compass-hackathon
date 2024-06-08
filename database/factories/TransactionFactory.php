<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TransactionFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isIn = mt_rand(0, 1);
        $isInText = $isIn ? 'In' : 'Out';

        return [
            'title' => sprintf('%s transaction for %s', $isInText, fake()->word),
            'description' => fake()->text(),
            'type' => strtolower($isInText),
        ];
    }

}
