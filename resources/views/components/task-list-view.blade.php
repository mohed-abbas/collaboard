<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
    <!-- Add Create Task Button -->
    <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
            Liste des tâches
            <span class="text-sm text-slate-500 dark:text-slate-400">({{ $filteredTasks->count() }})</span>
        </h2>
        <button wire:click="$dispatch('openCreateTaskModal', {categoryId: null})"
            class="inline-flex items-center px-4 py-2 bg-slate-900 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvelle tâche
        </button>
    </div>
    @if($filteredTasks->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer"
                            wire:click="sortTasks('title')">
                            Tâche
                            @if($sortBy === 'title')
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                </svg>
                            @endif
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Catégorie</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Étiquettes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer"
                            wire:click="sortTasks('deadline')">
                            Échéance
                            @if($sortBy === 'deadline')
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                </svg>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer"
                            wire:click="sortTasks('priority')">
                            Priorité
                            @if($sortBy === 'priority')
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                </svg>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer"
                            wire:click="sortTasks('status')">
                            Statut
                            @if($sortBy === 'status')
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                </svg>
                            @endif
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-600">
                    @foreach($filteredTasks as $task)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 {{ $task->is_done ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <input type="checkbox" {{ $task->is_done ? 'checked' : '' }}
                                        wire:click="$dispatch('toggleTaskDone', {taskId: {{ $task->id }}})"
                                        class="w-4 h-4 text-green-600 bg-white dark:bg-slate-600 border-slate-300 dark:border-slate-500 rounded focus:ring-green-500 mr-3">
                                    <div>
                                        <div
                                            class="text-sm font-medium text-slate-900 dark:text-white {{ $task->is_done ? 'line-through' : '' }}">
                                            {{ Str::limit($task->title, 40) }}
                                        </div>
                                        @if($task->description)
                                            <div
                                                class="text-sm text-slate-500 dark:text-slate-400 {{ $task->is_done ? 'line-through' : '' }}">
                                                {{ Str::limit($task->description, 60) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                                    style="background-color: {{ $task->category->color }}20; color: {{ $task->category->color }};">
                                    {{ $task->category->title }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($task->labels as $label)
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-white rounded"
                                            style="background-color: {{ $label->color }}">
                                            {{ $label->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($task->deadline)
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-sm {{ $task->isOverdue() && !$task->is_done ? 'text-red-600 dark:text-red-400 font-medium' : 'text-slate-900 dark:text-white' }}">
                                            {{ $task->deadline->format('j M Y') }}
                                        </span>
                                        @if($task->isOverdue() && !$task->is_done)
                                            <span
                                                class="px-1.5 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-medium rounded">
                                                Retard
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-1.5 py-0.5 rounded text-xs font-bold {{ $task->priority_level === 1 ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }} {{ $task->priority_level === 4 ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}{{ $task->priority_level === 3 ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }} {{ $task->priority_level === 2 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}">
                                    {{ $task->priority_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $task->is_done ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' }}">
                                    {{ $task->is_done ? 'Terminée' : 'En cours' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="$dispatch('openEditTaskModal', {taskId: {{ $task->id }}})"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="$dispatch('deleteTask', {taskId: {{ $task->id }}})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette tâche ?"
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-12 h-12 mx-auto text-slate-400 dark:text-slate-500 mb-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Aucune tâche trouvée</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-4">Essayez d'ajuster vos filtres ou créez une nouvelle tâche.
            </p>
            @if($searchTerm || $selectedCategory || $showPendingOnly || !empty($selectedLabels))
                <button wire:click="clearFilters"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Effacer les filtres
                </button>
            @endif
        </div>
    @endif
</div>