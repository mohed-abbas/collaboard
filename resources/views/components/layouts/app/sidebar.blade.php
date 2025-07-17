<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @livewireStyles
</head>

<body class="min-h-screen bg-white dark:bg-zinc-900" x-data="{ 
          sidebarOpen: window.innerWidth >= 1024 ? 
              (localStorage.getItem('sidebarOpen') === 'false' ? false : true) : 
              false,
          init() {
              // Listen for window resize to handle mobile/desktop transitions
              window.addEventListener('resize', () => {
                  if (window.innerWidth < 1024) {
                      this.sidebarOpen = false;
                  } else {
                      this.sidebarOpen = localStorage.getItem('sidebarOpen') === 'false' ? false : true;
                  }
              });
          }
      }" x-effect="localStorage.setItem('sidebarOpen', sidebarOpen)">
    <!-- Custom Sidebar -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="relative flex flex-col bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl border-r border-slate-200/60 dark:border-slate-700/60 transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'w-64' : 'w-16'">

            <!-- Sidebar Header -->
            <div
                class="flex items-center justify-between p-4 border-b border-slate-200/60 dark:border-slate-700/60 min-h-[73px]">
                <!-- Logo (only show when expanded) -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 transition-opacity duration-300"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'" wire:navigate>
                    <x-app-logo />
                </a>

                <!-- Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                    :class="!sidebarOpen ? 'mx-auto' : ''">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            :d="sidebarOpen ? 'M11 19l-7-7 7-7m8 14l-7-7 7-7' : 'M4 6h16M4 12h16M4 18h16'"></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Content -->
            <div class="flex-1 overflow-y-auto p-4">
                <!-- Project Manager (only show when expanded) -->
                <div class="mb-6 transition-opacity duration-300"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 hidden'">
                    <livewire:project-manager />
                </div>

                <!-- Platform Navigation (compact icons for collapsed state) -->
                <div class="space-y-2" x-show="!sidebarOpen">
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center justify-center py-2 px-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' }}"
                            wire:navigate title="{{ __('Dashboard') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Menu -->
            <div class="p-4 border-t border-slate-200/60 dark:border-slate-700/60">
                <!-- Expanded User Menu -->
                <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <flux:dropdown position="top" align="start">
                        <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                            icon-trailing="chevrons-up-down" />

                        <flux:menu class="w-[220px]">
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                    {{ __('Settings') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                    class="w-full">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>

                <!-- Collapsed User Menu -->
                <div x-show="!sidebarOpen" x-transition:enter="transition-opacity duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="flex flex-col space-y-2">

                    <!-- User Avatar -->
                    <flux:dropdown position="right" align="start">
                        <button
                            class="w-8 h-8 mx-auto rounded-lg bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center text-sm font-medium hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors"
                            title="{{ auth()->user()->name }}">
                            {{ auth()->user()->initials() }}
                        </button>

                        <flux:menu class="w-[220px]">
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                                    {{ __('Settings') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                    class="w-full">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Mobile Header (show when sidebar is collapsed on mobile) -->
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    @fluxScripts
</body>

</html>