<?php

namespace Database\Seeders;

use App\Models\CharacterClass;
use Illuminate\Database\Seeder;

class CharacterClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['name' => 'Warrior', 'description' => 'Masters of combat, warriors excel in physical battle.'],
            ['name' => 'Mage', 'description' => 'Wielders of arcane power, mages cast devastating spells.'],
            ['name' => 'Rogue', 'description' => 'Cunning and stealthy, rogues strike from the shadows.'],
            ['name' => 'Cleric', 'description' => 'Divine servants who heal allies and smite enemies.'],
            ['name' => 'Ranger', 'description' => 'Skilled hunters and trackers at home in the wilderness.'],
        ];

        foreach ($classes as $class) {
            CharacterClass::updateOrCreate(['name' => $class['name']], $class);
        }
    }
}
