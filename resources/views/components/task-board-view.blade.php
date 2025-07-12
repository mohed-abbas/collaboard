<div class="flex gap-6 min-h-[calc(100vh-12rem)] overflow-x-auto pb-4 max-w-full" id="board-container">
    @foreach ($categories as $category)
        @php
            $categoryTasks = $filteredTasks->where('category_id', $category->id)->sortBy('position');
        @endphp
        <div class="flex-shrink-0 w-80">
            <!-- Category Header - List View Style -->
            <div class="mb-4 border-b-2 rounded-lg"
                style="background-color: {{ $category->color }}20; border-color: {{ $category->color }};">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold tracking-wide" style="color: {{ $category->color }};">
                            {{ Str::limit($category->title, 20) }}
                        </h2>
                        <span class="px-2 py-1 text-xs font-medium rounded"
                            style="background-color: {{ $category->color }}40; color: {{ $category->color }};">
                            {{ $categoryTasks->count() }}
                        </span>
                    </div>

                    <!-- Category Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 012 2z" />
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 top-full mt-1 w-40 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 z-50">
                            <div class="py-1">
                                <button wire:click="openEditCategoryModal({{ $category->id }})"
                                    class="w-full flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                </button>

                                <!-- Only show this option for the categories non system and for the system categories only owner should see it -->
                                @if (!$category->is_system || (Auth::user()->id === $project->owner_id))
                                    <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Êtes-vous sûr ?"
                                        class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Container with Drag and Drop -->
            <div class="category-column min-h-[400px] p-2 rounded-lg border-2 border-dashed border-transparent transition-all duration-200"
                data-category-id="{{ $category->id }}">
                @forelse($categoryTasks as $task)
                    @include('components.task-card', ['task' => $task])
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-8 px-4">
                        <div
                            class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Aucune tâche</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Créez votre première tâche</p>
                    </div>
                @endforelse

                <!-- Add Task Button -->
                <div class="pt-3">
                    <button wire:click="$dispatch('openCreateTaskModal', {categoryId: {{ $category->id }}})"
                        class="group w-full p-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-blue-400 dark:hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-all duration-200">
                        <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm font-medium">Ajouter une tâche</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Category Column -->
    <div class="flex-shrink-0 w-80">
        <div class="mb-4 bg-slate-50 dark:bg-slate-700/50 border-b-2 border-slate-200 dark:border-slate-600 rounded-lg">
            <button wire:click="openCreateCategoryModal"
                class="group w-full px-4 py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all duration-200 rounded-lg bg-transparent">
                <div class="flex items-center justify-center gap-3">
                    <div
                        class="w-6 h-6 bg-slate-200 dark:bg-slate-600 rounded flex items-center justify-center group-hover:bg-blue-100 dark:group-hover:bg-blue-900/20 transition-colors">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <span
                        class="font-bold text-slate-600 dark:text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 tracking-wide transition-colors">
                        Nouvelle catégorie
                    </span>
                </div>
            </button>
        </div>
    </div>
</div>