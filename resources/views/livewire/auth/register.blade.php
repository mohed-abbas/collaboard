<div
    class="h-screen w-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 text-slate-900 dark:text-white antialiased transition-colors duration-300 flex overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 -z-10">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-[#4586FF]/20 to-[#99BDFF]/20 dark:from-[#4586FF]/10 dark:to-[#99BDFF]/10 rounded-full blur-3xl">
        </div>
        <div
            class="absolute top-1/4 right-1/4 w-64 h-64 bg-gradient-to-r from-[#4586FF]/15 to-[#99BDFF]/15 dark:from-[#4586FF]/8 dark:to-[#99BDFF]/8 rounded-full blur-2xl">
        </div>
        <div
            class="absolute bottom-1/4 left-1/4 w-48 h-48 bg-gradient-to-r from-[#4586FF]/10 to-[#99BDFF]/10 dark:from-[#4586FF]/5 dark:to-[#99BDFF]/5 rounded-full blur-xl">
        </div>
    </div>

    <!-- Right Side - Register Form -->
    <div class="flex-1 lg:w-1/2 xl:w-3/5 flex items-center justify-center p-3 lg:p-4 xl:p-6 overflow-y-auto">
        <div class="w-full max-w-lg">
            <!-- Mobile Logo (visible only on small screens) -->
            <div class="lg:hidden text-center mb-4">
                <div class="inline-flex items-center space-x-2 mb-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-[#4586FF] to-[#99BDFF] rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25 dark:shadow-blue-400/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                    </div>
                    <span
                        class="text-lg font-black bg-gradient-to-r from-slate-900 to-blue-900 dark:from-white dark:to-blue-100 bg-clip-text text-transparent">
                        Collaboard
                    </span>
                </div>
            </div>

            <!-- Header -->
            <div class="mb-4">
                <h1
                    class="text-xl lg:text-2xl xl:text-3xl font-black mb-2 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                    Créer un compte
                </h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Rejoignez Collaboard et commencez à collaborer avec votre équipe.
                </p>
            </div>

            <!-- Register Form -->
            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl p-4 lg:p-6 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-slate-200/60 dark:shadow-slate-900/40">
                <!-- Session Status -->
                <x-auth-session-status class="mb-3 text-center" :status="session('status')" />

                <form wire:submit="register" class="space-y-3">
                    <!-- Name -->
                    <div class="space-y-1">
                        <label for="name" class="block text-xs font-bold text-slate-900 dark:text-white">
                            Nom complet
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                                placeholder="Votre nom complet"
                                class="w-full pl-9 pr-3 py-2.5 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500 text-sm" />
                        </div>
                        @error('name')
                            <p class="text-xs text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1">
                        <label for="email" class="block text-xs font-bold text-slate-900 dark:text-white">
                            Adresse e-mail
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input wire:model="email" id="email" type="email" required autocomplete="email"
                                placeholder="votre@email.com"
                                class="w-full pl-9 pr-3 py-2.5 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500 text-sm" />
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label for="password" class="block text-xs font-bold text-slate-900 dark:text-white">
                            Mot de passe
                        </label>
                        <div class="relative group" x-data="{ showPassword: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input wire:model="password" id="password" :type="showPassword ? 'text' : 'password'"
                                required autocomplete="new-password" placeholder="Créez un mot de passe sécurisé"
                                class="w-full pl-9 pr-9 py-2.5 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500 text-sm" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1">
                        <label for="password_confirmation"
                            class="block text-xs font-bold text-slate-900 dark:text-white">
                            Confirmer le mot de passe
                        </label>
                        <div class="relative group" x-data="{ showConfirmPassword: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input wire:model="password_confirmation" id="password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'" required autocomplete="new-password"
                                placeholder="Confirmez votre mot de passe"
                                class="w-full pl-9 pr-9 py-2.5 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500 text-sm" />
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-xs text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="group w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-lg font-bold text-sm shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        wire:loading.attr="disabled">
                        <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove>Créer mon compte</span>
                        <span wire:loading>Création...</span>
                        <svg wire:loading.remove
                            class="w-4 h-4 ml-2 group-hover:rotate-12 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="mt-3 space-y-2">
                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" wire:navigate
                            class="font-bold text-[#4586FF] dark:text-[#99BDFF] hover:text-[#3d79f5] dark:hover:text-[#8eb2fc] transition-colors ml-1">
                            Se connecter
                        </a>
                    </p>
                </div>

                <!-- Back to home -->
                <div class="text-center">
                    <a href="{{ route('home') }}" wire:navigate
                        class="inline-flex items-center text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors text-xs">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Left Side - Branding -->
    <div
        class="hidden lg:flex lg:w-1/2 xl:w-2/5 bg-gradient-to-br from-[#4586FF] via-[#4d8aff] to-[#99BDFF] dark:from-[#3d79f5] dark:via-[#4586ff] dark:to-[#8eb2fc] relative overflow-hidden">
        <!-- Pattern Background -->
        <div class="absolute inset-0 opacity-10 dark:opacity-5">
            <div class="absolute top-0 left-0 w-full h-full"
                style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.2) 2px, transparent 2px); background-size: 40px 40px;">
            </div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center items-center w-full h-full px-6 xl:px-8 text-white">
            <!-- Logo -->
            <div class="mb-4 text-center">
                <div
                    class="w-12 h-12 bg-white/20 dark:bg-white/25 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-2xl mb-3 mx-auto">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z" />
                    </svg>
                </div>
                <h1 class="text-2xl xl:text-3xl font-black mb-2">Collaboard</h1>
                <p class="text-base text-blue-100 dark:text-blue-200 leading-relaxed">
                    Rejoignez des milliers d'équipes qui collaborent efficacement
                </p>
            </div>

            <!-- Benefits for Registration -->
            <div class="space-y-3 w-full max-w-sm">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-white/20 dark:bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-xs">Démarrage instantané</h3>
                        <p class="text-blue-100 dark:text-blue-200 text-xs">Créez votre premier projet en moins de 2
                            minutes</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-white/20 dark:bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-xs">Sécurité garantie</h3>
                        <p class="text-blue-100 dark:text-blue-200 text-xs">Vos données protégées</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-white/20 dark:bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-xs">Gratuit pour toujours</h3>
                        <p class="text-blue-100 dark:text-blue-200 text-xs">Accès complet aux fonctionnalités</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>