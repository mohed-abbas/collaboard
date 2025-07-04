<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-2xl horizontal-scroll">
        <x-slot name="title">
            <div class="flex items-center space-x-3 p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                    {{ $isEditing ? 'Modifier l\'Étiquette' : 'Créer une Nouvelle Étiquette' }}
                </h3>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <form wire:submit.prevent="saveLabel" class="space-y-6">
                    <!-- Label Name -->
                    <div>
                        <label for="labelName" class="block text-sm font-medium text-slate-900 dark:text-white mb-2">
                            Nom de l'Étiquette <span class="text-red-500">*</span>
                        </label>
                        <input id="labelName" type="text" wire:model="labelName"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                            placeholder="ex. : Backend, Frontend, Design">
                        @error('labelName')
                        <div
                            class="flex items-center mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-red-600 dark:text-red-400">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <!-- Color Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-3">
                            Couleur <span class="text-red-500">*</span>
                        </label>
                        <!-- Predefined Colors -->
                        <div
                            class="bg-white dark:bg-slate-900 rounded-xl p-4 border border-slate-200 dark:border-slate-700 mb-6">
                            <h4 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Couleurs Populaires
                            </h4>
                            <div class="grid grid-cols-6 sm:grid-cols-8 gap-3">
                                @foreach($predefinedColors as $color)
                                <button type="button" wire:click="setColor('{{ $color }}')"
                                    class="group relative w-10 h-10 rounded-xl border-2 transition-all duration-200 hover:scale-110 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-900 {{ $labelColor === $color ? 'border-slate-400 dark:border-slate-300 shadow-lg ring-2 ring-blue-500 dark:ring-blue-400' : 'border-slate-300 dark:border-slate-600' }}"
                                    style="background-color: {{ $color }};">
                                    @if($labelColor === $color)
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white drop-shadow-sm" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    <span class="sr-only">Sélectionner la couleur {{ $color }}</span>
                                    <!-- Tooltip -->
                                    <div
                                        class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-900 dark:bg-slate-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                        {{ $color }}
                                    </div>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Custom Color Input -->
                        <div
                            class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-3">
                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Personnalisée
                                        :</label>
                                    <div class="relative">
                                        <input type="color" wire:model="labelColor"
                                            class="w-12 h-12 rounded-lg border-2 border-slate-300 dark:border-slate-600 cursor-pointer bg-white dark:bg-slate-700">
                                    </div>
                                </div>
                                <input type="text" wire:model="labelColor"
                                    class="flex-1 px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent"
                                    placeholder="#3B82F6" pattern="^#[0-9A-Fa-f]{6}$">
                            </div>
                        </div>
                        @error('labelColor')
                        <div
                            class="flex items-center mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-red-600 dark:text-red-400">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>

                    <!-- Preview -->
                    <div
                        class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-3">
                            Aperçu
                        </label>
                        <div class="flex items-center space-x-3">
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-white shadow-sm transition-all duration-200"
                                style="background-color: {{ $labelColor }}">
                                {{ $labelName ?: 'Nom de l\'Étiquette' }}
                            </span>
                            <span class="text-sm text-slate-500 dark:text-slate-400 font-mono">
                                {{ $labelColor }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="resetForm"
                            class="px-6 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium transition-all duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-xl font-medium transition-all duration-200 hover:shadow-lg">
                            {{ $isEditing ? 'Mettre à Jour l\'Étiquette' : 'Créer l\'Étiquette' }}
                        </button>
                    </div>
                </form>

                <!-- Existing Labels List -->
                @if(count($labels) > 0)
                <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-slate-900 dark:text-white">
                            Étiquettes Existantes
                        </h4>
                        <span
                            class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-sm font-medium">
                            {{ count($labels) }} au total
                        </span>
                    </div>
                    <div class="space-y-3">
                        @foreach($labels as $label)
                        <div
                            class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white shadow-sm"
                                    style="background-color: {{ $label->color }}">
                                    {{ $label->name }}
                                </span>
                                <span
                                    class="text-xs text-slate-500 dark:text-slate-400 font-mono bg-slate-200 dark:bg-slate-700 px-2 py-1 rounded">
                                    {{ $label->color }}
                                </span>
                                @if($label->tasks->count() > 0)
                                <span
                                    class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    {{ $label->tasks->count() }} tâche{{ $label->tasks->count() > 1 ? 's' : '' }}
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <button wire:click="openEditModal({{ $label->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                </button>

                                <!-- Delete Button -->
                                @if($label->tasks->count() > 0)
                                <button wire:click="forceDeleteLabel({{ $label->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-lg transition-all duration-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.987-.833-2.732 0L3.005 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    Forcer Suppression
                                </button>
                                @else
                                <button wire:click="deleteLabel({{ $label->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <div class="text-center py-12">
                        <div
                            class="w-16 h-16 mx-auto mb-4 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                            Aucune Étiquette Créée
                        </h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm max-w-sm mx-auto">
                            Créez votre première étiquette pour organiser les tâches par catégories comme Backend,
                            Frontend, Design, etc.
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </x-slot>
    </x-modal.dialog>
</div>