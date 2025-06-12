<?php

use App\Livewire\Board;
use App\Livewire\ProjectSettings;
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
<<<<<<< HEAD
    Route::get('/projects/manage', function () {
        return view('projects.manage');
    })->name('projects.manage');

    Route::get('/{project}/board', Board::class)->name('project.board');
    Route::get('/{project}/settings', ProjectSettings::class)->name('project.settings');
=======
    // MODIFICATION: Route pour la gestion des projets (liste et actions CRUD)
    Route::get('/projects/manage', ProjectManager::class)->name('projects.manage');
    // MODIFICATION: Route pour la création de projet (même composant mais avec modal ouvert)
    Route::get('/projects/create', ProjectManager::class)->name('projects.create');
    // MODIFICATION: Route pour accéder au tableau Kanban d'un projet spécifique
    Route::get('/project/{project}/board', Board::class)->name('project.board');
>>>>>>> development
});

// MODIFICATION: Inclusion des routes d'authentification Laravel Breeze
require __DIR__ . '/auth.php';