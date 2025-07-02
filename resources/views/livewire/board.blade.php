<div class="min-h-screen bg-gradient-to-br ">
    <!-- MODIFICATION: Inclusion des messages flash pour les notifications -->
    @include('livewire.flash-messages')

    <!-- MODIFICATION: Header avec navigation simplifié sans ombre pour économiser l'espace -->
    <div class="bg-white   border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-4">
                    <!-- MODIFICATION: Bouton de retour au tableau de bord avec icône -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au Tableau de bord
                    </a>
                </div>
                <div class="flex gap-2 text-gray-500">
                    <span
                        class="cursor-pointer px-2 py-1 rounded {{ $viewMode === 'board' ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-gray-200' }}"
                        wire:click="$set('viewMode','board')">
                        Board
                    </span>
                    <span
                        class="cursor-pointer px-2 py-1 rounded {{ $viewMode === 'list' ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-gray-200' }}"
                        wire:click="$set('viewMode','list')">
                        List
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- MODIFICATION: Contenu principal occupant toute la largeur disponible -->
    <div class="w-full h-full">
        <div class="w-full h-full">
            <!-- MODIFICATION: En-tête du projet avec titre et bouton de création -->
            <div class="mb-4 px-6 lg:px-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $project->name }}
                </h1>
                <!-- MODIFICATION: Bouton de création de catégorie avec style cohérent -->
                <button wire:click="openCreateCategoryModal"
                    class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    + Créer une Catégorie
                </button>

                <button wire:click="$dispatch('openLabelModal')"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    🏷️ Gérer les Étiquettes
                </button>
            </div>

            @if ($viewMode === 'list')
            <!-- MODIFICATION: Composant Livewire pour la vue en liste -->
            <livewire:list-view :project="$project" />
            @else
            <!-- MODIFICATION: Zone des catégories prenant toute la largeur avec défilement horizontal -->
            <div class="w-full h-full overflow-x-auto">
                <div class="flex flex-row gap-4 items-start py-4 px-6 lg:px-8 min-h-screen">
                    @foreach ($categories as $category)
                    <!-- MODIFICATION: Carte de catégorie avec largeur minimale fixe et fond blanc -->
                    <div class="flex flex-col min-w-[280px] bg-white rounded-lg shadow-sm px-4 py-3">
                        <div class="flex justify-between items-center mb-2">
                            <!-- MODIFICATION: Titre de la catégorie -->
                            <h2 class="text-lg font-semibold">{{ $category->title }}</h2>
                            <!-- MODIFICATION: Menu trois points pour les actions de catégorie -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                                <!-- MODIFICATION: Dropdown avec options de modification et suppression -->
                                <div x-show="open" @click.outside="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                    <div class="py-1">
                                        <button wire:click="openEditCategoryModal({{ $category->id }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                            Modifier
                                        </button>
                                        <button wire:click="deleteCategory({{ $category->id }})"
                                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 w-full text-left">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- MODIFICATION: Zone des tâches avec espacement vertical -->
                        <div class="flex flex-col gap-2">
                            @forelse($category->tasks as $task)



                            <!-- MODIFICATION: Carte de tâche cliquable avec états visuels différents et labels -->
                            <div wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
                                class="task rounded-lg p-3 cursor-pointer transition-colors duration-150
                                                                    {{ $task->is_done == 1 ? 'bg-green-100 hover:bg-green-200 line-through opacity-70' : 'bg-gray-100 hover:bg-blue-100' }}">

                                <!-- MODIFICATION: Labels affichés en haut de la carte -->
                                @if($task->labels->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-2">
                                    @foreach($task->labels as $label)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-white"
                                        style="background-color: {{ $label->color }}">
                                        {{ $label->name }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif

                                <div class="flex items-center justify-between">
                                    <!-- MODIFICATION: Titre de la tâche -->
                                    <h3 class="font-medium {{ $task->isOverdue() ? 'text-red-700' : 'text-gray-900' }}">
                                        {{ $task->title }}
                                    </h3>
                                    <!-- MODIFICATION: Checkbox pour marquer la tâche comme terminée -->
                                    <label class="mt-2 inline-flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
                                            wire:click.stop="$dispatch('toggleTaskDone', {taskId: {{ $task->id }}})"
                                            {{ $task->is_done ? 'checked' : '' }}
                                            class="form-checkbox h-5 w-5 text-green-600 transition duration-150 rounded checked:bg-green-600">
                                    </label>
                                </div>

                                <!-- MODIFICATION: Description de la tâche -->
                                @if($task->description)
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($task->description, 100) }}
                                </p>
                                @endif

                                <!-- MODIFICATION: Informations supplémentaires avec priorité et deadline -->
                                <div class="mt-2 flex justify-between items-center">
                                    <div class="flex items-center space-x-2">
                                        <!-- Priority indicator -->
                                        @if($task->priority_level > 1)
                                        <span
                                            class="px-2 py-0.5 text-xs rounded-full
                                                                                {{ $task->priority_level === 4 ? 'bg-red-100 text-red-800' : '' }}
                                                                                {{ $task->priority_level === 3 ? 'bg-orange-100 text-orange-800' : '' }}
                                                                                {{ $task->priority_level === 2 ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ $task->priority_text }}
                                        </span>
                                        @endif

                                        <!-- Deadline with visual warning -->
                                        @if($task->deadline)
                                        <span
                                            class="text-xs {{ $task->isOverdue() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                            📅 {{ $task->deadline->format('d/m H:i') }}
                                            @if($task->isOverdue())
                                            <span class="ml-2 px-1 py-0.5 bg-red-500 text-[8px] text-white rounded">
                                                RETARD
                                            </span>
                                            @endif
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Task status indicator -->
                                    <div class="flex items-center space-x-1">
                                        @if($task->users->count() > 1)
                                        <span class="text-xs text-gray-400">👥
                                            {{ $task->users->count() }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <!-- MODIFICATION: Message d'état vide quand aucune tâche n'existe -->
                            <div class="text-gray-400 italic text-center p-2">Aucune tâche</div>
                            @endforelse
                            <!-- MODIFICATION: Bouton d'ajout de tâche avec dispatch d'événement -->
                            <button wire:click="$dispatch('openCreateTaskModal', {categoryId: {{ $category->id }}})"
                                class="mt-2 px-3 py-1 border text-black rounded cursor-pointer hover:bg-gray-100 transition-colors duration-150">
                                + Ajouter une Tâche
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- MODIFICATION: Inclusion du modal de gestion des catégories -->
            @include('livewire.category-modal')
            <!-- MODIFICATION: Composant Livewire pour la gestion des tâches -->
            <livewire:task-manager :categories="$categories" />
            <livewire:label-manager :project="$project" />
        </div>
    </div>
</div>