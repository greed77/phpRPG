<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->name('internal.')
    ->group(function () {
        Route::livewire('/dashboard', 'dashboard')->name('dashboard');
        Route::livewire('/characters', 'character.index')->name('character.index');
        // Generates route name: internal.dashboard
    });
