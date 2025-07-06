<div
    class="h-screen w-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 text-slate-900 dark:text-white antialiased transition-colors duration-300 flex overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 -z-10">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-blue-500/20 to-purple-500/20 dark:from-blue-400/10 dark:to-purple-400/10 rounded-full blur-3xl">
        </div>
        <div
            class="absolute top-1/4 right-1/4 w-64 h-64 bg-gradient-to-r from-indigo-500/15 to-cyan-500/15 dark:from-indigo-400/8 dark:to-cyan-400/8 rounded-full blur-2xl">
        </div>
        <div
            class="absolute bottom-1/4 left-1/4 w-48 h-48 bg-gradient-to-r from-purple-500/10 to-pink-500/10 dark:from-purple-400/5 dark:to-pink-400/5 rounded-full blur-xl">
        </div>
    </div>

    <!-- Left Side - Branding -->
    <div
        class="hidden lg:flex lg:w-2/5 flex-shrink-0 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 dark:from-blue-700 dark:via-purple-700 dark:to-indigo-800 relative overflow-hidden">
        <!-- Pattern Background -->
        <div class="absolute inset-0 opacity-10 dark:opacity-5">
            <div class="absolute top-0 left-0 w-full h-full"
                style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.2) 2px, transparent 2px); background-size: 40px 40px;">
            </div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center items-center w-full h-full px-6 xl:px-8 text-white">
            <!-- Logo -->
            <div class="mb-6 text-center">
                <div
                    class="w-16 h-16 bg-white/20 dark:bg-white/25 backdrop-blur-sm rounded-3xl flex items-center justify-center shadow-2xl mb-4 mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                    </svg>
                </div>
                <h1 class="text-3xl xl:text-4xl font-black mb-3">Collaboard</h1>
                <p class="text-lg text-blue-100 dark:text-blue-200 leading-relaxed">
                    Récupération de mot de passe sécurisée
                </p>
            </div>

            <!-- Security Features -->
            <div class="space-y-4 w-full max-w-sm">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-white/20 dark:bg-white/25 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm">Sécurité renforcée</h3>
                        <p class="text-blue-100 dark:text-blue-200 text-xs">Lien de réinitialisation crypté et
                            temporaire</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-white/20 dark:bg-white/25 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm">Email instantané</h3>
                        <p class="text-blue-100 dark:text-blue-200 text-xs">Recevez votre lien en quelques secondes</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-white/20 dark:bg-white/25 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm">Expiration automatique</h3>
                        <p class="text-blue-100 dark:text-blue-200 text-xs">Lien valide pendant 60 minutes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Forgot Password Form -->
    <div class="flex-1 lg:w-3/5 flex items-center justify-center p-4 lg:p-6 xl:p-8 overflow-y-auto">
        <div class="w-full max-w-lg">
            <!-- Mobile Logo (visible only on small screens) -->
            <div class="lg:hidden text-center mb-6">
                <div class="inline-flex items-center space-x-3 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-600 dark:from-blue-500 dark:via-purple-500 dark:to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20">
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
            </div>

            <!-- Header -->
            <div class="mb-6">
                <h1
                    class="text-2xl lg:text-3xl xl:text-4xl font-black mb-3 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                    Mot de passe oublié ?
                </h1>
                <p class="text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                    Pas de problème ! Entrez votre adresse e-mail et nous vous enverrons un lien de réinitialisation.
                </p>
            </div>

            <!-- Forgot Password Form -->
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-slate-200/60 dark:shadow-slate-900/40">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

                <form wire:submit="sendPasswordResetLink" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-slate-900 dark:text-white">
                            Adresse e-mail
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input wire:model="email" id="email" type="email" required autofocus autocomplete="email"
                                placeholder="votre@email.com"
                                class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 dark:focus:ring-blue-400/50 dark:focus:border-blue-400 transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500" />
                        </div>
                        @error('email')
                        <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div
                        class="flex items-start space-x-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800/50">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                            <strong class="font-semibold">Instructions :</strong> Vérifiez votre boîte de réception (et
                            vos spams) après avoir cliqué sur "Envoyer le lien". Le lien sera valide pendant 60 minutes.
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="group w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 dark:from-blue-500 dark:via-purple-500 dark:to-indigo-500 dark:hover:from-blue-600 dark:hover:via-purple-600 dark:hover:to-indigo-600 text-white rounded-xl font-bold text-lg shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-[1.02] hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        wire:loading.attr="disabled">
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <svg wire:loading.remove class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 7.89a2 2 0 002.83 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span wire:loading.remove>Envoyer le lien de réinitialisation</span>
                        <span wire:loading>Envoi en cours...</span>
                        <svg wire:loading.remove
                            class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="mt-4 space-y-3">
                <div class="text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Vous vous souvenez de votre mot de passe ?
                        <a href="{{ route('login') }}" wire:navigate
                            class="font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors ml-1">
                            Se connecter
                        </a>
                    </p>
                </div>

                <div class="text-center">
                    <a href="{{ route('home') }}" wire:navigate
                        class="inline-flex items-center text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>