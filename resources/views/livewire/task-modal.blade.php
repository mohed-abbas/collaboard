<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-3xl">
        <x-slot name="title">
            <!-- Minimal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h2
                        class="text-lg font-semibold text-slate-900 dark:text-white {{ $taskIsDone ? 'line-through opacity-60' : '' }} transition-all duration-300">
                        {{ $isEditing ? 'Modifier la tâche' : 'Nouvelle tâche' }}
                    </h2>
                </div>

                <!-- Modern Professional Checkbox (for editing) -->
                @if($isEditing)
                    <div class="flex items-center space-x-3">
                        <div class="relative group">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="taskIsDone" class="sr-only peer">
                                <div
                                    class="w-5 h-5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500/20 peer-checked:bg-green-500 peer-checked:border-green-500 dark:peer-checked:bg-green-600 dark:peer-checked:border-green-600 transition-all duration-200 hover:border-slate-400 dark:hover:border-slate-500">
                                    <!-- Check icon -->
                                    <svg class="w-3 h-3 text-white absolute top-0.5 left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>

                            <!-- Tooltip -->
                            <div
                                class="absolute bottom-full right-0 mb-2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                                {{ $taskIsDone ? 'Marquer comme non terminé' : 'Marquer comme terminé' }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="px-6 py-6">
                <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'createTask' }}" class="space-y-5">

                    <!-- Title & Description Section -->
                    <div class="space-y-4">
                        <div>
                            <input id="taskTitle" type="text" wire:model="taskTitle"
                                class="w-full text-xl font-medium bg-transparent border-0 border-b border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-blue-500 focus:ring-0 px-0 py-2 {{ $taskIsDone ? 'line-through opacity-60' : '' }} transition-all duration-300"
                                placeholder="Nom de la tâche">
                            @error('taskTitle')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <textarea id="taskDescription" wire:model="taskDescription" rows="3"
                                class="w-full bg-transparent border-0 border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 placeholder-slate-400 dark:placeholder-slate-500 focus:border-blue-500 focus:ring-0 px-0 py-2 resize-none {{ $taskIsDone ? 'line-through opacity-60' : '' }} transition-all duration-300"
                                placeholder="Ajouter une description..."></textarea>
                        </div>
                    </div>

                    <!-- Quick Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Category -->
                        <div>
                            <label
                                class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wide">
                                Catégorie
                            </label>
                            <select wire:model="categoryId"
                                class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label
                                class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wide">
                                Priorité
                            </label>
                            <select wire:model="priorityLevel"
                                class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                @foreach($priorityLevelsInfo as $level => $info)
                                    <option value="{{ $level }}">{{ ucfirst($info) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Deadline -->
                        <div>
                            <label
                                class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wide">
                                Échéance
                            </label>
                            <input type="datetime-local" wire:model="taskDeadline"
                                class="w-full px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Labels Section -->
                    @if(count($availableLabels) > 0)
                        <div>
                            <label
                                class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wide">
                                Étiquettes
                            </label>

                            <!-- Available Labels -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($availableLabels as $label)
                                    <button type="button" wire:click="toggleLabel({{ $label->id }})"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-all {{ $this->isLabelSelected($label->id) ? 'ring-2 ring-offset-1 ring-blue-500' : 'hover:scale-105' }} {{ $taskIsDone ? 'opacity-60' : '' }}"
                                        style="background-color: {{ $label->color }}20; color: {{ $label->color }}; border: 1px solid {{ $label->color }}40;">
                                        <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $label->color }};">
                                        </div>
                                        {{ $label->name }}
                                        @if($this->isLabelSelected($label->id))
                                            <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Team Section -->
                    <div>
                        <label
                            class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wide">
                            Équipe
                        </label>

                        <!-- Current Team Members -->
                        @if(!empty($taskUsers))
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($taskUsers as $user)
                                    <div
                                        class="flex items-center px-3 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg {{ $taskIsDone ? 'opacity-60' : '' }} transition-opacity duration-300">
                                        <div
                                            class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-medium text-white mr-2">
                                            {{ strtoupper(substr($user['name'], 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-slate-900 dark:text-white mr-2">{{ $user['name'] }}</span>
                                        @if(isset($user['pivot']['is_creator']) && $user['pivot']['is_creator'])
                                            <span
                                                class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 text-xs rounded-full mr-2">
                                                Admin
                                            </span>
                                        @endif
                                        <button type="button" wire:click="removeUserFromTask({{ $user['id'] }})"
                                            class="text-slate-400 hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Add Team Member -->
                        @if(($isEditing && $task) || (!$isEditing && $categoryId))
                            @if($this->getAssignableUsers()->count() > 0)
                                <div class="relative">
                                    <button type="button" wire:click="toggleUserDropdown"
                                        class="flex items-center px-3 py-2 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 transition-colors text-sm text-slate-600 dark:text-slate-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Ajouter un membre
                                    </button>

                                    @if($showUserDropdown)
                                        <div
                                            class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg max-h-48 overflow-auto">
                                            @foreach($this->getAssignableUsers() as $user)
                                                <button type="button" wire:click="assignUserToTask({{ $user->id }})"
                                                    class="w-full flex items-center px-3 py-3 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors border-b border-slate-100 dark:border-slate-700 last:border-b-0">
                                                    <div
                                                        class="w-8 h-8 bg-slate-500 rounded-full flex items-center justify-center text-sm font-medium text-white mr-3">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $user->name }}
                                                        </p>
                                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                        <button type="button" wire:click="resetForm"
                            class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                            Annuler
                        </button>

                        <div class="flex space-x-3">
                            @if($isEditing)
                                <button type="button" wire:click="deleteTask({{ $taskId }})"
                                    wire:confirm="Supprimer cette tâche ?"
                                    class="px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                                    Supprimer
                                </button>
                            @endif
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                {{ $isEditing ? 'Sauvegarder' : 'Créer la tâche' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-modal.dialog>
</div>