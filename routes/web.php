<?php

use App\Livewire\Board;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ProjectManager;
use Illuminate\Support\Facades\Route;

// Route d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route dashboard
Route::get('dashboard', function() {
    $projects = auth()->user()->projects()->latest()->get();
    return view('dashboard', compact('projects'));
})->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Routes settings
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // Routes projets
    Route::get('/projects/manage', function () {
        return view('projects.manage');
    })->name('projects.manage');

    // Route board
    Route::get('/{project}/board', Board::class)->name('project.board');
});

require __DIR__ . '/auth.php';
