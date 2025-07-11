<div @open-create-project-modal.window="$wire.openCreateModal()">
    @unless($hideProjectsList)
        <!-- Projects Section Header -->
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-slate-900 dark:text-white">Projets</h3>
                <span class="text-xs text-slate-500 dark:text-slate-400">{{ count($projects) }}</span>
            </div>
        </div>

        <!-- Projects List -->
        <div class="space-y-1">
            @forelse($projects as $project)
                <div class="group">
                    <div
                        class="flex items-center justify-between p-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 rounded-lg transition-colors">
                        <!-- Project Link -->
                        <a href="{{ route('project.board', $project->id) }}" class="flex items-center space-x-3 flex-1 min-w-0"
                            wire:navigate>
                            <!-- Project Avatar with Colors -->
                            <div
                                class="w-6 h-6 rounded flex items-center justify-center flex-shrink-0 bg-gradient-to-br {{ $this->getProjectColors($project->name) }}">
                                <span class="text-white font-medium text-xs">
                                    {{ strtoupper(substr($project->name, 0, 1)) }}
                                </span>
                            </div>

                            <!-- Project Info -->
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-slate-900 dark:text-white text-sm truncate">
                                    {{ $project->name }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $project->created_at->diffForHumans() }}
                                    @if(auth()->user()->id === $project->owner_id)
                                        · Manager
                                    @endif
                                </div>
                            </div>
                        </a>

                        <!-- Actions Menu for Owners and Members -->
                        @if(auth()->user()->id === $project->owner_id || $project->members->contains('id', auth()->user()->id))
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="p-1 hover:bg-slate-200 dark:hover:bg-slate-600 rounded opacity-0 group-hover:opacity-100 transition-all">
                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute right-0 top-full mt-1 w-44 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 shadow-lg z-50">
                                    <div class="py-1">
                                        <a href="{{ route('project.board', $project->id) }}"
                                            class="flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"
                                            wire:navigate>
                                            <svg class="w-4 h-4 mr-2 text-slate-500 dark:text-slate-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7v4m0 0h-4" />
                                            </svg>
                                            Ouvrir
                                        </a>

                                        @if(auth()->user()->id === $project->owner_id)
                                            <a href="{{ route('project.settings', $project->id) }}"
                                                class="flex items-center px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"
                                                wire:navigate>
                                                <svg class="w-4 h-4 mr-2 text-slate-500 dark:text-slate-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Paramètres
                                            </a>

                                            <div class="border-t border-slate-200 dark:border-slate-600 my-1"></div>

                                            <button wire:click="deleteProject({{ $project->id }})"
                                                wire:confirm="Êtes-vous sûr de vouloir supprimer {{ $project->name }} ?"
                                                class="flex items-center w-full px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        @else
                                            <div class="border-t border-slate-200 dark:border-slate-600 my-1"></div>

                                            <button wire:click="leaveProject({{ $project->id }})"
                                                wire:confirm="Êtes-vous sûr de vouloir quitter {{ $project->name }} ?"
                                                class="flex items-center w-full px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Quitter le projet
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-6">
                    <div
                        class="w-12 h-12 mx-auto mb-3 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Aucun projet</p>
                    <button wire:click="openCreateModal"
                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer un projet
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Create New Project Button -->
        @if(count($projects) > 0)
            <div class="mt-4 pt-4">
                <button wire:click="openCreateModal"
                    class="w-full flex items-center justify-center p-2 border border-dashed border-slate-300 dark:border-slate-600 hover:border-blue-400 dark:hover:border-blue-500 rounded-lg text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouveau projet
                </button>
            </div>
        @endif
    @endunless

    {{-- Project Modal --}}
    @include('livewire.project-modal')
</div>