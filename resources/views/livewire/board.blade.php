<div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
    <!-- Flash Messages -->
    @include('livewire.flash-messages')

    <!-- Refined Header -->
    <header
        class="sticky top-0 z-40 bg-white/95 dark:bg-slate-800/95 backdrop-blur-sm border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Navigation -->
                <nav class="flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors duration-200">
                        <div
                            class="p-2 rounded-md bg-slate-100 dark:bg-slate-700 group-hover:bg-slate-200 dark:group-hover:bg-slate-600 transition-colors mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Retour au Tableau de Bord</span>
                    </a>
                </nav>

                <!-- View Mode Toggle -->
                <div class="flex items-center bg-slate-100 dark:bg-slate-700 rounded-lg p-1">
                    <button wire:click="$set('viewMode','board')"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ $viewMode === 'board' ? 'bg-white dark:bg-slate-600 text-slate-900 dark:text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                        Tableau
                    </button>
                    <button wire:click="$set('viewMode','list')"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ $viewMode === 'list' ? 'bg-white dark:bg-slate-600 text-slate-900 dark:text-white shadow-sm' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Liste
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        <!-- Project Header -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-8 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                        {{ $project->name }}
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">Organisez et suivez les tâches de votre projet</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3">
                    <button wire:click="$dispatch('openLabelModal')"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Étiquettes
                    </button>
                    <button wire:click="openCreateCategoryModal"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouvelle Catégorie
                    </button>
                </div>
            </div>
        </div>

        <!-- Label Filters -->
        @if($labels->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Filtrer par Étiquettes</h3>
                @if($filterByLabel)
                <button wire:click="clearLabelFilter"
                    class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                    Effacer le filtre
                </button>
                @endif
            </div>

            <div class="flex flex-wrap gap-2">
                <!-- All Tasks Button -->
                <button wire:click="clearLabelFilter"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg transition-colors duration-200
                    {{ !$filterByLabel ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600' }}">
                    Toutes les Tâches
                    <span class="ml-2 px-1.5 py-0.5 bg-white dark:bg-slate-600 rounded text-xs">
                        {{ collect($tasksByCategory)->flatten()->count() }}
                    </span>
                </button>

                <!-- Label Filter Buttons -->
                @foreach($labels as $label)
                @php
                $labelTaskCount = collect($tasksByCategory)->flatten()->filter(function ($task) use ($label) {
                return $task->labels->contains('id', $label->id);
                })->count();
                @endphp

                @if($labelTaskCount > 0)
                <button wire:click="$set('filterByLabel', {{ $label->id }})" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white rounded-lg transition-all duration-200 hover:opacity-90
                    {{ $filterByLabel === $label->id ? 'ring-2 ring-offset-2 ring-white dark:ring-slate-800' : '' }}"
                    style="background-color: {{ $label->color }}">
                    {{ $label->name }}
                    <span class="ml-2 px-1.5 py-0.5 bg-black/20 rounded text-xs">
                        {{ $labelTaskCount }}
                    </span>
                </button>
                @endif
                @endforeach
            </div>

            <!-- Active Filter Indicator -->
            @if($filterByLabel)
            @php
            $activeLabel = $labels->find($filterByLabel);
            @endphp
            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Affichage :</span>
                    <span class="inline-flex items-center px-2 py-1 text-sm font-medium text-white rounded"
                        style="background-color: {{ $activeLabel->color }}">
                        {{ $activeLabel->name }}
                    </span>
                    <span class="text-sm text-slate-500 dark:text-slate-400">tâches uniquement</span>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Content Area -->
        @if ($viewMode === 'list')
        <livewire:list-view :project="$project" />
        @else
        <!-- Board View -->
        <div class="overflow-x-auto">
            <div class="flex gap-6 pb-6 min-h-[calc(100vh-20rem)]">
                @foreach ($categories as $category)
                <div class="flex-shrink-0 w-80">
                    <!-- Category Column -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 h-fit">
                        <!-- Category Header -->
                        <div
                            class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-700">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $category->title }}</h2>

                            <!-- Category Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="p-1.5 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute right-0 top-full mt-1 w-44 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 z-50">
                                    <div class="py-1">
                                        <button wire:click="openEditCategoryModal({{ $category->id }})"
                                            class="w-full flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Modifier la Catégorie
                                        </button>
                                        <button wire:click="deleteCategory({{ $category->id }})"
                                            class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Supprimer la Catégorie
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Container -->
                        <div class="p-4 space-y-3 max-h-[calc(100vh-16rem)] overflow-y-auto">
                            @forelse($category->tasks as $task)
                            <!-- Task Card -->
                            <div wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
                                class="group p-4 rounded-lg border cursor-pointer transition-all duration-200
                                {{ $task->is_done == 1 ? 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-white dark:hover:bg-slate-700 hover:border-blue-300 dark:hover:border-blue-500' }}">

                                <!-- Task Labels -->
                                @if($task->labels->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($task->labels as $label)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-white rounded"
                                        style="background-color: {{ $label->color }}">
                                        {{ $label->name }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif

                                <!-- Task Header -->
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-medium text-slate-900 dark:text-white {{ $task->is_done ? 'line-through opacity-75' : '' }}
                                        {{ $task->isOverdue() ? 'text-red-600 dark:text-red-400' : '' }}">
                                        {{ $task->title }}
                                    </h3>

                                    <!-- Task Completion Checkbox -->
                                    <div class="flex-shrink-0 ml-3">
                                        <input type="checkbox"
                                            wire:click.stop="$dispatch('toggleTaskDone', {taskId: {{ $task->id }}})"
                                            {{ $task->is_done ? 'checked' : '' }}
                                            class="w-4 h-4 text-green-600 bg-white dark:bg-slate-600 border-slate-300 dark:border-slate-500 rounded focus:ring-green-500 dark:focus:ring-green-400">
                                    </div>
                                </div>

                                <!-- Task Description -->
                                @if($task->description)
                                <p
                                    class="text-sm text-slate-600 dark:text-slate-400 mb-3 {{ $task->is_done ? 'line-through opacity-75' : '' }}">
                                    {{ Str::limit($task->description, 80) }}
                                </p>
                                @endif

                                <!-- Task Meta -->
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <!-- Priority Badge -->
                                        @if($task->priority_level > 1)
                                        <span
                                            class="px-2 py-1 rounded font-medium
                                            {{ $task->priority_level === 4 ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}
                                            {{ $task->priority_level === 3 ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}
                                            {{ $task->priority_level === 2 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}">
                                            {{ $task->priority_text }}
                                        </span>
                                        @endif

                                        <!-- Team Size -->
                                        @if($task->users->count() > 1)
                                        <span
                                            class="flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            {{ $task->users->count() }}
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Deadline -->
                                    @if($task->deadline)
                                    <div
                                        class="flex items-center gap-1 {{ $task->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-slate-500 dark:text-slate-400' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $task->deadline->format('j M') }}</span>

                                        @if($task->isOverdue())
                                        <span class="px-1 py-0.5 bg-red-500 text-white text-[10px] font-bold rounded">
                                            {{ $task->getStatusAttribute() }}
                                        </span>
                                        @endif

                                    </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <!-- Empty State -->
                            <div class="text-center py-12 text-slate-400 dark:text-slate-500">
                                <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-sm font-medium">Aucune tâche</p>
                                <p class="text-xs">Ajoutez votre première tâche</p>
                            </div>
                            @endforelse

                            <!-- Add Task Button -->
                            <button wire:click="$dispatch('openCreateTaskModal', {categoryId: {{ $category->id }}})"
                                class="w-full p-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-blue-400 dark:hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-all duration-200 group">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span class="text-sm font-medium">Ajouter une Tâche</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <!-- Modals -->
    @include('livewire.category-modal')
    <livewire:task-manager :categories="$categories" />
    <livewire:label-manager :project="$project" />
</div>