<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function() {
    $projects = auth()->user()->projects()->latest()->get();
    return view('dashboard', compact('projects'));
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

<<<<<<< HEAD
require __DIR__.'/auth.php';
=======


Route::middleware(['auth'])->group(function () {
    Route::get('/projects/manage', function () {
        return view('projects.manage');
    })->name('projects.manage');
});


Route::get('/projects/{project}/board', function(App\Models\Project $project) {
    // Vérifier que l'utilisateur a accès à ce projet
    if ($project->user_id !== auth()->id()) {
        abort(403);
    }
    
    return view('projects.project-board', compact('project'));
})->middleware(['auth'])->name('projects.board');


require __DIR__ . '/auth.php';
>>>>>>> 56432cc (update ilia)
