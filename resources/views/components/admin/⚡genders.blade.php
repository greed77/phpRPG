<?php

use App\Models\Gender;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

new
#[Layout('layouts.app')]
class extends Component
{
    #[Validate('required|string|min:2|max:50|unique:genders,name')]
    public string $name = '';

    public ?int $editingId = null;

    #[Validate('required|string|min:2|max:50')]
    public string $editingName = '';

    public function create(): void
    {
        $this->validateOnly('name');

        Gender::create(['name' => $this->name]);

        $this->reset('name');
    }

    public function edit(int $id): void
    {
        $gender = Gender::findOrFail($id);
        $this->editingId = $id;
        $this->editingName = $gender->name;
    }

    public function update(): void
    {
        $this->validateOnly('editingName');

        $gender = Gender::findOrFail($this->editingId);
        $gender->update(['name' => $this->editingName]);

        $this->cancelEdit();
    }

    public function cancelEdit(): void
    {
        $this->reset('editingId', 'editingName');
    }

    public function delete(int $id): void
    {
        Gender::findOrFail($id)->delete();
    }

    public function with(): array
    {
        return [
            'genders' => Gender::orderBy('name')->get(),
        ];
    }
};
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:heading size="xl">Manage Genders</flux:heading>
        <flux:subheading>Add, edit, or remove available character genders</flux:subheading>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
        <form wire:submit="create" class="flex gap-4">
            <div class="flex-1">
                <flux:input wire:model="name" placeholder="Enter new gender name" />
                <flux:error name="name" />
            </div>
            <flux:button type="submit" variant="primary">Add Gender</flux:button>
        </form>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column class="w-32"></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse($genders as $gender)
                <flux:table.row>
                    <flux:table.cell>
                        @if($editingId === $gender->id)
                            <form wire:submit="update" class="flex gap-2">
                                <flux:input wire:model="editingName" class="flex-1" />
                                <flux:button type="submit" size="sm" variant="primary">Save</flux:button>
                                <flux:button type="button" size="sm" variant="ghost" wire:click="cancelEdit">Cancel</flux:button>
                            </form>
                            <flux:error name="editingName" />
                        @else
                            {{ $gender->name }}
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        @if($editingId !== $gender->id)
                            <div class="flex gap-1 justify-end">
                                <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="edit({{ $gender->id }})" />
                                <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $gender->id }})" wire:confirm="Are you sure you want to delete {{ $gender->name }}?" />
                            </div>
                        @endif
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="2" class="text-center text-zinc-500">
                        No genders defined yet.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
