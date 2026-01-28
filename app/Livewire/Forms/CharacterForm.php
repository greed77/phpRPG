<?php

namespace App\Livewire\Forms;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Gender;
use App\Models\Race;
use Livewire\Form;

class CharacterForm extends Form
{
    public string $name = '';
    public string $race = '';
    public string $class = '';
    public string $gender = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'race' => 'required|exists:races,name',
            'class' => 'required|exists:character_classes,name',
            'gender' => 'required|exists:genders,name',
        ];
    }

    public function setCharacter(Character $character): void
    {
        $this->name = $character->name;
        $this->race = $character->race ?? '';
        $this->class = $character->class ?? '';
        $this->gender = $character->gender ?? '';
    }

    public function store(): Character
    {
        $this->validate();

        return auth()->user()->characters()->create([
            'name' => $this->name,
            'race' => $this->race,
            'class' => $this->class,
            'gender' => $this->gender,
        ]);
    }

    public function update(Character $character): void
    {
        $this->validate();

        $character->update([
            'name' => $this->name,
            'race' => $this->race,
            'class' => $this->class,
            'gender' => $this->gender,
        ]);
    }

    public static function races(): array
    {
        return Race::pluck('name')->toArray();
    }

    public static function classes(): array
    {
        return CharacterClass::pluck('name')->toArray();
    }

    public static function genders(): array
    {
        return Gender::pluck('name')->toArray();
    }
}
