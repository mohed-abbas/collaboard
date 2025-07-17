<div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-200">


    <!-- Modern Header -->
    <header
        class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Back Button + Title -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('project.board', $project->id) }}"
                        class="inline-flex items-center p-2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>

                    <div class="flex items-center space-x-3">
                        @php
                            $firstLetter = strtoupper(substr($project->name, 0, 1));
                            $colors = [
                                'A' => 'bg-red-500',
                                'B' => 'bg-blue-500',
                                'C' => 'bg-green-500',
                                'D' =>
                                    'bg-purple-500'
                            ];
                            $colorClass = $colors[$firstLetter] ?? 'bg-slate-500';
                        @endphp

                        <div class="w-8 h-8 {{ $colorClass }} rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ $firstLetter }}</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-900 dark:text-white">{{ $project->name }}</h1>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Paramètres du projet</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Project Actions -->
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center space-x-2 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 rounded-full border border-green-200 dark:border-green-800">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-xs font-medium text-green-700 dark:text-green-300">Actif</span>
                    </div>

                    <div
                        class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            {{ count($members) }} membre{{ count($members) > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @include('livewire.flash-messages')

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Settings Panel -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Project Information Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Informations du projet
                                </h2>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Modifiez les détails de votre
                                    projet</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <form wire:submit.prevent="saveSettings" class="space-y-6">
                            <!-- Project Name -->
                            <div>
                                <label for="projectName"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Nom du projet
                                </label>
                                <input type="text" id="projectName" wire:model="projectName"
                                    class="block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Nom de votre projet">
                                @error('projectName')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Project Description -->
                            <div>
                                <label for="projectDescription"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Description
                                </label>
                                <textarea id="projectDescription" wire:model="projectDescription" rows="4"
                                    class="block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                    placeholder="Décrivez votre projet..."></textarea>
                                @error('projectDescription')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Sauvegarder
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Team Management Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Équipe</h2>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Gérez les membres de votre
                                        projet</p>
                                </div>
                            </div>

                            <span
                                class="inline-flex items-center px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded text-xs font-medium">
                                {{ count($members) }} membre{{ count($members) > 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Add Member Section -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Ajouter un membre
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model.live="searchMember" wire:focus="showSearchResults = true"
                                    class="block w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                    placeholder="Rechercher par nom ou email...">
                            </div>
                            @error('newMemberEmail')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            <!-- Search Results -->
                            @if($showSearchResults && !empty($searchMember))
                                <div
                                    class="absolute z-20 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    @if(count($searchResults) > 0)
                                        @foreach($searchResults as $user)
                                            <div
                                                class="flex items-center justify-between p-3 hover:bg-slate-50 dark:hover:bg-slate-700 border-b last:border-b-0 border-slate-100 dark:border-slate-600">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                                        <span class="text-slate-600 dark:text-slate-300 font-semibold text-sm">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-slate-900 dark:text-white">{{ $user->name }}
                                                        </div>
                                                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <button wire:click="addMemberToProject({{ $user->id }})"
                                                    class="px-3 py-1 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded transition-colors">
                                                    Ajouter
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-4 text-center text-slate-500 dark:text-slate-400">
                                            Aucun utilisateur trouvé
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Current Members -->
                        <div>
                            <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Membres actuels</h3>
                            @if(count($members) > 0)
                                <div class="space-y-2">
                                    @foreach($members as $member)
                                        <div
                                            class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-600">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 bg-slate-200 dark:bg-slate-600 rounded-lg flex items-center justify-center">
                                                    <span class="text-slate-700 dark:text-slate-300 font-semibold text-sm">
                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-slate-900 dark:text-white">{{ $member->name }}
                                                    </div>
                                                    <div class="text-sm text-slate-500 dark:text-slate-400">{{ $member->email }}
                                                    </div>
                                                </div>
                                            </div>

                                            @if($member->id !== auth()->id())
                                                <button wire:click="removeMember({{ $member->id }})"
                                                    onclick="return confirm('Retirer {{ $member->name }} de ce projet ?')"
                                                    class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 p-1 rounded transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs font-medium">
                                                    Propriétaire
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="text-center py-8 bg-slate-50 dark:bg-slate-700/50 rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-600">
                                    <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Aucun membre d'équipe</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Project Stats -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Informations</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Membres</span>
                            <span
                                class="text-sm font-semibold text-slate-900 dark:text-white">{{ count($members) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Créé le</span>
                            <span
                                class="text-sm font-semibold text-slate-900 dark:text-white">{{ $project->created_at->format('j M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Mis à jour</span>
                            <span
                                class="text-sm font-semibold text-slate-900 dark:text-white">{{ $project->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Actions rapides</h3>
                    <div class="space-y-3">
                        <a href="{{ route('project.board', $project->id) }}"
                            class="flex items-center w-full px-4 py-2 text-left text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Voir le tableau
                        </a>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-red-200 dark:border-red-800 overflow-hidden">
                    <div class="bg-red-50 dark:bg-red-900/20 px-6 py-4 border-b border-red-200 dark:border-red-800">
                        <h3 class="text-sm font-semibold text-red-900 dark:text-red-100">Zone de danger</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-red-700 dark:text-red-300 mb-4">
                            La suppression de ce projet est irréversible.
                        </p>
                        <button wire:click="$dispatch('deleteProject', {id: {{$project->id}}})"
                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce projet ?"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Supprimer le projet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>