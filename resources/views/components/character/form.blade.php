@props(['races', 'classes', 'genders', 'submitLabel' => 'Save'])

<div class="space-y-6">
    <flux:field>
        <flux:label>Name</flux:label>
        <flux:input wire:model="form.name" placeholder="Enter character name" />
        <flux:error name="form.name" />
    </flux:field>

    <flux:field>
        <flux:label>Race</flux:label>
        <flux:select wire:model="form.race" placeholder="Select a race">
            @foreach($races as $race)
                <flux:select.option value="{{ $race }}">{{ $race }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:error name="form.race" />
    </flux:field>

    <flux:field>
        <flux:label>Class</flux:label>
        <flux:select wire:model="form.class" placeholder="Select a class">
            @foreach($classes as $class)
                <flux:select.option value="{{ $class }}">{{ $class }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:error name="form.class" />
    </flux:field>

    <flux:field>
        <flux:label>Gender</flux:label>
        <flux:select wire:model="form.gender" placeholder="Select gender">
            @foreach($genders as $gender)
                <flux:select.option value="{{ $gender }}">{{ $gender }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:error name="form.gender" />
    </flux:field>

    <div class="flex justify-between items-center pt-6 border-t border-zinc-200 dark:border-zinc-700">
        <flux:button href="{{ route('internal.character.index') }}" variant="ghost">
            Cancel
        </flux:button>

        <flux:button type="submit" variant="primary">
            {{ $submitLabel }}
        </flux:button>
    </div>
</div>
