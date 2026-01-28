<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        $genders = [
            ['name' => 'Male'],
            ['name' => 'Female'],
            ['name' => 'Non-binary'],
        ];

        foreach ($genders as $gender) {
            Gender::updateOrCreate(['name' => $gender['name']], $gender);
        }
    }
}
