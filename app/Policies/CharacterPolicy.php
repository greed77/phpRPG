<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;

class CharacterPolicy
{
    /**
     * Determine if the user can activate the character.
     */
    public function activate(User $user, Character $character): bool
    {
        return $user->id === $character->user_id;
    }

    /**
     * Determine if the user can view the character.
     */
    public function view(User $user, Character $character): bool
    {
        return $user->id === $character->user_id;
    }

    /**
     * Determine if the user can update the character.
     */
    public function update(User $user, Character $character): bool
    {
        return $user->id === $character->user_id;
    }

    /**
     * Determine if the user can delete the character.
     */
    public function delete(User $user, Character $character): bool
    {
        return $user->id === $character->user_id;
    }
}