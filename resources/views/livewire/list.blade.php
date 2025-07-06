<div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 p-6 transition-colors duration-300">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1
                    class="text-3xl lg:text-4xl font-black bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                    Gestion des Tâches
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2 text-lg">
                    Organisez et suivez l'avancement de vos projets
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-4">
                <button type="button"
                    class="inline-flex items-center px-4 py-2.5 border-2 border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm hover:bg-slate-50 dark:hover:bg-slate-700/80 font-medium transition-all duration-300 hover:scale-105 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exporter
                </button>
                <button wire:click="$dispatch('openCreateTaskModal')"
                    class="group inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 dark:from-blue-500 dark:via-purple-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:via-purple-600 dark:hover:to-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/30 dark:hover:shadow-blue-400/25 transform">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouvelle Tâche
                </button>
            </div>
        </div>

        <!-- Filters & Search Section -->
        <div
            class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/60 dark:border-slate-700/60 shadow-lg dark:shadow-slate-900/20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Search Bar -->
                <div class="lg:col-span-2 space-y-2">
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white tracking-wide">
                        Recherche globale
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            class="w-full pl-12 pr-4 py-3 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:focus:ring-blue-400/50 dark:focus:border-blue-400 transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500 text-sm"
                            type="text" placeholder="Rechercher par titre, description..."
                            wire:model.live.debounce.300ms="searchTerm" />
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white tracking-wide">
                        Catégorie
                    </label>
                    <div class="relative">
                        <select name="filter-category" id="filter-category"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:focus:ring-blue-400/50 dark:focus:border-blue-400 transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500 appearance-none cursor-pointer text-sm"
                            wire:model.live="selectedCategory">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-900 dark:text-white tracking-wide">
                        Filtres avancés
                    </label>
                    <div class="space-y-3">
                        <div
                            class="flex items-center space-x-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                            <input id="show-pending-only" type="checkbox" wire:model.live="showPendingOnly"
                                class="w-4 h-4 text-blue-600 bg-white border-2 border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 transition-colors" />
                            <label
                                class="text-sm font-medium text-slate-700 dark:text-slate-300 select-none cursor-pointer"
                                for="show-pending-only">
                                Tâches en cours uniquement
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if($searchTerm || $selectedCategory || $showPendingOnly)
            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 flex-wrap gap-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Filtres actifs:</span>

                        @if($searchTerm)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                            Recherche: "{{ $searchTerm }}"
                        </span>
                        @endif

                        @if($selectedCategory)
                        @php
                        $selectedCategoryName = $categories->where('id', $selectedCategory)->first()?->title ??
                        'Inconnue';
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200">
                            Catégorie: {{ $selectedCategoryName }}
                        </span>
                        @endif

                        @if($showPendingOnly)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-200">
                            En cours uniquement
                        </span>
                        @endif
                    </div>

                    <button wire:click="clearFilters"
                        class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors">
                        Effacer les filtres
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- Tasks Table -->
        <div
            class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-lg dark:shadow-slate-900/20 overflow-hidden">
            @if($tasks->count() > 0)
            <!-- Table Header -->
            <div class="bg-slate-50 dark:bg-slate-700/50 border-b-2 border-slate-200 dark:border-slate-600">
                <div class="grid grid-cols-12 gap-4 px-6 py-4">
                    <div class="col-span-3 text-sm font-bold text-slate-900 dark:text-white tracking-wide uppercase">
                        Tâche
                    </div>
                    <div class="col-span-2 text-sm font-bold text-slate-900 dark:text-white tracking-wide uppercase">
                        Catégorie & Étiquettes
                    </div>
                    <div class="col-span-2 text-sm font-bold text-slate-900 dark:text-white tracking-wide uppercase">
                        Statut
                    </div>
                    <div class="col-span-2 text-sm font-bold text-slate-900 dark:text-white tracking-wide uppercase">
                        Échéance
                    </div>
                    <div class="col-span-3 text-sm font-bold text-slate-900 dark:text-white tracking-wide uppercase">
                        Actions
                    </div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-slate-200 dark:divide-slate-600">
                @foreach ($tasks as $task)
                <div
                    class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors duration-200 group">

                    <!-- Task Info -->
                    <div class="col-span-3 space-y-1">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-2 h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 dark:from-blue-400 dark:to-purple-400 flex-shrink-0 mt-2">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors cursor-pointer"
                                    wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })">
                                    {{ $task->title }}
                                </h3>
                                @if($task->description)
                                <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 mt-1">
                                    {{ Str::limit($task->description, 80) }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Category & Labels -->
                    <div class="col-span-2 space-y-2">
                        <!-- Category -->
                        <div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 dark:from-indigo-900/50 dark:to-purple-900/50 dark:text-indigo-200 border border-indigo-200 dark:border-indigo-800">
                                {{ $task->category->title }}
                            </span>
                        </div>

                        <!-- Labels -->
                        @if($task->labels && $task->labels->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($task->labels as $label)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium border"
                                style="background-color: {{ $label->color }}20; color: {{ $label->color }}; border-color: {{ $label->color }}40;">
                                <div class="w-2 h-2 rounded-full mr-1" style="background-color: {{ $label->color }};">
                                </div>
                                {{ $label->name }}
                            </span>
                            @endforeach
                        </div>
                        @else
                        <span class="text-xs text-slate-400 dark:text-slate-500 italic">
                            Aucune étiquette
                        </span>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="col-span-2 flex items-center">
                        @if($task->is_done)
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900/50 dark:to-emerald-900/50 dark:text-green-200 border border-green-200 dark:border-green-800">
                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Terminée
                        </span>
                        @else
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 dark:from-yellow-900/50 dark:to-orange-900/50 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                            En cours
                        </span>
                        @endif
                    </div>

                    <!-- Deadline -->
                    <div class="col-span-2 flex items-center">
                        @if($task->deadline)
                        @php
                        $deadline = \Carbon\Carbon::parse($task->deadline);
                        $isOverdue = $deadline->isPast() && !$task->is_done;
                        $isDueSoon = $deadline->diffInDays(now()) <= 1 && !$deadline->isPast() && !$task->is_done;
                            @endphp
                            <div class="flex flex-col space-y-1">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span
                                        class="text-sm {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-semibold' : ($isDueSoon ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-400') }}">
                                        {{ $deadline->format('d/m/Y') }}
                                    </span>
                                </div>
                                @if($isOverdue)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200">
                                    En retard
                                </span>
                                @elseif($isDueSoon)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-200">
                                    Urgent
                                </span>
                                @endif
                            </div>
                            @else
                            <span class="text-sm text-slate-400 dark:text-slate-500 italic">
                                Non définie
                            </span>
                            @endif
                    </div>

                    <!-- Actions -->
                    <div class="col-span-3 flex items-center space-x-2">
                        <button wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
                            class="p-2 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200"
                            title="Modifier">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button wire:click="toggleTaskStatus({{ $task->id }})"
                            class="p-2 text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-all duration-200"
                            title="{{ $task->is_done ? 'Marquer comme en cours' : 'Marquer comme terminée' }}">
                            @if($task->is_done)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            @endif
                        </button>
                        <button wire:click="deleteTask({{ $task->id }})"
                            wire:confirm="Êtes-vous sûr de vouloir supprimer cette tâche ?"
                            class="p-2 text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200"
                            title="Supprimer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-20 px-6">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/50 dark:to-purple-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                    {{ $searchTerm || $selectedCategory || $showPendingOnly ? 'Aucun résultat trouvé' : 'Aucune tâche créée' }}
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto leading-relaxed">
                    {{ $searchTerm || $selectedCategory || $showPendingOnly
                ? 'Aucune tâche ne correspond à vos critères de recherche. Essayez de modifier vos filtres.'
                : 'Commencez par créer votre première tâche pour organiser votre travail.' }}
                </p>
                @if(!$searchTerm && !$selectedCategory && !$showPendingOnly)
                <button wire:click="$dispatch('openCreateTaskModal')"
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 dark:from-blue-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:to-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/30 dark:hover:shadow-blue-400/25 transform">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Créer ma première tâche
                </button>
                @else
                <button wire:click="clearFilters"
                    class="inline-flex items-center px-6 py-3 bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-50 dark:hover:bg-slate-600 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Effacer les filtres
                </button>
                @endif
            </div>
            @endif
        </div>

        <!-- Advanced Statistics Dashboard -->
        @if($tasks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Tasks -->
            <div
                class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-200/60 dark:border-slate-700/60 shadow-lg dark:shadow-slate-900/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                            Total</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $tasks->count() }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tâches créées</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 dark:from-blue-400 dark:to-cyan-400 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Tasks -->
            <div
                class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-200/60 dark:border-slate-700/60 shadow-lg dark:shadow-slate-900/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                            Terminées</p>
                        <p class="text-3xl font-black text-green-600 dark:text-green-400 mt-1">
                            {{ $tasks->where('is_done', true)->count() }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ $tasks->count() > 0 ? round(($tasks->where('is_done', true)->count() / $tasks->count()) * 100) : 0 }}%
                            du total
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 dark:from-green-400 dark:to-emerald-400 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div
                class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-200/60 dark:border-slate-700/60 shadow-lg dark:shadow-slate-900/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">En
                            cours</p>
                        <p class="text-3xl font-black text-orange-600 dark:text-orange-400 mt-1">
                            {{ $tasks->where('is_done', false)->count() }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">À compléter</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 dark:from-yellow-400 dark:to-orange-400 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Overdue Tasks -->
            <div
                class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-xl p-6 border border-slate-200/60 dark:border-slate-700/60 shadow-lg dark:shadow-slate-900/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">En
                            retard</p>
                        @php
                        $overdueTasks = $tasks->filter(function ($task) {
                        return $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && !$task->is_done;
                        });
                        @endphp
                        <p class="text-3xl font-black text-red-600 dark:text-red-400 mt-1">{{ $overdueTasks->count() }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Nécessitent attention</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 dark:from-red-400 dark:to-pink-400 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.966-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>