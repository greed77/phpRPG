<?php

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public ?User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    #[Computed]
    public function characters()
    {
        return $this->user->characters;
    }

    public function activate($character_id): void
    {
        //Log::debug($character_id);
        $this->user->activateCharacter($character_id);
    }
};
?>

<div>
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
                                <flux:menu.item icon="star" wire:click="activate({{ $character->id }})">Make Active</flux:menu.item>
                                <flux:menu.item icon="pencil-square">Edit</flux:menu.item>
                                <flux:menu.separator/>
                                <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
