<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
            'race' => fake()->randomElement(['Human', 'Elf', 'Dwarf', 'Orc', 'Halfling']),
            'class' => fake()->randomElement(['Warrior', 'Mage', 'Rogue', 'Cleric', 'Ranger']),
            'gender' => fake()->randomElement(['Male', 'Female', 'Non-binary']),
        ];
    }
}
