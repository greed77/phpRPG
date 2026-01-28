<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new
#[Layout('layouts.app')]
class extends Component
{
    #[Locked]
    public int $roleId;

    public string $roleName = '';
    public array $selectedPermissions = [];

    public function mount(Role $role): void
    {
        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    #[Computed]
    public function role(): Role
    {
        return Role::findOrFail($this->roleId);
    }

    #[Computed]
    public function groupedPermissions()
    {
        return Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });
    }

    public function save(): void
    {
        // Prevent removing manage-roles from admin role (self-lockout prevention)
        if ($this->roleName === 'admin' && !in_array('manage-roles', $this->selectedPermissions)) {
            $this->addError('permissions', 'You cannot remove manage-roles from admin role');
            return;
        }

        $this->role->syncPermissions($this->selectedPermissions);

        session()->flash('success', "Permissions updated for {$this->roleName} role.");

        $this->redirect(route('admin.roles.index'), navigate: true);
    }
};
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:heading size="xl">Edit Role: {{ ucfirst($roleName) }}</flux:heading>
        <flux:subheading>Manage permissions for this role</flux:subheading>
    </div>

    <form wire:submit="save">
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            @error('permissions')
                <div class="mb-6">
                    <flux:callout variant="danger">
                        {{ $message }}
                    </flux:callout>
                </div>
            @enderror

            @foreach($this->groupedPermissions as $group => $permissions)
                <div class="mb-8 last:mb-0">
                    <flux:heading size="lg" class="capitalize mb-4">{{ $group }} Permissions</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions as $permission)
                            <flux:checkbox
                                wire:model="selectedPermissions"
                                value="{{ $permission->name }}"
                                label="{{ $permission->name }}"
                            />
                        @endforeach
                    </div>
                </div>

                @if(!$loop->last)
                    <flux:separator class="my-6" />
                @endif
            @endforeach

            <div class="flex justify-between items-center pt-6 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button href="{{ route('admin.roles.index') }}" variant="ghost">
                    Cancel
                </flux:button>

                <flux:button type="submit" variant="primary">
                    Update Permissions
                </flux:button>
            </div>
        </div>
    </form>
</div>
