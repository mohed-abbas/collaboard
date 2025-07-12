<section class="w-full min-h-screen p-8 bg-slate-50 dark:bg-slate-900">
    @include('partials.settings-heading')

    <div class="max-w">
        <!-- Settings Navigation Tabs -->
        <div class="mb-8">
            <nav class="flex space-x-8 border-b border-slate-200 dark:border-slate-700">
                <a href="{{ route('settings.profile') }}"
                    class="border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 py-4 px-1 text-sm font-medium">
                    Profil
                </a>
                <a href="{{ route('settings.password') }}"
                    class="border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 py-4 px-1 text-sm font-medium transition-colors">
                    Sécurité
                </a>
                <a href="{{ route('settings.appearance') }}"
                    class="border-b-2 border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 py-4 px-1 text-sm font-medium transition-colors">
                    Apparence
                </a>
            </nav>
        </div>


        <!-- Profile Content -->
        <div class="space-y-8">
            <!-- Profile Information Card -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Informations personnelles
                    </h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                        Gérez vos informations de profil et votre adresse email
                    </p>
                </div>

                <div class="px-6 py-6">
                    <form wire:submit="updateProfileInformation" class="space-y-6">
                        <!-- Profile Picture Section -->
                        <div class="flex items-center space-x-6">
                            <div
                                class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
                                <span class="text-slate-600 dark:text-slate-300 font-semibold text-xl">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white">
                                    Photo de profil
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Votre avatar est généré automatiquement à partir de votre nom
                                </p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Nom complet
                                </label>
                                <input wire:model="name" type="text" id="name" required autofocus autocomplete="name"
                                    class="block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    Adresse email
                                </label>
                                <input wire:model="email" type="email" id="email" required autocomplete="email"
                                    class="block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>

                        <!-- Email Verification Status -->
                        <div class="flex items-center space-x-3">
                            @if (
                                    auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
                                    !auth()->user()->hasVerifiedEmail()
                                )
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                    <span class="text-sm text-yellow-600 dark:text-yellow-400">Email non vérifié</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-green-600 dark:text-green-400">Email vérifié</span>
                                </div>
                            @endif
                        </div>

                        <!-- Email Verification Notice -->
                        @if (
                                auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
                                !auth()->user()->hasVerifiedEmail()
                            )
                            <div
                                class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm text-yellow-800 dark:text-yellow-200 mb-2">
                                            Votre adresse email n'est pas vérifiée.
                                        </p>
                                        <button type="button" wire:click.prevent="resendVerificationNotification"
                                            class="text-sm text-yellow-600 dark:text-yellow-400 hover:text-yellow-500 dark:hover:text-yellow-300 underline">
                                            Renvoyer l'email de vérification
                                        </button>

                                        @if (session('status') === 'verification-link-sent')
                                            <div
                                                class="mt-2 p-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded">
                                                <p class="text-sm text-green-800 dark:text-green-200">
                                                    Un nouveau lien de vérification a été envoyé.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form Actions -->
                        <div
                            class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-700">
                            <x-action-message on="profile-updated" class="text-green-600 dark:text-green-400">
                                <span class="text-sm font-medium">Profil mis à jour avec succès</span>
                            </x-action-message>

                            <button type="submit"
                                class="px-4 py-2 bg-slate-900 hover:bg-slate-700 text-white text-sm font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Management Card -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                        Gestion du compte
                    </h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                        Actions permanentes concernant votre compte
                    </p>
                </div>

                <div class="px-6 py-6">
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                    Suppression du compte
                                </h3>
                                <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                                    Cette action est irréversible et supprimera définitivement toutes vos données.
                                </p>
                                <div class="mt-4">
                                    <livewire:settings.delete-user-form />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>