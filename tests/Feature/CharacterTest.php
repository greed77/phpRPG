<?php

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Gender;
use App\Models\Race;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    // Seed lookup tables
    Race::create(['name' => 'Human']);
    Race::create(['name' => 'Elf']);
    CharacterClass::create(['name' => 'Warrior']);
    CharacterClass::create(['name' => 'Mage']);
    Gender::create(['name' => 'Male']);
    Gender::create(['name' => 'Female']);
});

test('guests cannot access character pages', function () {
    $this->get('/characters')->assertRedirect('/login');
    $this->get('/characters/new')->assertRedirect('/login');
});

test('authenticated users can view character list', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/characters')
        ->assertOk();
});

test('authenticated users can view create character page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/characters/new')
        ->assertOk();
});

test('users can create a character', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('character.create')
        ->set('form.name', 'Thorin')
        ->set('form.race', 'Human')
        ->set('form.class', 'Warrior')
        ->set('form.gender', 'Male')
        ->call('save')
        ->assertRedirect(route('internal.character.index'));

    $this->assertDatabaseHas('characters', [
        'user_id' => $user->id,
        'name' => 'Thorin',
        'race' => 'Human',
        'class' => 'Warrior',
        'gender' => 'Male',
    ]);
});

test('character creation validates required fields', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('character.create')
        ->set('form.name', '')
        ->call('save')
        ->assertHasErrors(['form.name']);
});

test('character creation validates race exists', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('character.create')
        ->set('form.name', 'Test')
        ->set('form.race', 'InvalidRace')
        ->set('form.class', 'Warrior')
        ->set('form.gender', 'Male')
        ->call('save')
        ->assertHasErrors(['form.race']);
});

test('users can edit their own character', function () {
    $user = User::factory()->create();
    $character = Character::factory()->for($user)->create([
        'name' => 'OldName',
        'race' => 'Human',
        'class' => 'Warrior',
        'gender' => 'Male',
    ]);

    Livewire::actingAs($user)
        ->test('character.edit', ['character' => $character])
        ->set('form.name', 'NewName')
        ->call('save')
        ->assertRedirect(route('internal.character.index'));

    $this->assertDatabaseHas('characters', [
        'id' => $character->id,
        'name' => 'NewName',
    ]);
});

test('users cannot edit another users character', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $character = Character::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('character.edit', ['character' => $character])
        ->assertForbidden();
});

test('users can delete their own character', function () {
    $user = User::factory()->create();
    $character = Character::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('character.index')
        ->call('delete', $character->id);

    $this->assertSoftDeleted('characters', ['id' => $character->id]);
});

test('users cannot delete another users character', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $character = Character::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('character.index')
        ->call('delete', $character->id)
        ->assertForbidden();
});
