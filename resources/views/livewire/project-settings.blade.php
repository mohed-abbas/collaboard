<div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
    @include('livewire.flash-messages')

    <!-- Refined Header -->
    <header
        class="bg-white/95 dark:bg-slate-800/95 backdrop-blur-sm border-b border-slate-200 dark:border-slate-700 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div
                            class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-slate-800">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Paramètres du Projet</h1>
                        <p class="text-slate-600 dark:text-slate-400">Configurez votre espace de travail</p>
                    </div>
                </div>


            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-5xl mx-auto px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Settings Panel -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Project Details Card -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Détails du Projet</h2>
                        </div>
                    </div>

                    <div class="p-8">
                        <form wire:submit.prevent="saveSettings" class="space-y-6">
                            <!-- Project Name -->
                            <div class="space-y-2">
                                <label for="projectName"
                                    class="block text-sm font-semibold text-slate-900 dark:text-white">
                                    Nom du Projet <span class="text-red-500">*</span>
                                </label>
                                <input id="projectName" type="text" wire:model="projectName"
                                    class="w-full px-4 py-4 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-lg"
                                    placeholder="Entrez le nom de votre projet">
                                @error('projectName')
                                <div
                                    class="flex items-start space-x-2 mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                    <svg class="w-4 h-4 text-red-500 dark:text-red-400 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Project Description -->
                            <div class="space-y-2">
                                <label for="projectDescription"
                                    class="block text-sm font-semibold text-slate-900 dark:text-white">
                                    Description
                                    <span class="text-slate-500 dark:text-slate-400 font-normal">(Optionnel)</span>
                                </label>
                                <textarea id="projectDescription" wire:model="projectDescription" rows="4"
                                    class="w-full px-4 py-4 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 resize-none"
                                    placeholder="Décrivez les objectifs et buts de votre projet..."></textarea>
                                @error('projectDescription')
                                <div
                                    class="flex items-start space-x-2 mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                    <svg class="w-4 h-4 text-red-500 dark:text-red-400 mt-0.5 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-xl font-semibold transition-all duration-200 hover:shadow-xl hover:scale-105 transform">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Sauvegarder les Modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Team Management Card -->
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Membres de l'Équipe
                                </h2>
                            </div>
                            <div
                                class="flex items-center space-x-2 px-3 py-1.5 bg-slate-100 dark:bg-slate-700 rounded-lg">
                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-300">{{ count($members) }}
                                    membres</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <!-- Add Member Section -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-3">
                                Ajouter un Membre à l'Équipe
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" wire:model.live="searchMember" wire:focus="showSearchResults = true"
                                    class="w-full pl-12 pr-4 py-4 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 focus:border-transparent transition-all duration-200"
                                    placeholder="Rechercher par nom ou email...">
                            </div>
                            @error('newMemberEmail')
                            <div
                                class="flex items-start space-x-2 mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                <svg class="w-4 h-4 text-red-500 dark:text-red-400 mt-0.5 flex-shrink-0"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</span>
                            </div>
                            @enderror

                            <!-- Enhanced Search Results -->
                            @if($showSearchResults && !empty($searchMember))
                            <div
                                class="absolute z-20 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-2xl max-h-80 overflow-auto custom-scrollbar">
                                @if(count($searchResults) > 0)
                                @foreach($searchResults as $user)
                                <div
                                    class="flex items-center justify-between p-4 hover:bg-slate-50 dark:hover:bg-slate-700 border-b border-slate-100 dark:border-slate-600 last:border-b-0 transition-all duration-200 group">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-xl flex items-center justify-center shadow-md">
                                                <span
                                                    class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-slate-800">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}
                                            </div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="addMemberToProject({{ $user->id }})"
                                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-105 transform group-hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Ajouter
                                    </button>
                                </div>
                                @endforeach
                                @else
                                <div class="p-8 text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Aucun Résultat
                                        Trouvé</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Aucun utilisateur ne
                                        correspond à
                                        "{{ $searchMember }}"</p>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Current Members List -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Membres Actuels</h3>
                            @if(count($members) > 0)
                            <div class="space-y-3">
                                @foreach($members as $member)
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-200 dark:border-slate-600 hover:shadow-md transition-all duration-200 group">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                                                <span
                                                    class="text-white font-bold text-lg">{{ substr($member->name, 0, 1) }}</span>
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-slate-800">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-900 dark:text-white">
                                                {{ $member->name }}
                                            </div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $member->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="removeMember({{ $member->id }})"
                                        onclick="return confirm('Retirer {{ $member->name }} de ce projet ?')"
                                        class="inline-flex items-center px-3 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg text-sm font-semibold transition-all duration-200 opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Retirer
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div
                                class="text-center py-12 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600">
                                <div
                                    class="w-20 h-20 mx-auto mb-4 bg-slate-200 dark:bg-slate-700 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-400 dark:text-slate-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Aucun Membre
                                    d'Équipe pour le Moment</h4>
                                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Commencez à constituer
                                    votre équipe
                                    en recherchant et en ajoutant des membres pour collaborer sur ce projet.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Quick Stats Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Statistiques du Projet</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Membres</span>
                            <span class="font-semibold text-slate-900 dark:text-white">{{ count($members) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Créé le</span>
                            <span
                                class="font-semibold text-slate-900 dark:text-white">{{ $project->created_at->format('j M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Dernière Mise à Jour</span>
                            <span
                                class="font-semibold text-slate-900 dark:text-white">{{ $project->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-blue-900 dark:text-blue-100">Conseils Pro</h3>
                    </div>
                    <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-2">
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-500">•</span>
                            <span>Utilisez des noms de projet descriptifs pour une meilleure organisation</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-500">•</span>
                            <span>Ajoutez les membres de l'équipe tôt pour améliorer la collaboration</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <span class="text-blue-500">•</span>
                            <span>Gardez la description de votre projet à jour</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>