<div>
    <!-- Première section: liste des projets -->
    <div class="bg-tranparent rounded-lg shadow overflow-hidden p-4">
        <h3 class="text-lg font-semibold mb-2">My Projects</h3>
        <ul class="divide-y divide-gray-200">
            @forelse($projects as $project)
                <li class="relative flex justify-between items-center py-2" x-data="{ open: false }">
                    <!-- Project Name -->
                    <div>
                        <a href="{{ route('projects.board', $project->id) }}"
                            class="text-blue-600 hover:text-blue-800 hover:underline">
                            {{ $project->name }}
                        </a>
                    </div>

                    <!-- Dropdown Trigger & Menu -->
                    <div class="relative">
                        <!-- Ellipsis Button -->
                        <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200 focus:outline-none">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                            <ul x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-20">
                                <li>
                                    <button wire:click="openEditModal({{ $project->id }})" @click="open = false"
                                        class="block w-full text-left text-black px-4 py-2 hover:bg-gray-100">
                                        Modifier
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="deleteProject({{ $project->id }})" @click="open = false"
                                        onclick="confirm('Supprimer ce projet ?') || event.stopImmediatePropagation()"
                                        class="block w-full text-left px-4 text-black py-2 hover:bg-gray-100">
                                        Supprimer
                                    </button>
                                </li>
                            </ul>
                    </div>
                </li>
            @empty
                <li class="py-2 text-gray-500">
                    You're not part of any projects yet.
                </li>
            @endforelse

            <br>
            <button 
                        onclick="Livewire.dispatch('openCreateProjectModal')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                    >
                        Nouveau projet
                    </button>
        </ul>
    </div>

    <!-- Deuxième section: modal (maintenant à l'extérieur du conteneur principal) -->
    {{-- Project Modal --}}
    <div>
        <div x-data="{ show: @entangle('showModal') }"
             x-show="show"
             x-cloak
             class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <!-- Add the livewire project-modal component here -->
                    @livewire('project-modal')
                </div>
            </div>
        </div>
    </div>
</div>