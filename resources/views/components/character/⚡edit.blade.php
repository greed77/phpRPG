<?php

use App\Livewire\Forms\CharacterForm;
use App\Models\Character;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

new
#[Layout('layouts.app')]
class extends Component
{
    #[Locked]
    public int $characterId;

    public string $characterName;

    public CharacterForm $form;

    public function mount(Character $character): void
    {
        Gate::authorize('update', $character);

        $this->characterId = $character->id;
        $this->characterName = $character->name;
        $this->form->setCharacter($character);
    }

    public function save(): void
    {
        $character = Character::findOrFail($this->characterId);

        Gate::authorize('update', $character);

        $this->form->update($character);

        session()->flash('success', "Character '{$character->name}' updated successfully.");

        $this->redirect(route('internal.character.index'), navigate: true);
    }

    public function with(): array
    {
        return [
            'races' => CharacterForm::races(),
            'classes' => CharacterForm::classes(),
            'genders' => CharacterForm::genders(),
        ];
    }
};
?>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:heading size="xl">Edit Character: {{ $characterName }}</flux:heading>
        <flux:subheading>Update your character's details</flux:subheading>
    </div>

    <form wire:submit="save">
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <x-character.form
                :races="$races"
                :classes="$classes"
                :genders="$genders"
                submitLabel="Update Character"
            />
        </div>
    </form>
</div>
