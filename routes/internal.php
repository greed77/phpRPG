<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->name('internal.')
    ->group(function () {
        Route::livewire('/dashboard', 'dashboard')->name('dashboard');
        Route::livewire('/characters', 'character.index')->name('character.index');
        Route::livewire('/characters/new', 'character.create')->name('character.create');
        Route::livewire('/characters/{character}/edit', 'character.edit')->name('character.edit');
    });

Route::middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::livewire('/admin/dashboard', 'admin.dashboard')->name('dashboard');
    });

Route::middleware(['auth', 'permission:manage-roles'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::livewire('/roles', 'admin.roles')->name('roles.index');
        Route::livewire('/roles/{role}/edit', 'admin.role-edit')->name('roles.edit');
    });
