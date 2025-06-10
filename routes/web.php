<?php

use App\Livewire\Board;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ProjectManager;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/projects/manage', function () {
        return view('projects.manage');
    })->name('projects.manage');

    Route::get('/{project}/board', Board::class)->name('project.board');
});


require __DIR__ . '/auth.php';