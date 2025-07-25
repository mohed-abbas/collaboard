<x-layouts.app :title="__('Dashboard')">
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
        <!-- Top Navigation Bar -->
        <nav
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Left: Dashboard Title -->
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">Dashboard</h1>
                    </div>

                    <!-- Right: User Info -->
                    <div class="flex items-center space-x-4">
                        <!-- User Avatar -->
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-lg flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ now()->locale('fr')->translatedFormat('j M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @include('livewire.flash-messages')

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Section -->
            <section class="mb-8">
                <div
                    class="bg-gradient-to-r from-[#4586FF] to-[#99BDFF] rounded-2xl p-8 text-white relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold mb-2">
                                    Bonjour, {{ auth()->user()->name }} 👋
                                </h2>
                                <p class="text-blue-100 text-lg">
                                    Prêt à être productif aujourd'hui ?
                                </p>
                            </div>

                            @if(auth()->check() && auth()->user()->projects->count() > 0)
                                <button @click="$dispatch('open-create-project-modal')"
                                    class="group bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 px-6 py-3 rounded-xl text-white font-medium transition-all duration-200 hover:scale-105">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span>Nouveau projet</span>
                                    </div>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Cards -->
            @if(auth()->check() && auth()->user()->projects->count() > 0)
                <section class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total Projects -->
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total des projets</p>
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white">
                                        {{ auth()->user()->projects->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Owned Projects -->
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Projets créés</p>
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white">
                                        {{ auth()->user()->projects->where('owner_id', auth()->id())->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Member Projects -->
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Collaborations</p>
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white">
                                        {{ auth()->user()->projects->where('owner_id', '!=', auth()->id())->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Projects Section -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Vos projets</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Accédez rapidement à vos espaces de
                            travail</p>
                    </div>
                </div>

                @if(auth()->check() && auth()->user()->projects->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(auth()->user()->projects as $project)
                            @php
                                $colors = [
                                    'A' => "from-red-500 to-pink-600 shadow-red-500/25",
                                    'B' => "from-blue-500 to-cyan-600 shadow-blue-500/25",
                                    'C' => "from-green-500 to-emerald-600 shadow-green-500/25",
                                    'D' => "from-purple-500 to-indigo-600 shadow-purple-500/25",
                                    'E' => "from-yellow-500 to-orange-600 shadow-yellow-500/25",
                                    'F' => "from-pink-500 to-rose-600 shadow-pink-500/25",
                                    'G' => "from-teal-500 to-cyan-600 shadow-teal-500/25",
                                    'H' => "from-indigo-500 to-purple-600 shadow-indigo-500/25",
                                    'I' => "from-orange-500 to-red-600 shadow-orange-500/25",
                                    'J' => "from-emerald-500 to-teal-600 shadow-emerald-500/25",
                                    'K' => "from-violet-500 to-purple-600 shadow-violet-500/25",
                                    'L' => "from-lime-500 to-green-600 shadow-lime-500/25",
                                    'M' => "from-fuchsia-500 to-pink-600 shadow-fuchsia-500/25",
                                    'N' => "from-sky-500 to-blue-600 shadow-sky-500/25",
                                    'O' => "from-amber-500 to-orange-600 shadow-amber-500/25",
                                    'P' => "from-rose-500 to-pink-600 shadow-rose-500/25",
                                    'Q' => "from-cyan-500 to-teal-600 shadow-cyan-500/25",
                                    'R' => "from-red-600 to-rose-700 shadow-red-500/25",
                                    'S' => "from-blue-600 to-indigo-700 shadow-blue-500/25",
                                    'T' => "from-green-600 to-emerald-700 shadow-green-500/25",
                                    'U' => "from-purple-600 to-violet-700 shadow-purple-500/25",
                                    'V' => "from-yellow-600 to-amber-700 shadow-yellow-500/25",
                                    'W' => "from-pink-600 to-fuchsia-700 shadow-pink-500/25",
                                    'X' => "from-teal-600 to-cyan-700 shadow-teal-500/25",
                                    'Y' => "from-orange-600 to-red-700 shadow-orange-500/25",
                                    'Z' => "from-indigo-600 to-purple-700 shadow-indigo-500/25"
                                ];
                                $firstLetter = strtoupper(substr($project->name, 0, 1));
                                $colorScheme = $colors[$firstLetter] ?? ['from-gray-500', 'to-gray-600', 'shadow-gray-500/25'];
                            @endphp

                            <div
                                class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
                                <!-- Project Header -->
                                <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br {{ $colorScheme }} rounded-lg flex items-center justify-center">
                                                <span class="text-white font-bold">{{ $firstLetter }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-slate-900 dark:text-white transition-colors">
                                                    {{ $project->name }}
                                                </h4>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $project->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Role Badge -->
                                        @if(auth()->user()->id === $project->owner_id)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Admin
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full text-xs font-medium">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                Membre
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Project Content -->
                                <div class="p-6">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 mb-4">
                                        {{ $project->description ?: 'Aucune description disponible.' }}
                                    </p>

                                    <!-- Quick Actions -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('project.board', $project->id) }}"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7v4m0 0h-4" />
                                            </svg>
                                            Ouvrir
                                        </a>

                                        @if(auth()->user()->id === $project->owner_id)
                                            <a href="{{ route('project.settings', $project->id) }}"
                                                class="inline-flex items-center justify-center p-2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                            Aucun projet pour le moment
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                            Créez votre premier projet pour commencer à organiser votre travail et collaborer avec votre
                            équipe.
                        </p>
                        <button @click="$dispatch('open-create-project-modal')"
                            class="inline-flex items-center px-6 py-3 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Créer un projet
                        </button>
                    </div>
                @endif
            </section>
        </main>
    </div>

    <livewire:project-manager :hideProjectsList="true" />

</x-layouts.app>