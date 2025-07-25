<div
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 transition-colors duration-300">
    <!-- Compact Header -->
    <header
        class="sticky top-0 z-40 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border-b border-slate-200/60 dark:border-slate-700/60">
        <div class="max-w-full mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Navigation -->
                <nav class="flex items-center flex-1 min-w-0">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300"
                        wire:navigate>
                        <div
                            class="p-2 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/50 group-hover:scale-110 transition-transform duration-300 mr-3">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        <h1
                            class="text-lg lg:text-xl font-bold bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent truncate">
                            {{ $project->name }}
                        </h1>
                    </a>
                </nav>

                <!-- Action Buttons - Always Visible -->
                <div class="flex items-center gap-2 lg:gap-3">

                    <!-- Add settings button only visible to the owner of the project -->

                    @if ($project->owner_id === auth()->id())
                        <a href="{{ route('project.settings', $project) }}" wire:navigate
                            class="group flex items-center px-3 py-2 lg:px-4 lg:py-2 bg-slate-900 dark:bg-slate-200 text-slate-600 hover:text-white rounded-xl transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4 stroke-white dark:stroke-black transition-colors duration-300" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    @endif

                    <!-- Filters Toggle -->
                    <button x-data="{ open: false }" @click="open = !open; $dispatch('toggle-filters')"
                        class="group flex items-center px-3 py-2 lg:px-4 lg:py-2 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition-all duration-300">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z" />
                        </svg>
                        <span class="hidden sm:block text-sm font-medium ml-2">Filtres</span>
                    </button>

                    <!-- Labels Button -->
                    <button wire:click="$dispatch('openLabelModal')"
                        class="group flex items-center px-3 py-2 lg:px-4 lg:py-2 bg-slate-900 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl transition-all duration-300 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="hidden sm:block text-sm font-medium ml-2">Étiquettes</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Floating View Mode Selector -->
    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-30">
        <div
            class="flex items-center bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border border-slate-200/60 dark:border-slate-700/60 rounded-2xl p-2 shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50">
            <button wire:click="$set('viewMode','board')"
                class="flex flex-col items-center px-4 py-3 text-xs font-medium rounded-xl transition-all duration-200 {{ $viewMode === 'board' ? 'bg-slate-900 text-white shadow-lg shadow-blue-500/25' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                </svg>
                <span>Tableau</span>
            </button>
            <button wire:click="$set('viewMode','list')"
                class="flex flex-col items-center px-4 py-3 text-xs font-medium rounded-xl transition-all duration-200 {{ $viewMode === 'list' ? 'bg-slate-900 text-white shadow-lg shadow-blue-500/25' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="mx-2">Liste</span>
            </button>
            <button wire:click="$set('viewMode','calendar')"
                class="flex flex-col items-center px-4 py-3 text-xs font-medium rounded-xl transition-all duration-200 {{ $viewMode === 'calendar' ? 'bg-slate-900 text-white shadow-lg shadow-blue-500/25' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="8" width="18" height="13" rx="2" stroke-width="2" stroke="currentColor"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18" />
                </svg>
                <span>Calendrier</span>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @include('livewire.flash-messages')

    <!-- Collapsible Filters Panel -->
    <div x-data="{ open: false }" @toggle-filters.window="open = !open" x-show="open"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
        class="bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border-b border-slate-200/60 dark:border-slate-700/60 shadow-lg">

        <div class="max-w-full mx-auto px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Rechercher..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300" />
                </div>

                <!-- Category Filter -->
                <div class="relative">
                    <select wire:model.live="selectedCategory"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300 appearance-none">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="relative">
                    <select wire:model.live="sortBy"
                        class="w-full px-4 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-300 appearance-none">
                        <option value="created_at">Date de création</option>
                        <option value="title">Titre</option>
                        <option value="deadline">Échéance</option>
                        <option value="priority">Priorité</option>
                        <option value="status">Statut</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Pending Only -->
                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.live="showPendingOnly"
                            class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" />
                        <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">En cours uniquement</span>
                    </label>
                </div>

                <!-- Clear Filters -->
                <div class="flex items-center justify-end">
                    @if($searchTerm || $selectedCategory || $showPendingOnly || !empty($selectedLabels))
                        <button wire:click="clearFilters"
                            class="flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-300">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Effacer
                        </button>
                    @endif
                </div>
            </div>

            <!-- Label Filters -->
            @if($labels->count() > 0)
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-600">
                    <div class="flex flex-wrap gap-2">
                        @foreach($labels as $label)
                            @php
                                $isSelected = in_array($label->id, $selectedLabels);
                            @endphp
                            <button wire:click="toggleLabel({{ $label->id }})"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-300 {{ $isSelected ? 'ring-2 ring-blue-500/50' : 'hover:scale-105' }}"
                                style="background: {{ $label->color }}20; color: {{ $label->color }}; border: 1px solid {{ $label->color }}40;">
                                <div class="w-2 h-2 rounded-full mr-1.5" style="background: {{ $label->color }};"></div>
                                {{ $label->name }}
                                @if($isSelected)
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <!-- Content Area -->
        @if ($viewMode === 'list')
            <!-- List View -->
            @include('components.task-list-view')
        @elseif ($viewMode === 'calendar')
            <!-- Calendar View -->
            @include('components.task-calendar-view')

        @else
            <!-- Board View -->
            @include('components.task-board-view')
        @endif

    </main>

    <!-- Modals -->
    @include('livewire.category-modal')
    <livewire:task-manager :categories="$categories" :viewMode="$viewMode" />
    <livewire:label-manager :project="$project" />
</div>

<script>
    document.addEventListener('livewire:init', () => {
        // Handle task deletion to prevent 404 errors
        Livewire.on('projectUpdated', () => {
            // Force close any task modals
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (window.Alpine && modal.__x) {
                    // For Alpine.js modals
                    modal.__x.$data.showModal = false;
                }
            });

            // Remove any references to deleted tasks in the DOM
            const taskElements = document.querySelectorAll('[data-task-id]');
            taskElements.forEach(el => {
                // Check if this task still exists in the current data
                const taskId = el.getAttribute('data-task-id');
                if (taskId) {
                    const taskExists = false;
                    // If not found in data, remove from DOM
                    if (!taskExists) {
                        el.remove();
                    }
                }
            });
        });
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('forceCalendarRefresh', () => {
            // Wait a moment to allow Livewire operations to complete
            setTimeout(() => {
                window.location.reload();
            }, 200);
        });
    });
</script>