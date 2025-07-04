<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-visible">
    <!-- Header -->
    <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div
                    class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Mes Projets</h3>
            </div>
            <div class="flex items-center space-x-2">
                <span
                    class="text-xs bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300 px-2 py-1 rounded-full">
                    {{ count($projects) }}
                </span>

            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="max-h-80 overflow-y-auto custom-scrollbar">
        @forelse($projects as $project)
        <div
            class="group px-3 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-200 border-b border-slate-100 dark:border-slate-700 last:border-b-0">
            <div class="flex items-center space-x-3">
                <!-- Project Avatar -->
                <a href="{{ route('project.board', $project->id) }}"
                    class="flex-shrink-0 hover:scale-110 transition-transform duration-200">
                    <div
                        class="w-8 h-8 bg-gradient-to-br {{ $this->getProjectColors($project->name) }} rounded-lg flex items-center justify-center shadow-sm">
                        <span class="text-white font-bold text-xs">
                            {{ strtoupper(substr($project->name, 0, 2)) }}
                        </span>
                    </div>
                </a>

                <!-- Project Info -->
                <div class="flex-1 min-w-0">
                    <a href="{{ route('project.board', $project->id) }}"
                        class="block hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        <div class="font-medium text-slate-900 dark:text-white text-sm truncate">
                            {{ $project->name }}
                        </div>
                        <div class="flex items-center space-x-2 mt-0.5">
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $project->created_at->diffForHumans() }}
                            </span>
                            <!-- Role indicator -->
                            @if(auth()->user()->id === $project->owner_id)
                            <span
                                class="inline-flex items-center px-1.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs font-medium">
                                Propriétaire
                            </span>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- Actions for Owners - Modal Approach -->
                @if(auth()->user()->id === $project->owner_id)
                <div x-data="{ showActions: false }" class="relative">
                    <button @click="showActions = !showActions"
                        class="p-1 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-md opacity-0 group-hover:opacity-100 transition-all duration-200"
                        title="Options du Projet">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>

                    <!-- Modal-style overlay -->
                    <div x-show="showActions" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @click.away="showActions = false"
                        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/20 backdrop-blur-sm"
                        style="display: none;">

                        <div @click.stop x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-2xl max-w-xs w-full mx-4 overflow-hidden">

                            <!-- Modal Header -->
                            <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br {{ $this->getProjectColors($project->name) }} rounded-lg flex items-center justify-center">

                                        <span class="text-white font-bold text-xs">
                                            {{ strtoupper(substr($project->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-slate-900 dark:text-white text-sm truncate">
                                            {{ $project->name }}
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Options du Projet</p>
                                    </div>
                                    <button @click="showActions = false"
                                        class="p-1 hover:bg-slate-100 dark:hover:bg-slate-700 rounded">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Modal Actions -->
                            <div class="p-2">
                                <a href="{{ route('project.board', $project->id) }}" @click="showActions = false"
                                    class="flex items-center w-full px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3 text-slate-500 dark:text-slate-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7v4m0 0h-4" />
                                    </svg>
                                    Ouvrir le Projet
                                </a>

                                <a href="{{ route('project.settings', $project->id) }}" @click="showActions = false"
                                    class="flex items-center w-full px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3 text-slate-500 dark:text-slate-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Paramètres du Projet
                                </a>

                                <div class="border-t border-slate-100 dark:border-slate-700 my-2"></div>

                                <button wire:click="deleteProject({{ $project->id }})" @click="showActions = false"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer {{ $project->name }} ? Cette action ne peut pas être annulée.')"
                                    class="flex items-center w-full px-3 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer le Projet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <!-- Compact Empty State -->
        <div class="px-4 py-8 text-center">
            <div
                class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h4 class="text-sm font-semibold text-slate-900 dark:text-white mb-1">Aucun projet pour le moment</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">Créez votre premier projet pour commencer</p>
            <button wire:click="openCreateModal"
                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-all duration-200 hover:scale-105 transform">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Créer un Projet
            </button>
        </div>
        @endforelse
    </div>

    <!-- Bottom Create Button (if there are projects) -->
    @if(count($projects) > 0)
    <div class="p-3 border-t border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/25">
        <button wire:click="openCreateModal"
            class="w-full flex items-center justify-center px-3 py-2 border border-dashed border-slate-300 dark:border-slate-600 hover:border-blue-400 dark:hover:border-blue-500 rounded-lg text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition-all duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 group">
            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nouveau Projet
        </button>
    </div>
    @endif

    {{-- Project Modal --}}
    @include('livewire.project-modal')
</div>