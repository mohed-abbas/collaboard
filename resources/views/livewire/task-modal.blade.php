<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-2xl">
        <x-slot name="title">
            <div class="flex items-center space-x-3 p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                    {{ $isEditing ? 'Modifier la Tâche' : 'Créer une Nouvelle Tâche' }}
                </h3>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'createTask' }}" class="space-y-6">
                    <!-- Task Title -->
                    <div>
                        <label for="taskTitle"
                            class="block text-sm font-medium text-slate-900 dark:text-white mb-2">Titre de la Tâche
                            <span class="text-red-500">*</span>
                        </label>
                        <input id="taskTitle" type="text" wire:model="taskTitle"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                            placeholder="ex. Implémenter l'authentification utilisateur">
                        @error('taskTitle')
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

                    <!-- Task Description -->
                    <div>
                        <label for="taskDescription"
                            class="block text-sm font-medium text-slate-900 dark:text-white mb-2">Description
                            <span class="text-slate-500 dark:text-slate-400 text-xs">(Optionnelle)</span>
                        </label>
                        <textarea id="taskDescription" wire:model="taskDescription" rows="4"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 resize-none"
                            placeholder="Fournir une description détaillée de la tâche..."></textarea>
                        @error('taskDescription')
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

                    <!-- Category & Priority Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Selection -->
                        <div>
                            <label for="categoryId"
                                class="block text-sm font-medium text-slate-900 dark:text-white mb-2">Catégorie
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="categoryId" wire:model="categoryId"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('categoryId')
                            <div
                                class="flex items-center mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400 flex-shrink-0"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <!-- Priority Level -->
                        <div>
                            <label for="priorityLevel"
                                class="block text-sm font-medium text-slate-900 dark:text-white mb-2">Niveau de Priorité
                            </label>
                            <select id="priorityLevel" wire:model="priorityLevel"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200">


                                @foreach($priorityLevelsInfo as $level => $info)
                                <option value="{{ $level }}" {{ 
                                    $priorityLevel == $level ? 'selected' : '' }}>
                                    {{ ucfirst($info) }}
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <!-- Labels Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white mb-3">
                            Étiquettes
                            <span class="text-slate-500 dark:text-slate-400 text-xs">(Optionnelles)</span>
                        </label>

                        @if(count($availableLabels) > 0)
                        <div
                            class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-40 overflow-y-auto custom-scrollbar">
                                @foreach($availableLabels as $label)
                                <label
                                    class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-white dark:hover:bg-slate-700 transition-colors duration-200">
                                    <input type="checkbox" wire:click="toggleLabel({{ $label->id }})"
                                        {{ $this->isLabelSelected($label->id) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-600 border-slate-300 dark:border-slate-500 rounded focus:ring-blue-500 dark:focus:ring-blue-400">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium text-white"
                                        style="background-color: {{ $label->color }}">
                                        {{ $label->name }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Selected Labels Preview -->
                        @if(count($selectedLabels) > 0)
                        <div
                            class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span class="text-sm font-medium text-blue-900 dark:text-blue-100">Étiquettes
                                    Sélectionnées</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($availableLabels->whereIn('id', $selectedLabels) as $label)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium text-white"
                                    style="background-color: {{ $label->color }}">
                                    {{ $label->name }}
                                    <button type="button" wire:click="toggleLabel({{ $label->id }})"
                                        class="ml-2 text-white/80 hover:text-white transition-colors">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @else
                        <div
                            class="text-center py-8 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                            <div
                                class="w-12 h-12 mx-auto mb-3 bg-slate-200 dark:bg-slate-700 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-slate-900 dark:text-white mb-1">Aucune Étiquette
                                Disponible
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Créez des étiquettes dans les
                                paramètres du projet pour
                                organiser vos tâches.</p>
                        </div>
                        @endif

                        @error('selectedLabels')
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


                    <!-- User Assignment -->
                    <!-- User Assignment Section -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Membres assignés
                        </label>

                        <!-- Display assigned users -->
                        @if(!empty($taskUsers))
                        <div class="mb-3">
                            <div class="flex flex-wrap gap-2">
                                @foreach($taskUsers as $user)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $user['name'] }}
                                    @if(isset($user['pivot']['is_creator']) && $user['pivot']['is_creator'])
                                    <span class="ml-1 text-blue-600" title="Créateur de la tâche">👑</span>
                                    @endif
                                    <button type="button" wire:click="removeUserFromTask({{ $user['id'] }})"
                                        class="ml-2 text-blue-600 hover:text-red-600 transition-colors duration-200"
                                        title="Retirer {{ $user['name'] }} de la tâche">
                                        ×
                                    </button>
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- User assignment dropdown - Show for both creating and editing -->
                        @if(($isEditing && $task) || (!$isEditing && $categoryId))
                        @if($this->getAssignableUsers()->count() > 0)
                        <div class="relative">
                            <button type="button" wire:click="toggleUserDropdown"
                                class="w-full px-3 py-2 text-left border border-gray-300 rounded-md shadow-sm bg-white hover:bg-gray-50 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 flex items-center justify-between">
                                <span class="block truncate text-gray-700">
                                    Assigner un membre
                                </span>
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200 {{ $showUserDropdown ? 'rotate-180' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            @if($showUserDropdown)
                            <div
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                                @foreach($this->getAssignableUsers() as $user)
                                <button type="button" wire:click="assignUserToTask({{ $user->id }})"
                                    class="w-full px-4 py-3 text-left hover:bg-gray-100 focus:bg-gray-100 focus:outline-none transition-colors duration-150 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-sm font-medium text-white">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                        @if($isEditing && $task && $task->created_by == $user->id)
                                        <span class="ml-2 text-xs text-blue-600 font-medium"
                                            title="Créateur de la tâche">
                                            👑 Créateur
                                        </span>
                                        @endif
                                    </div>
                                </button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                            <p class="text-sm text-gray-500 italic">
                                @if($isEditing)
                                Tous les membres du projet sont déjà assignés à cette tâche.
                                @else
                                Aucun membre disponible pour l'assignation.
                                @endif
                            </p>
                        </div>
                        @endif
                        @endif

                        <!-- Help text -->
                        @if(empty($taskUsers))
                        <p class="mt-2 text-xs text-gray-500">
                            Vous pouvez assigner des membres du projet à cette tâche. Les membres assignés recevront des
                            notifications.
                        </p>
                        @endif
                    </div>

                    <!-- Task Deadline -->
                    <div>
                        <label for="taskDeadline"
                            class="block text-sm font-medium text-slate-900 dark:text-white mb-2">Date limite
                            <span class="text-red-500">*</span>
                        </label>
                        <input id="taskDeadline" type="datetime-local" wire:model="taskDeadline"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                        @error('taskDeadline')
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

                    <!-- Task Status (only for editing) -->
                    @if($isEditing)
                    <div
                        class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" wire:model="taskIsDone"
                                class="w-5 h-5 text-green-600 bg-white dark:bg-slate-600 border-slate-300 dark:border-slate-500 rounded focus:ring-green-500 dark:focus:ring-green-400">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-slate-900 dark:text-white">
                                    Marquer comme terminé
                                </span>
                            </div>
                        </label>
                    </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="flex justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex space-x-3">
                            <button type="button" wire:click="resetForm"
                                class="px-6 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium transition-all duration-200">
                                Annuler
                            </button>
                        </div>

                        <div class="flex space-x-3">
                            @if($isEditing)
                            <button type="button" wire:click="deleteTask({{ $taskId }})"
                                class="inline-flex items-center px-4 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white rounded-xl font-medium transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                            @endif
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-xl font-medium transition-all duration-200 hover:shadow-lg">
                                @if($isEditing)
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Mettre à jour la tâche
                                @else
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Créer une tâche
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>