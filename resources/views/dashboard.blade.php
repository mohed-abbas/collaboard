<x-layouts.app :title="__('Dashboard')">
    <div class="min-h-screen bg-gradient-to-br">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <header class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">Tableau de bord</h1>
                    </div>
                    <!-- MODIFICATION: Bouton "Nouveau Projet" supprimé du header -->
                </div>
            </header>

            <section class="mb-10">
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center">
                        <h2 class="text-2xl font-semibold text-gray-800">Mes Projets</h2>
                        <!-- MODIFICATION: Ajout d'un compteur de projets avec badge -->
                        @if(auth()->check() && auth()->user()->projects)
                            <span class="ml-4 px-4 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                {{ auth()->user()->projects->count() }}
                            </span>
                        @endif
                    </div>
                </div>

                @if(auth()->check() && auth()->user()->projects->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach(auth()->user()->projects as $project)
                            <div
                                class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden transform hover:-translate-y-1">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3
                                            class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ $project->name }}
                                        </h3>
                                        <!-- MODIFICATION: Menu dropdown avec options de gestion du projet -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.outside="open = false"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                                <div class="py-1">
                                                    <!-- MODIFICATION: Lien vers la gestion des projets pour modifier -->
                                                    <a href="{{ route('project.settings', $project->id) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        Gérer le projet
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- MODIFICATION: Affichage de la description du projet avec fallback -->
                                    <p class="text-gray-600 mb-6 line-clamp-2 min-h-[48px]">
                                        {{ $project->description ?? 'Aucune description disponible' }}
                                    </p>
                                    <div class="pt-4 border-t border-gray-100">
                                        <!-- MODIFICATION: Bouton "Voir le tableau" qui redirige vers le board du projet -->
                                        <a href="{{ route('project.board', $project->id) }}"
                                            class="w-full py-2.5 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors duration-200 font-medium text-sm flex items-center justify-center">
                                            Voir le tableau
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- MODIFICATION: État vide amélioré avec design plus attractif -->
                    <div
                        class="flex flex-col items-center justify-center bg-white rounded-2xl shadow-sm border border-dashed border-gray-300 p-12">
                        <div class="bg-blue-50 p-4 rounded-full mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-3">Aucun projet pour le moment</h3>
                        <p class="text-gray-600 text-center mb-8 max-w-md">
                            Créez votre premier projet pour commencer à organiser vos tâches.
                        </p>
                        <!-- MODIFICATION: Bouton de création de projet repositionné dans l'état vide -->
                        <a href="{{ route('projects.manage') }}"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                            Créer mon premier projet
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.app> <!-- Ne touche pas cette ligne  -->