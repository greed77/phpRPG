<?php

use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function characters()
    {
        return auth()->user()->characters;
    }
};
?>

<div>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Level</flux:table.column>
            <flux:table.column>Class</flux:table.column>
            <flux:table.column>Energy</flux:table.column>
            <flux:table.column>Date Created</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->characters as $character)
                <flux:table.row>
                    <flux:table.cell>{{ $character->name }}</flux:table.cell>
                    <flux:table.cell>{{ $character->level }}</flux:table.cell>
                    <flux:table.cell>{{ $character->class }}</flux:table.cell>
                    <flux:table.cell>{{ $character->energy }}</flux:table.cell>
                    <flux:table.cell>{{ $character->created_at }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
