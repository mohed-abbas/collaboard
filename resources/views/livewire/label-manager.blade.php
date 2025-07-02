<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-2xl">
        <x-slot name="title">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $isEditing ? 'Modifier l\'Étiquette' : 'Créer une Nouvelle Étiquette' }}
            </h3>
        </x-slot>

        <x-slot name="newContent">
            <form wire:submit.prevent="saveLabel" class="space-y-6">
                <!-- Label Name -->
                <div>
                    <label for="labelName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nom de l'étiquette <span class="text-red-500">*</span>
                    </label>
                    <input id="labelName" type="text" wire:model="labelName"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                        placeholder="ex: Backend, Frontend, Marketing">
                    @error('labelName')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Couleur <span class="text-red-500">*</span>
                    </label>

                    <!-- Predefined Colors -->
                    <div class="grid grid-cols-6 gap-3 mb-4">
                        @foreach($predefinedColors as $color)
                            <button type="button" wire:click="setColor('{{ $color }}')"
                                class="w-10 h-10 rounded-lg border-2 transition-all duration-200 hover:scale-110
                                            {{ $labelColor === $color ? 'border-gray-800 ring-2 ring-offset-2 ring-gray-400' : 'border-gray-300 hover:border-gray-500' }}"
                                style="background-color: {{ $color }}" title="{{ $color }}">
                            </button>
                        @endforeach
                    </div>

                    <!-- Custom Color Input -->
                    <div class="flex items-center space-x-3">
                        <label class="text-sm text-gray-600">Couleur personnalisée:</label>
                        <input type="color" wire:model="labelColor"
                            class="w-12 h-10 rounded border border-gray-300 cursor-pointer">
                        <input type="text" wire:model="labelColor"
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            placeholder="#3B82F6" pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                    @error('labelColor')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Aperçu
                    </label>
                    <div class="flex items-center space-x-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white shadow-sm"
                            style="background-color: {{ $labelColor }}">
                            {{ $labelName ?: 'Nom de l\'étiquette' }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $labelColor }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="resetForm"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        {{ $isEditing ? 'Mettre à jour' : 'Créer l\'étiquette' }}
                    </button>
                </div>
            </form>

            <!-- Existing Labels List -->
            @if(count($labels) > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Étiquettes existantes ({{ count($labels) }})
                    </h4>
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @foreach($labels as $label)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white"
                                        style="background-color: {{ $label->color }}">
                                        {{ $label->name }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $label->color }}</span>
                                    @if($label->tasks->count() > 0)
                                        <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">
                                            {{ $label->tasks->count() }} tâche(s)
                                        </span>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="openEditModal({{ $label->id }})"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Modifier
                                    </button>
                                    @if($label->tasks->count() > 0)
                                        <button wire:click="forceDeleteLabel({{ $label->id }})"
                                            onclick="return confirm('Cette étiquette est utilisée par {{ $label->tasks->count() }} tâche(s). Êtes-vous sûr de vouloir la supprimer ? Elle sera retirée de toutes les tâches.')"
                                            class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                            Forcer la suppression
                                        </button>
                                    @else
                                        <button wire:click="deleteLabel({{ $label->id }})"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette étiquette ?')"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Supprimer
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-5xl mb-4">🏷️</div>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                            Aucune étiquette créée
                        </h4>
                        <p class="text-gray-500 text-sm">
                            Créez votre première étiquette pour organiser vos tâches par catégories comme Backend, Frontend,
                            etc.
                        </p>
                    </div>
                </div>
            @endif
        </x-slot>
    </x-modal.dialog>
</div>