<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new
#[Layout('layouts.app')]
class extends Component
{
    public string $successMessage = '';

    public function mount(): void
    {
        $this->successMessage = session('success', '');
    }

    #[Computed]
    public function roles()
    {
        return Role::with('permissions')->get();
    }
};
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:heading size="xl">Role Management</flux:heading>
        <flux:subheading>Manage roles and their permissions</flux:subheading>
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
            <flux:table.column>Role</flux:table.column>
            <flux:table.column>Permissions</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->roles as $role)
                <flux:table.row>
                    <flux:table.cell class="font-medium capitalize">
                        {{ $role->name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex flex-wrap gap-2">
                            @forelse($role->permissions as $permission)
                                <flux:badge size="sm" color="blue">{{ $permission->name }}</flux:badge>
                            @empty
                                <span class="text-sm text-zinc-400">No permissions assigned</span>
                            @endforelse
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button href="{{ route('admin.roles.edit', $role) }}" variant="ghost" size="sm">
                            Edit Permissions
                        </flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
