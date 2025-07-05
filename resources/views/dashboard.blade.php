<x-layouts.app :title="__('Dashboard')">
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

            <!-- Refined Header -->
            <header class="mb-12">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-blue-500/25 dark:shadow-blue-500/10">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                                </svg>
                            </div>
                            <div
                                class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white dark:border-slate-900 flex items-center justify-center">
                                <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        <div>
                            <h1
                                class="text-4xl font-black text-slate-900 dark:text-white tracking-tight bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                                Bienvenue {{ auth()->user()->name }}!
                            </h1>
                            <div class="flex items-center space-x-4 mt-2">
                                <p class="text-slate-600 dark:text-slate-400 font-medium">
                                    {{ now()->locale('fr')->translatedFormat('l, j F Y') }}
                                </p>
                                <div class="w-1.5 h-1.5 bg-slate-300 dark:bg-slate-600 rounded-full"></div>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">
                                    {{ now()->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Stats Cards -->
                    <div class="flex items-center space-x-4">
                        <div
                            class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 px-6 py-4 hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-slate-900/25 transition-all duration-300">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-3 h-3 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full shadow-lg shadow-green-500/30">
                                    <div class="w-full h-full bg-green-400 rounded-full animate-ping opacity-60"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">En ligne</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Actif maintenant</p>
                                </div>
                            </div>
                        </div>

                        @if(auth()->check() && auth()->user()->projects)
                        <div
                            class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 dark:border-slate-700/60 px-6 py-4 hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-slate-900/25 transition-all duration-300">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <span
                                        class="text-white font-bold text-lg">{{ auth()->user()->projects->count() }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Projets</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ auth()->user()->projects->count() === 1 ? 'Espace de travail' : 'Espaces de travail' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Refined Projects Section -->
            <section>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-emerald-500 via-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/25">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Mes Projets</h2>
                            <p class="text-slate-600 dark:text-slate-400 font-medium">Gérez vos espaces de travail
                                collaboratifs</p>
                        </div>
                    </div>

                    @if(auth()->check() && auth()->user()->projects->count() > 0)
                    <button wire:click="$dispatch('openCreateProjectModal')"
                        class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-semibold shadow-xl shadow-blue-500/25 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/30 transform">
                        <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouveau Projet
                    </button>
                    @endif
                </div>

                @if(auth()->check() && auth()->user()->projects->count() > 0)
                <div class="grid grid-cols-3 sm:grid-cols-2 gap-8">
                    @foreach(auth()->user()->projects as $project)
                    @php
                    $colors = [
                    'A' => ['from-red-500', 'to-pink-600', 'shadow-red-500/25'],
                    'B' => ['from-blue-500', 'to-cyan-600', 'shadow-blue-500/25'],
                    'C' => ['from-green-500', 'to-emerald-600', 'shadow-green-500/25'],
                    'D' => ['from-purple-500', 'to-indigo-600', 'shadow-purple-500/25'],
                    'E' => ['from-yellow-500', 'to-orange-600', 'shadow-yellow-500/25'],
                    'F' => ['from-pink-500', 'to-rose-600', 'shadow-pink-500/25'],
                    'G' => ['from-teal-500', 'to-cyan-600', 'shadow-teal-500/25'],
                    'H' => ['from-indigo-500', 'to-purple-600', 'shadow-indigo-500/25'],
                    'I' => ['from-orange-500', 'to-red-600', 'shadow-orange-500/25'],
                    'J' => ['from-emerald-500', 'to-teal-600', 'shadow-emerald-500/25'],
                    'K' => ['from-violet-500', 'to-purple-600', 'shadow-violet-500/25'],
                    'L' => ['from-lime-500', 'to-green-600', 'shadow-lime-500/25'],
                    'M' => ['from-fuchsia-500', 'to-pink-600', 'shadow-fuchsia-500/25'],
                    'N' => ['from-sky-500', 'to-blue-600', 'shadow-sky-500/25'],
                    'O' => ['from-amber-500', 'to-orange-600', 'shadow-amber-500/25'],
                    'P' => ['from-rose-500', 'to-pink-600', 'shadow-rose-500/25'],
                    'Q' => ['from-cyan-500', 'to-teal-600', 'shadow-cyan-500/25'],
                    'R' => ['from-red-600', 'to-rose-700', 'shadow-red-500/25'],
                    'S' => ['from-blue-600', 'to-indigo-700', 'shadow-blue-500/25'],
                    'T' => ['from-green-600', 'to-emerald-700', 'shadow-green-500/25'],
                    'U' => ['from-purple-600', 'to-violet-700', 'shadow-purple-500/25'],
                    'V' => ['from-yellow-600', 'to-amber-700', 'shadow-yellow-500/25'],
                    'W' => ['from-pink-600', 'to-fuchsia-700', 'shadow-pink-500/25'],
                    'X' => ['from-teal-600', 'to-cyan-700', 'shadow-teal-500/25'],
                    'Y' => ['from-orange-600', 'to-red-700', 'shadow-orange-500/25'],
                    'Z' => ['from-indigo-600', 'to-purple-700', 'shadow-indigo-500/25']
                    ];
                    $firstLetter = strtoupper(substr($project->name, 0, 1));
                    $colorData = $colors[$firstLetter] ?? ['from-slate-500', 'to-slate-600', 'shadow-slate-500/25'];
                    @endphp

                    <div class="group relative bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2 hover:bg-white/90 dark:hover:bg-slate-800/90"
                        x-data="{ open: false }">

                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-blue-50/30 dark:to-blue-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <!-- Project Content -->
                        <div class="relative p-8">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br {{ $colorData[0] }} {{ $colorData[1] }} rounded-2xl flex items-center justify-center shadow-xl {{ $colorData[2] }} group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                            <span class="text-white font-black text-2xl">{{ $firstLetter }}</span>
                                        </div>
                                        @if(auth()->user()->id === $project->owner_id)
                                        <div
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full border-3 border-white dark:border-slate-800 flex items-center justify-center shadow-lg">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="font-black text-xl text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors truncate mb-1">
                                            {{ $project->name }}
                                        </h3>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                                                {{ $project->created_at->diffForHumans() }}
                                            </span>
                                            @if(auth()->user()->id === $project->owner_id)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/40 dark:to-indigo-900/40 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold border border-blue-200 dark:border-blue-700">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Owner
                                            </span>
                                            @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/40 dark:to-emerald-900/40 text-green-700 dark:text-green-300 rounded-full text-xs font-bold border border-green-200 dark:border-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Member
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Project Description -->
                            <div class="mb-8">
                                <p
                                    class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-3 min-h-[72px]">
                                    {{ $project->description ?: 'Pas de description' }}
                                </p>
                            </div>

                            <!-- Enhanced Project Actions -->
                            <div class="flex space-x-3">
                                <a href="{{ route('project.board', $project->id) }}"
                                    class="flex-1 group inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-bold shadow-xl shadow-blue-500/25 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/40 transform">
                                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7v4m0 0h-4" />
                                    </svg>
                                    <span class="text-lg font-semibold">Ouvrir le tableau</span>
                                </a>
                                @if(auth()->user()->id === $project->owner_id)
                                <a href="{{ route('project.settings', $project->id) }}"
                                    class="group inline-flex items-center justify-center px-4 py-4 bg-slate-100/80 dark:bg-slate-700/80 hover:bg-slate-200/80 dark:hover:bg-slate-600/80 text-slate-700 dark:text-slate-300 rounded-2xl backdrop-blur-sm transition-all duration-300 hover:scale-105">
                                    <svg class="w-5 h-5 group-hover:rotate-45 transition-transform duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <!-- Premium Empty State -->
                <div
                    class="relative bg-gradient-to-br from-white/80 via-blue-50/50 to-indigo-50/30 dark:from-slate-800/80 dark:via-slate-800/60 dark:to-slate-700/40 backdrop-blur-sm rounded-3xl border-2 border-dashed border-slate-300/60 dark:border-slate-600/60 overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5 dark:opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" />
                                </pattern>
                            </defs>
                            <rect width="100" height="100" fill="url(#grid)" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="relative p-20 text-center">
                        <div
                            class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-blue-500/25 transform rotate-3">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3
                            class="text-4xl font-black text-slate-900 dark:text-white mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Pret à commencer ?
                        </h3>
                        <p class="text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                            Transformez vos idées en réalité. Créez votre premier projet et commencez à collaborer avec
                            votre équipe dans un espace de travail beau et organisé.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('projects.manage') }}"
                                class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 text-white rounded-2xl font-black text-lg shadow-2xl shadow-blue-500/25 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/40 transform">
                                <svg class="w-6 h-6 mr-4 group-hover:rotate-90 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Créez votre premier projet
                            </a>
                            <a href="#"
                                class="inline-flex items-center px-6 py-3 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 font-semibold transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                En savoir plus
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.app>