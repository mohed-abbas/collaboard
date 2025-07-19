<section class="w-full min-h-screen p-8 bg-slate-50 dark:bg-slate-900">
    @include('partials.settings-heading')

    <div class="max-w mx-auto">
        <!-- Settings Navigation Tabs -->
        <div class="mb-8">
            <nav class="flex space-x-8 border-b border-slate-200 dark:border-slate-700">
                <a href="{{ route('settings.profile') }}"
                    class="border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 py-4 px-1 text-sm font-medium transition-colors">
                    Profil
                </a>
                <a href="{{ route('settings.password') }}"
                    class="border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 py-4 px-1 text-sm font-medium transition-colors">
                    Sécurité
                </a>
                <a href="{{ route('settings.appearance') }}"
                    class="border-b-2 border-[#4586FF] dark:border-[#99BDFF] text-[#4586FF] dark:text-[#99BDFF] py-4 px-1 text-sm font-medium">
                    Apparence
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2
                class="text-2xl lg:text-3xl font-black mb-3 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                Apparence
            </h2>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                Personnalisez l'apparence de Collaboard selon vos préférences. Votre choix sera sauvegardé
                automatiquement.
            </p>
        </div>

        <!-- Theme Selection Card -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-slate-200/60 dark:shadow-slate-900/40 mb-8">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#4586FF] dark:text-[#99BDFF]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                    </svg>
                    Thème d'affichage
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Choisissez le thème qui vous convient le mieux pour votre expérience Collaboard.
                </p>
            </div>

            <!-- Theme Options -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" x-data>
                <!-- Light Theme -->
                <div @click="$flux.appearance = 'light'"
                    :class="$flux.appearance === 'light' ? 'ring-2 ring-[#4586FF] dark:ring-[#99BDFF] ring-offset-2 ring-offset-white dark:ring-offset-slate-800' : ''"
                    class="group relative cursor-pointer rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 transition-all duration-300 hover:border-[#4586FF] dark:hover:border-[#99BDFF] hover:shadow-lg hover:shadow-blue-500/10 dark:hover:shadow-blue-400/10">

                    <!-- Theme Preview -->
                    <div
                        class="mb-4 aspect-video rounded-xl bg-gradient-to-br from-slate-50 to-blue-50 border border-slate-200 overflow-hidden relative">
                        <!-- Mock Interface -->
                        <div class="absolute inset-2">
                            <!-- Header -->
                            <div class="h-8 bg-white rounded-t-lg border-b border-slate-200 flex items-center px-3">
                                <div class="w-4 h-4 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] rounded-sm"></div>
                                <div class="ml-2 h-2 bg-slate-300 rounded w-16"></div>
                            </div>
                            <!-- Content -->
                            <div class="bg-white rounded-b-lg p-3 space-y-2">
                                <div class="h-2 bg-slate-200 rounded w-3/4"></div>
                                <div class="h-2 bg-slate-100 rounded w-1/2"></div>
                                <div class="grid grid-cols-3 gap-1 mt-2">
                                    <div class="h-6 bg-blue-100 rounded"></div>
                                    <div class="h-6 bg-slate-100 rounded"></div>
                                    <div class="h-6 bg-green-100 rounded"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Selection Indicator -->
                        <div x-show="$flux.appearance === 'light'"
                            class="absolute top-2 right-2 w-6 h-6 bg-[#4586FF] rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Theme Info -->
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h4 class="ml-2 font-bold text-slate-900 dark:text-white">Clair</h4>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Interface lumineuse et épurée, idéale pour le travail en journée
                        </p>
                    </div>
                </div>

                <!-- Dark Theme -->
                <div @click="$flux.appearance = 'dark'"
                    :class="$flux.appearance === 'dark' ? 'ring-2 ring-[#4586FF] dark:ring-[#99BDFF] ring-offset-2 ring-offset-white dark:ring-offset-slate-800' : ''"
                    class="group relative cursor-pointer rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 transition-all duration-300 hover:border-[#4586FF] dark:hover:border-[#99BDFF] hover:shadow-lg hover:shadow-blue-500/10 dark:hover:shadow-blue-400/10">

                    <!-- Theme Preview -->
                    <div
                        class="mb-4 aspect-video rounded-xl bg-gradient-to-br from-slate-900 to-slate-800 border border-slate-700 overflow-hidden relative">
                        <!-- Mock Interface -->
                        <div class="absolute inset-2">
                            <!-- Header -->
                            <div class="h-8 bg-slate-800 rounded-t-lg border-b border-slate-700 flex items-center px-3">
                                <div class="w-4 h-4 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] rounded-sm"></div>
                                <div class="ml-2 h-2 bg-slate-600 rounded w-16"></div>
                            </div>
                            <!-- Content -->
                            <div class="bg-slate-800 rounded-b-lg p-3 space-y-2">
                                <div class="h-2 bg-slate-600 rounded w-3/4"></div>
                                <div class="h-2 bg-slate-700 rounded w-1/2"></div>
                                <div class="grid grid-cols-3 gap-1 mt-2">
                                    <div class="h-6 bg-blue-900 rounded"></div>
                                    <div class="h-6 bg-slate-700 rounded"></div>
                                    <div class="h-6 bg-green-900 rounded"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Selection Indicator -->
                        <div x-show="$flux.appearance === 'dark'"
                            class="absolute top-2 right-2 w-6 h-6 bg-[#99BDFF] rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Theme Info -->
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <h4 class="ml-2 font-bold text-slate-900 dark:text-white">Sombre</h4>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            Interface sombre et élégante, parfaite pour les sessions nocturnes
                        </p>
                    </div>
                </div>

                <!-- System Theme -->
                <div @click="$flux.appearance = 'system'"
                    :class="$flux.appearance === 'system' ? 'ring-2 ring-[#4586FF] dark:ring-[#99BDFF] ring-offset-2 ring-offset-white dark:ring-offset-slate-800' : ''"
                    class="group relative cursor-pointer rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 transition-all duration-300 hover:border-[#4586FF] dark:hover:border-[#99BDFF] hover:shadow-lg hover:shadow-blue-500/10 dark:hover:shadow-blue-400/10">

                    <!-- Theme Preview -->
                    <div
                        class="mb-4 aspect-video rounded-xl bg-gradient-to-r from-slate-100 via-slate-200 to-slate-800 border border-slate-300 dark:border-slate-600 overflow-hidden relative">
                        <!-- Mock Interface - Split -->
                        <div class="absolute inset-2 flex">
                            <!-- Light Side -->
                            <div class="flex-1 mr-0.5">
                                <div
                                    class="h-8 bg-white rounded-tl-lg border-b border-r border-slate-200 flex items-center px-2">
                                    <div class="w-3 h-3 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] rounded-sm"></div>
                                </div>
                                <div class="bg-white rounded-bl-lg p-2 space-y-1">
                                    <div class="h-1.5 bg-slate-200 rounded w-full"></div>
                                    <div class="h-1.5 bg-slate-100 rounded w-2/3"></div>
                                    <div class="h-4 bg-blue-100 rounded mt-1"></div>
                                </div>
                            </div>
                            <!-- Dark Side -->
                            <div class="flex-1 ml-0.5">
                                <div
                                    class="h-8 bg-slate-800 rounded-tr-lg border-b border-l border-slate-700 flex items-center px-2">
                                    <div class="w-3 h-3 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] rounded-sm"></div>
                                </div>
                                <div class="bg-slate-800 rounded-br-lg p-2 space-y-1">
                                    <div class="h-1.5 bg-slate-600 rounded w-full"></div>
                                    <div class="h-1.5 bg-slate-700 rounded w-2/3"></div>
                                    <div class="h-4 bg-blue-900 rounded mt-1"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Selection Indicator -->
                        <div x-show="$flux.appearance === 'system'"
                            class="absolute top-2 right-2 w-6 h-6 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Theme Info -->
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h4 class="ml-2 font-bold text-slate-900 dark:text-white">Système</h4>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            S'adapte automatiquement aux préférences de votre appareil
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Settings -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-slate-200/60 dark:shadow-slate-900/40">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#4586FF] dark:text-[#99BDFF]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Préférences avancées
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Options supplémentaires pour personnaliser votre expérience.
                </p>
            </div>

            <div class="space-y-6">
                <!-- Reduced Motion -->
                <div
                    class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Animations réduites</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                Réduire les animations et transitions pour améliorer les performances
                            </p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#4586FF]/50 dark:peer-focus:ring-[#99BDFF]/50 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4586FF] dark:peer-checked:bg-[#99BDFF]">
                        </div>
                    </label>
                </div>

                <!-- High Contrast -->
                <div
                    class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Contraste élevé</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                Augmenter le contraste pour améliorer la lisibilité
                            </p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#4586FF]/50 dark:peer-focus:ring-[#99BDFF]/50 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4586FF] dark:peer-checked:bg-[#99BDFF]">
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save Info -->
        <div
            class="mt-6 flex items-center justify-center p-4 bg-gradient-to-r from-[#4586FF]/10 to-[#99BDFF]/10 dark:from-[#4586FF]/20 dark:to-[#99BDFF]/20 rounded-xl border border-[#4586FF]/20 dark:border-[#99BDFF]/30">
            <svg class="w-5 h-5 text-[#4586FF] dark:text-[#99BDFF] mr-2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm text-[#4586FF] dark:text-[#99BDFF] font-medium">
                Vos préférences sont sauvegardées automatiquement
            </span>
        </div>
    </div>
</section>