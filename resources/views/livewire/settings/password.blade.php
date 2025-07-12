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
                    class="border-b-2 border-[#4586FF] dark:border-[#99BDFF] text-[#4586FF] dark:text-[#99BDFF] py-4 px-1 text-sm font-medium">
                    Sécurité
                </a>
                <a href="{{ route('settings.appearance') }}"
                    class="border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 py-4 px-1 text-sm font-medium transition-colors">
                    Apparence
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2
                class="text-2xl lg:text-3xl font-black mb-3 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                Sécurité
            </h2>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
            </p>
        </div>

        <!-- Password Update Card -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-slate-200/60 dark:shadow-slate-900/40 mb-8">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#4586FF] dark:text-[#99BDFF]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Modifier le mot de passe
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Mettez à jour votre mot de passe pour renforcer la sécurité de votre compte.
                </p>
            </div>

            <form wire:submit="updatePassword" class="space-y-6">
                <!-- Current Password -->
                <div class="space-y-2">
                    <label for="current_password" class="block text-sm font-bold text-slate-900 dark:text-white">
                        Mot de passe actuel
                    </label>
                    <div class="relative group" x-data="{ showCurrentPassword: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="current_password" id="current_password"
                            :type="showCurrentPassword ? 'text' : 'password'" required autocomplete="current-password"
                            placeholder="Entrez votre mot de passe actuel"
                            class="w-full pl-10 pr-10 py-3 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500" />
                        <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors">
                            <svg x-show="!showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold text-slate-900 dark:text-white">
                        Nouveau mot de passe
                    </label>
                    <div class="relative group" x-data="{ showNewPassword: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <input wire:model="password" id="password" :type="showNewPassword ? 'text' : 'password'"
                            required autocomplete="new-password" placeholder="Créez un nouveau mot de passe sécurisé"
                            class="w-full pl-10 pr-10 py-3 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500" />
                        <button type="button" @click="showNewPassword = !showNewPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors">
                            <svg x-show="!showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-900 dark:text-white">
                        Confirmer le nouveau mot de passe
                    </label>
                    <div class="relative group" x-data="{ showConfirmPassword: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 group-focus-within:text-[#4586FF] dark:group-focus-within:text-[#99BDFF] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input wire:model="password_confirmation" id="password_confirmation"
                            :type="showConfirmPassword ? 'text' : 'password'" required autocomplete="new-password"
                            placeholder="Confirmez votre nouveau mot de passe"
                            class="w-full pl-10 pr-10 py-3 bg-white dark:bg-slate-700 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-[#4586FF]/50 focus:border-[#4586FF] dark:focus:ring-[#99BDFF]/50 dark:focus:border-[#99BDFF] transition-all duration-300 hover:border-slate-300 dark:hover:border-slate-500" />
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors">
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Strength Info -->
                <div
                    class="p-4 bg-gradient-to-r from-[#4586FF]/10 to-[#99BDFF]/10 dark:from-[#4586FF]/20 dark:to-[#99BDFF]/20 rounded-xl border border-[#4586FF]/20 dark:border-[#99BDFF]/30">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-[#4586FF] dark:text-[#99BDFF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm text-[#4586FF] dark:text-[#99BDFF] leading-relaxed">
                            <strong class="font-semibold">Conseils pour un mot de passe sécurisé :</strong>
                            <ul class="mt-2 space-y-1 text-xs">
                                <li>• Au moins 8 caractères</li>
                                <li>• Mélangez majuscules, minuscules, chiffres et symboles</li>
                                <li>• Évitez les informations personnelles</li>
                                <li>• Utilisez une phrase de passe unique</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                    <x-action-message on="password-updated" class="text-green-600 dark:text-green-400">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm font-medium">Mot de passe mis à jour avec succès</span>
                        </div>
                    </x-action-message>

                    <button type="submit"
                        class="px-6 py-3 bg-slate-900 hover:bg-slate-700 text-white rounded transform disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none focus:outline-none focus:ring-2 focus:ring-[#4586FF]/50 focus:ring-offset-2">
                        Mettre à jour le mot de passe
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Tips -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-slate-200/60 dark:shadow-slate-900/40">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#4586FF] dark:text-[#99BDFF]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.05-5.707A2 2 0 0022 3m-4.806 9.05a2 2 0 00-1.414 1.414L15 14l1.05-1.05a2 2 0 011.414-1.414L20 10l-1.05 1.05z" />
                    </svg>
                    Conseils de sécurité
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Bonnes pratiques pour protéger votre compte Collaboard.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Security Tip 1 -->
                <div
                    class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Gestionnaire de mots de
                                passe</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                Utilisez un gestionnaire pour générer et stocker des mots de passe uniques
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Tip 2 -->
                <div
                    class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Authentification à deux
                                facteurs</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                Activez la 2FA pour une sécurité renforcée (disponible prochainement)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Tip 3 -->
                <div
                    class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Changement régulier</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                Changez votre mot de passe tous les 3-6 mois ou si vous suspectez une compromission
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Tip 4 -->
                <div
                    class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600/50">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Évitez la réutilisation
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                N'utilisez jamais le même mot de passe sur plusieurs sites ou services
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>