<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Collaboard - Plateforme de collaboration moderne</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />

    <!-- Theme handled by Flux -->

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    class="bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 text-slate-900 dark:text-white antialiased transition-colors duration-300"
    x-data>

    <!-- Navigation -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-700/60">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                    </div>
                    <span
                        class="text-xl font-black bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent">
                        Collaboard
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features"
                        class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                        Fonctionnalités
                    </a>
                    <a href="#pricing"
                        class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                        Tarifs
                    </a>
                    <a href="#about"
                        class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                        À propos
                    </a>
                </div>

                <!-- Right Side: Theme Toggle + Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle Button -->
                    <button @click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'"
                        class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-300 border border-slate-200 dark:border-slate-700"
                        :aria-label="$flux.appearance === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'">
                        <!-- Sun Icon (Light Mode) -->
                        <svg x-show="$flux.appearance === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon (Dark Mode) -->
                        <svg x-show="$flux.appearance !== 'dark'" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Auth Buttons -->
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/30 dark:hover:shadow-blue-400/25 transform">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium transition-colors">
                                Se connecter
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/30 dark:hover:shadow-blue-400/25 transform">
                                    Inscrivez-vous
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 -z-10">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-[#4586FF]/20 to-[#99BDFF]/20 dark:from-[#4586FF]/10 dark:to-[#99BDFF]/10 rounded-full blur-3xl">
            </div>
            <div
                class="absolute top-1/4 right-1/4 w-64 h-64 bg-gradient-to-r from-[#4586FF]/15 to-[#99BDFF]/15 dark:from-[#4586FF]/8 dark:to-[#99BDFF]/8 rounded-full blur-2xl">
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h1 class="text-5xl lg:text-7xl font-black mb-6 leading-tight">
                    <span
                        class="bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent">
                        Collaboration
                    </span>
                    <br>
                    <span class="bg-gradient-to-r from-[#4586FF] to-[#99BDFF] bg-clip-text text-transparent">
                        simplifiée
                    </span>
                </h1>
                <p
                    class="text-xl lg:text-2xl text-slate-600 dark:text-slate-400 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Transformez vos idées en réalité avec notre plateforme de gestion de projets moderne.
                    Organisez, collaborez et livrez vos projets plus efficacement que jamais.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-2xl font-bold text-lg shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform">
                            <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            Accéder au tableau de bord
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-2xl font-bold text-lg shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform">
                            <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            Inscrivez-vous gratuitement
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-6 py-3 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-semibold border border-slate-200 dark:border-slate-700 transition-all duration-300 hover:scale-105 hover:shadow-lg dark:hover:shadow-slate-900/20">
                            Se connecter
                        </a>
                    @endauth
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl font-black text-[#4586FF] mb-2">10k+</div>
                        <div class="text-slate-600 dark:text-slate-400 font-medium">Projets créés</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-purple-600 dark:text-purple-400 mb-2">50k+</div>
                        <div class="text-slate-600 dark:text-slate-400 font-medium">Tâches gérées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-[#99BDFF] mb-2">99%</div>
                        <div class="text-slate-600 dark:text-slate-400 font-medium">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2
                    class="text-4xl lg:text-5xl font-black mb-6 bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent">
                    Fonctionnalités puissantes
                </h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Tout ce dont vous avez besoin pour gérer vos projets efficacement
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold mb-4 text-slate-900 dark:text-white group-hover:text-[#4586FF] transition-colors">
                        Tableaux Kanban
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Organisez vos tâches avec des tableaux Kanban intuitifs. Créez des catégories personnalisées et
                        suivez l'avancement en temps réel.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 dark:from-emerald-400 dark:to-teal-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/25 dark:shadow-emerald-400/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold mb-4 text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        Étiquettes colorées
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Catégorisez vos tâches avec des étiquettes colorées. Filtrez et organisez votre travail par
                        type, priorité ou équipe.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 dark:from-purple-400 dark:to-indigo-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/25 dark:shadow-purple-400/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold mb-4 text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                        Collaboration d'équipe
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Travaillez ensemble efficacement. Assignez des tâches, partagez des commentaires et restez
                        synchronisés.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 dark:from-orange-400 dark:to-red-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/25 dark:shadow-orange-400/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold mb-4 text-slate-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                        Niveaux de priorité
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Identifiez rapidement les tâches critiques avec notre système de priorités. Optimisez votre flux
                        de travail.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 dark:from-pink-400 dark:to-rose-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-pink-500/25 dark:shadow-pink-400/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold mb-4 text-slate-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">
                        Suivi en temps réel
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Surveillez les progrès de vos projets avec des tableaux de bord intuitifs et des rapports
                        détaillés.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:shadow-slate-900/40 transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 dark:from-teal-400 dark:to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-teal-500/25 dark:shadow-teal-400/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.94 1.543-.826 3.31 2.37 2.37a1.724 1.724 0 002.572 1.065c.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3
                        class="text-xl font-bold mb-4 text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                        Configuration flexible
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        Personnalisez Collaboard selon vos besoins. Adaptez l'interface et les workflows à votre équipe.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section
        class="py-20 px-6 lg:px-8 bg-gradient-to-br from-blue-50/50 to-indigo-50/30 dark:from-slate-800/50 dark:to-slate-700/30">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2
                    class="text-4xl lg:text-5xl font-black mb-6 bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent">
                    Voyez Collaboard en action
                </h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Interface moderne et intuitive pour une productivité maximale
                </p>
            </div>

            <!-- Demo Card -->
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-8 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl dark:shadow-slate-900/40">
                <div
                    class="aspect-video bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-2xl flex items-center justify-center relative overflow-hidden">
                    <!-- Mock Dashboard -->
                    <div
                        class="absolute inset-4 bg-white dark:bg-slate-800 rounded-xl shadow-lg dark:shadow-slate-900/50">
                        <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-lg">
                                </div>
                                <div class="h-4 bg-slate-200 dark:bg-slate-600 rounded w-32"></div>
                            </div>
                        </div>
                        <div class="p-4 grid grid-cols-3 gap-4">
                            <div class="space-y-3">
                                <div class="h-3 bg-[#4586FF]/30 rounded"></div>
                                <div class="space-y-2">
                                    <div class="h-16 bg-[#4586FF]/10 rounded"></div>
                                    <div class="h-16 bg-[#4586FF]/10 rounded"></div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-3 bg-yellow-200 dark:bg-yellow-800 rounded"></div>
                                <div class="space-y-2">
                                    <div class="h-16 bg-yellow-100 dark:bg-yellow-900 rounded"></div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-3 bg-green-200 dark:bg-green-800 rounded"></div>
                                <div class="space-y-2">
                                    <div class="h-16 bg-green-100 dark:bg-green-900 rounded"></div>
                                    <div class="h-16 bg-green-100 dark:bg-green-900 rounded"></div>
                                    <div class="h-16 bg-green-100 dark:bg-green-900 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Play Button -->
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-slate-900/20 dark:bg-slate-100/10 backdrop-blur-sm opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <button
                            class="w-16 h-16 bg-white/90 dark:bg-slate-800/90 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-slate-900 dark:text-white ml-1" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2
                class="text-4xl lg:text-5xl font-black mb-6 bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent">
                Prêt à transformer votre façon de travailler ?
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-400 mb-12 max-w-2xl mx-auto">
                Rejoignez des milliers d'équipes qui utilisent déjà Collaboard pour gérer leurs projets plus
                efficacement.
            </p>

            @auth
                <a href="{{ route('dashboard') }}"
                    class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-2xl font-black text-xl shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform">
                    <svg class="w-6 h-6 mr-4 group-hover:rotate-12 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Accéder au tableau de bord
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="group inline-flex items-center px-10 py-5 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-2xl font-black text-xl shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform">
                    <svg class="w-6 h-6 mr-4 group-hover:rotate-12 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Commencez Maintenant (gratuitement)
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 dark:bg-slate-950 text-white py-16 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Logo & Description -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-black">Collaboard</span>
                    </div>
                    <p class="text-slate-400 dark:text-slate-500 leading-relaxed max-w-md">
                        La plateforme de collaboration moderne qui transforme la façon dont les équipes travaillent
                        ensemble.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="font-semibold mb-4">Produit</h3>
                    <ul class="space-y-2 text-slate-400 dark:text-slate-500">
                        <li><a href="#"
                                class="hover:text-white dark:hover:text-slate-300 transition-colors">Fonctionnalités</a>
                        </li>
                        <li><a href="#" class="hover:text-white dark:hover:text-slate-300 transition-colors">Tarifs</a>
                        </li>
                        <li><a href="#"
                                class="hover:text-white dark:hover:text-slate-300 transition-colors">Sécurité</a></li>
                        <li><a href="#" class="hover:text-white dark:hover:text-slate-300 transition-colors">API</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-slate-400 dark:text-slate-500">
                        <li><a href="#"
                                class="hover:text-white dark:hover:text-slate-300 transition-colors">Documentation</a>
                        </li>
                        <li><a href="#" class="hover:text-white dark:hover:text-slate-300 transition-colors">Guides</a>
                        </li>
                        <li><a href="#" class="hover:text-white dark:hover:text-slate-300 transition-colors">Contact</a>
                        </li>
                        <li><a href="#" class="hover:text-white dark:hover:text-slate-300 transition-colors">Statut</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-slate-800 dark:border-slate-700 pt-8 flex flex-col md:flex-row items-center justify-between">
                <p class="text-slate-400 dark:text-slate-500 text-sm">
                    © {{ date('Y') }} Collaboard. Tous droits réservés.
                </p>
                <div class="flex items-center space-x-6 mt-4 md:mt-0">
                    <a href="#"
                        class="text-slate-400 dark:text-slate-500 hover:text-white dark:hover:text-slate-300 transition-colors">
                        Politique de confidentialité
                    </a>
                    <a href="#"
                        class="text-slate-400 dark:text-slate-500 hover:text-white dark:hover:text-slate-300 transition-colors">
                        CGU
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>