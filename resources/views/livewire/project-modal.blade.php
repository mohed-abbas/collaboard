<x-modal.dialog wire:model="showModal" class="w-full max-w-lg">
    <x-slot name="title">
        <!-- Minimal Header -->
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-medium text-slate-900 dark:text-white">
                        {{ $isEditing ? 'Modifier' : 'Nouveau projet' }}
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="newContent">
        <div class="p-6">
            <form wire:submit.prevent="{{ $isEditing ? 'updateProject' : 'createProject' }}" class="space-y-5">

                <!-- Project Details -->
                <div class="space-y-3">
                    <input type="text" wire:model="name"
                        class="w-full px-3 py-2 border-0 border-b border-slate-200 dark:border-slate-700 bg-transparent text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition-colors"
                        placeholder="Nom du projet">
                    @error('name')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <textarea wire:model.defer="description" rows="2"
                        class="w-full px-3 py-2 border-0 border-b border-slate-200 dark:border-slate-700 bg-transparent text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition-colors resize-none"
                        placeholder="Description (optionnel)"></textarea>
                    @error('description')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview -->
                @if($name)
                    <div
                        class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-600 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-medium text-slate-900 dark:text-white">{{ $name }}</h3>
                                <div class="w-3 h-3 bg-green-500 rounded"></div>
                            </div>

                            @if($description)
                                <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">{{ $description }}</p>
                            @endif

                            <div class="space-y-2">
                                <div
                                    class="h-6 bg-slate-100 dark:bg-slate-700 rounded border border-slate-200 dark:border-slate-600 opacity-60 flex items-center px-2">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">À faire</span>
                                </div>
                                <div
                                    class="h-6 bg-slate-100 dark:bg-slate-700 rounded border border-slate-200 dark:border-slate-600 opacity-40 flex items-center px-2">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">En cours</span>
                                </div>
                                <div
                                    class="h-6 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded flex items-center justify-center">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">+ Ajouter catégorie</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-between pt-3">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                        Annuler
                    </button>

                    <div class="flex">
                        @if($isEditing)
                            <button type="button" wire:click="deleteProject"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')"
                                class="px-3 py-1 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                Supprimer
                            </button>
                        @endif
                        <button type="submit"
                            class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm rounded">
                            {{ $isEditing ? 'Sauvegarder' : 'Créer' }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tips -->
            <div class="mt-5 pt-5">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex space-x-2">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-1">Conseils</p>
                            <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-0.5">
                                <li>• Choisissez un nom descriptif et clair</li>
                                <li>• Ajoutez une description pour le contexte</li>
                                <li>• Vous pourrez inviter des membres après</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-modal.dialog>