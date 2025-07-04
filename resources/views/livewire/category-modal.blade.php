<div>
    <x-modal.dialog wire:model="showCategoryModal" class="w-full max-w-lg">
        <x-slot name="title">
            <div class="flex items-center space-x-3 p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                    {{ $isEditing ? 'Modifier la Catégorie' : 'Créer une Nouvelle Catégorie' }}
                </h3>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <form wire:submit.prevent="{{ $isEditing ? 'updateCategory' : 'createCategory' }}" class="space-y-6">
                    <!-- Category Title -->
                    <div>
                        <label for="categoryTitle"
                            class="block text-sm font-medium text-slate-900 dark:text-white mb-2">Titre de la Catégorie
                            <span class="text-red-500">*</span>
                        </label>
                        <input id="categoryTitle" type="text" wire:model.live.debounce.150ms="categoryTitle"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                            placeholder="e.g. 'À faire', 'En cours', 'Terminé'" required>
                        @error('categoryTitle')
                        <div
                            class="flex items-center mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>



                    <!-- Preview -->
                    @if($categoryTitle)
                    <div
                        class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-3">
                            Preview de la Catégorie
                        </label>
                        <div
                            class="bg-white dark:bg-slate-700 rounded-xl border border-slate-200 dark:border-slate-600 p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $categoryTitle }}
                                </h3>
                                <div class="w-5 h-5 rounded bg-slate-300 dark:bg-slate-600"></div>
                            </div>

                            <div class="space-y-2">
                                <div
                                    class="h-16 bg-slate-100 dark:bg-slate-600 rounded-lg border border-slate-200 dark:border-slate-500 opacity-50">
                                </div>
                                <div
                                    class="h-16 bg-slate-100 dark:bg-slate-600 rounded-lg border border-slate-200 dark:border-slate-500 opacity-30">
                                </div>
                            </div>
                            <div class="mt-3">
                                <div
                                    class="h-12 bg-slate-100 dark:bg-slate-600 rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-500 flex items-center justify-center">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">+ Ajouter une Tâche</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="$set('showCategoryModal', false)"
                            class="px-6 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium transition-all duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-xl font-medium transition-all duration-200 hover:shadow-lg">
                            <div class="flex items-center">
                                @if($isEditing)
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Mettre à jour la Catégorie
                                @else
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Créer une Catégorie
                                @endif
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Category Tips -->
                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-1">
                                    Conseils sur les Catégories
                                </h4>
                                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                                    <li>• Utilisez des étapes de flux de travail telles que "À faire", "En cours",
                                        "Révision", "Terminé"</li>
                                    <li>• Gardez les noms de catégorie courts et descriptifs</li>
                                    <li>• Tenez compte du flux de travail de votre équipe lors de la création de
                                        catégories</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>