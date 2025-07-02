<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-md">
        <x-slot name="title">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $isEditing ? 'Modifier la Tâche' : 'Créer une Nouvelle Tâche' }}
            </h3>
        </x-slot>

        <x-slot name="newContent">
            <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'createTask' }}" class="space-y-6">
                <!-- Task Title -->
                <div class="space-y-1">
                    <label for="taskTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input id="taskTitle" type="text" wire:model="taskTitle" placeholder="Entrez le titre"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                    @error('taskTitle')
                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Task Description -->
                <div class="space-y-1">
                    <label for="taskDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <textarea id="taskDescription" wire:model="taskDescription" placeholder="Entrez la description"
                        rows="3"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm"></textarea>
                    @error('taskDescription')
                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div class="space-y-1">
                    <label for="categoryId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select id="categoryId" wire:model="categoryId"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    @error('categoryId')
                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Labels Selection -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Étiquettes
                    </label>

                    @if(count($availableLabels) > 0)
                    <div class="space-y-2 max-h-32 overflow-y-auto border rounded-md p-3 bg-gray-50 dark:bg-gray-800">
                        @foreach($availableLabels as $label)
                        <label
                            class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 p-1 rounded">
                            <input type="checkbox" wire:click="toggleLabel({{ $label->id }})"
                                {{ $this->isLabelSelected($label->id) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white"
                                style="background-color: {{ $label->color }}">
                                {{ $label->name }}
                            </span>
                        </label>
                        @endforeach
                    </div>

                    <!-- Selected Labels Preview -->
                    @if(count($selectedLabels) > 0)
                    <div class="mt-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Étiquettes sélectionnées:</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($availableLabels->whereIn('id', $selectedLabels) as $label)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white"
                                style="background-color: {{ $label->color }}">
                                {{ $label->name }}
                                <button type="button" wire:click="toggleLabel({{ $label->id }})"
                                    class="ml-1 text-white hover:text-gray-200">
                                    ×
                                </button>
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @else
                    <div
                        class="text-center py-4 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-md">
                        <div class="text-2xl mb-2">🏷️</div>
                        <p class="text-sm">Aucune étiquette disponible.</p>
                        <p class="text-xs">Créez des étiquettes dans les paramètres du projet.</p>
                    </div>
                    @endif

                    @error('selectedLabels')
                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                     
                <!-- Task Deadline -->
                <div class="space-y-1">
                    <label for="taskDeadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Date limite <span class="text-red-500">*</span>
                    </label>
                    <input id="taskDeadline" type="datetime-local" wire:model="taskDeadline"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                    @error('taskDeadline')
                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Task Status (only for editing) -->
                @if($isEditing)
                <div class="space-y-1">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" wire:model="taskIsDone"
                            class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Marquer comme terminée
                        </span>
                    </label>
                </div>
                @endif

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" wire:click="resetForm"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    @if($isEditing)
                    <button type="button" wire:click="deleteTask({{ $taskId }})"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')"
                        class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                    @endif
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        {{ $isEditing ? 'Mettre à jour' : 'Créer la tâche' }}
                    </button>
                </div>
            </form>
        </x-slot>
    </x-modal.dialog>
</div>