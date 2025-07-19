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

    <!-- Right Side - Verification Card -->
    <div class="flex-1 lg:w-1/2 xl:w-3/5 flex items-center justify-center p-3 lg:p-4 xl:p-6 overflow-y-auto">
        <div class="w-full max-w-lg">
            <!-- Mobile Logo -->
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

            <div class="mb-4">
                <h1
                    class="text-xl lg:text-2xl xl:text-3xl font-black mb-2 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent">
                    {{ __('Verify Email Address') }}
                </h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400 text-center">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="flex flex-col gap-4">
                <button wire:click="sendVerification" type="button"
                    class="group w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#4586FF] to-[#99BDFF] hover:from-[#3d79f5] hover:to-[#8eb2fc] text-white rounded-lg font-bold text-sm shadow-2xl shadow-blue-500/25 dark:shadow-blue-400/20 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-blue-500/40 dark:hover:shadow-blue-400/30 transform">
                    {{ __('Resend verification email') }}
                </button>

                <button wire:click="logout" type="button"
                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border-2 border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm hover:bg-slate-50 dark:hover:bg-slate-700/80 font-medium transition-all duration-300 hover:scale-105 shadow-sm hover:shadow-md">
                    {{ __('Log out') }}
                </button>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" wire:navigate
                    class="inline-flex items-center text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 font-medium transition-colors text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to home') }}
                </a>
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

            <!-- Benefits -->
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
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 102 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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