<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    public function run(): void
    {
        $races = [
            ['name' => 'Human', 'description' => 'Versatile and adaptable, humans are the most common race.'],
            ['name' => 'Elf', 'description' => 'Graceful and long-lived, elves are attuned to nature and magic.'],
            ['name' => 'Dwarf', 'description' => 'Stout and sturdy, dwarves are master craftsmen and warriors.'],
            ['name' => 'Orc', 'description' => 'Powerful and fierce, orcs are born warriors.'],
            ['name' => 'Halfling', 'description' => 'Small but nimble, halflings are known for their luck and stealth.'],
        ];

        foreach ($races as $race) {
            Race::updateOrCreate(['name' => $race['name']], $race);
        }
    }
}
