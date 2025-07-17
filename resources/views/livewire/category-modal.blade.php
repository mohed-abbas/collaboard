<div>
    <x-modal.dialog wire:model="showCategoryModal" class="w-full max-w-lg">
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
                            {{ $isEditing ? 'Modifier' : 'Nouvelle catégorie' }}
                        </h2>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <form wire:submit.prevent="saveCategory" class="space-y-5">

                    <!-- Category Details -->
                    <div class="space-y-3">
                        <input type="text" wire:model.live.debounce.150ms="categoryTitle"
                            class="w-full px-3 py-2 border-0 border-b border-slate-200 dark:border-slate-700 bg-transparent text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition-colors"
                            placeholder="Nom de la catégorie">
                        @error('categoryTitle')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color Selection -->
                    <div class="flex items-center space-x-3">
                        <input type="color" wire:model.live="categoryColor"
                            class="w-12 h-8 rounded border border-slate-200 dark:border-slate-700 cursor-pointer"
                            value="{{ $categoryColor ?? '#060436' }}">

                        <input type="text" wire:model.live="categoryColor"
                            class="flex-1 px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors"
                            placeholder="#060436">
                    </div>
                    @error('categoryColor')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    @if($categoryTitle)
                        <div
                            class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                            <div
                                class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-600 p-3">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-medium text-slate-900 dark:text-white">{{ $categoryTitle }}</h3>
                                    <div class="w-3 h-3 rounded"
                                        style="background-color: {{ $categoryColor ?? '#060436' }}"></div>
                                </div>

                                <div class="space-y-2">
                                    <div
                                        class="h-8 bg-slate-100 dark:bg-slate-700 rounded border border-slate-200 dark:border-slate-600 opacity-60">
                                    </div>
                                    <div
                                        class="h-8 bg-slate-100 dark:bg-slate-700 rounded border border-slate-200 dark:border-slate-600 opacity-40">
                                    </div>
                                    <div
                                        class="h-8 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded flex items-center justify-center">
                                        <span class="text-xs text-slate-500 dark:text-slate-400">+ Ajouter tâche</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between pt-3 border-t border-slate-200 dark:border-slate-700">
                        <button type="button" wire:click="$set('showCategoryModal', false)"
                            class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                            Annuler
                        </button>

                        <button type="submit"
                            class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm rounded">
                            {{ $isEditing ? 'Sauvegarder' : 'Créer' }}
                        </button>
                    </div>
                </form>

                <!-- Tips -->
                <div class="mt-5 pt-5 border-t border-slate-200 dark:border-slate-700">
                    <div
                        class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex space-x-2">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-1">Conseils</p>
                                <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-0.5">
                                    <li>• Utilisez "À faire", "En cours", "Terminé"</li>
                                    <li>• Noms courts et descriptifs</li>
                                    <li>• Pensez au flux de votre équipe</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>