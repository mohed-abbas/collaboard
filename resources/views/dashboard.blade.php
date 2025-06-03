<x-layouts.app :title="'Tableau de bord'">
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Mes projets</h1>
            <div>
                <button 
                    onclick="Livewire.dispatch('openCreateProjectModal')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                >
                    Nouveau projet
                </button>
            </div>
        </div>
        
        @if($projects->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
                <p class="text-gray-600 dark:text-gray-300 mb-4">Vous n'avez pas encore créé de projet</p>
                <button 
                    onclick="Livewire.dispatch('openCreateProjectModal')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                >
                    Créer mon premier projet
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                        <div class="p-5">
                            <h2 class="text-xl font-semibold">{{ $project->name }}</h2>
                            @if($project->description)
                                <p class="text-gray-600 dark:text-gray-300 mt-2">
                                    {{ \Illuminate\Support\Str::limit($project->description, 100) }}
                                </p>
                            @endif
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3 flex justify-end">
                            <a href="{{ route('projects.board', $project->id) }}" 
                               class="text-blue-600 hover:text-blue-800 hover:underline">
                                Ouvrir le tableau →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @livewire('project-modal')
</x-layouts.app>

<?php
Route::get('/projects/{project}/board', [ProjectController::class, 'board'])->name('projects.board');
