<?php

use App\Models\Character;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts.app')]
class extends Component
{
    public ?User $user;
    public string $successMessage = '';

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->successMessage = session('success', '');
    }

    #[Computed]
    public function characters()
    {
        return $this->user->characters;
    }

    public function activate($character_id): void
    {
        $this->user->activateCharacter($character_id);
    }

    public function delete(int $characterId): void
    {
        $character = Character::findOrFail($characterId);

        Gate::authorize('delete', $character);

        $name = $character->name;
        $character->delete();

        $this->successMessage = "Character '{$name}' deleted.";
    }
};
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <flux:heading size="xl">Characters</flux:heading>
            <flux:subheading>Manage your characters</flux:subheading>
        </div>
        <flux:button href="{{ route('internal.character.create') }}" variant="primary" icon="plus">
            Create Character
        </flux:button>
    </div>

    @if($successMessage)
        <div class="mb-6">
            <flux:callout variant="success">
                {{ $successMessage }}
            </flux:callout>
        </div>
    @endif

    <flux:table>
        <flux:table.columns>
            <flux:table.column></flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Level</flux:table.column>
            <flux:table.column>Class</flux:table.column>
            <flux:table.column>Energy</flux:table.column>
            <flux:table.column>Date Created</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->characters as $character)
                <flux:table.row>
                    <flux:table.cell>
                        @if($character->is_active)
                            <flux:icon.star />
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>{{ $character->name }}</flux:table.cell>
                    <flux:table.cell>{{ $character->level }}</flux:table.cell>
                    <flux:table.cell>{{ $character->class }}</flux:table.cell>
                    <flux:table.cell>{{ $character->energy }}</flux:table.cell>
                    <flux:table.cell>{{ $character->created_at }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                         inset="top bottom"></flux:button>
                            <flux:menu>
                                @unless($character->is_active)
                                    <flux:menu.item icon="star" wire:click="activate({{ $character->id }})">Make Active</flux:menu.item>
                                @endunless
                                <flux:menu.item icon="pencil-square" href="{{ route('internal.character.edit', $character) }}" wire:navigate>Edit</flux:menu.item>
                                <flux:menu.separator/>
                                <flux:menu.item variant="danger" icon="trash" wire:click="delete({{ $character->id }})" wire:confirm="Are you sure you want to delete {{ $character->name }}?">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
