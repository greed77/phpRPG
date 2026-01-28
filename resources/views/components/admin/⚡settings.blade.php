<?php

use App\Settings\GeneralSettings;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

new
#[Layout('layouts.app')]
class extends Component
{
    #[Validate('required|string|min:1|max:100')]
    public string $site_name = '';

    public function mount(GeneralSettings $settings): void
    {
        $this->site_name = $settings->site_name;
    }

    public function save(GeneralSettings $settings): void
    {
        $this->validate();

        $settings->site_name = $this->site_name;
        $settings->save();

        session()->flash('success', 'Settings saved successfully.');
    }
};
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <flux:heading size="xl">Site Settings</flux:heading>
        <flux:subheading>Configure general site settings</flux:subheading>
    </div>

    @if(session('success'))
        <div class="mb-6">
            <flux:callout variant="success">
                {{ session('success') }}
            </flux:callout>
        </div>
    @endif

    <form wire:submit="save">
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <flux:heading size="lg" class="mb-6">General</flux:heading>

            <div class="space-y-6">
                <flux:field>
                    <flux:label>Site Name</flux:label>
                    <flux:input wire:model="site_name" placeholder="Enter site name" />
                    <flux:description>The name displayed in the browser title and throughout the site.</flux:description>
                    <flux:error name="site_name" />
                </flux:field>
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button type="submit" variant="primary">
                    Save Settings
                </flux:button>
            </div>
        </div>
    </form>
</div>
