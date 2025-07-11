<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-2xl">
        <x-slot name="title">
            <!-- Minimal Header -->
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @php
                            $priorityColors = [
                                'low' => 'bg-emerald-500',
                                'medium' => 'bg-amber-500',
                                'high' => 'bg-red-500'
                            ];
                            $priorityIcon = $priorityColors[$priorityLevel] ?? $priorityColors['medium'];
                        @endphp

                        <div class="w-8 h-8 {{ $priorityIcon }} rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-medium text-slate-900 dark:text-white">
                                {{ $isEditing ? 'Modifier' : 'Nouvelle tâche' }}
                            </h2>
                        </div>
                    </div>

                    @if($isEditing)
                        <button type="button" wire:click="$toggle('taskIsDone')"
                            class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors {{ $taskIsDone ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                            <span
                                class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $taskIsDone ? 'translate-x-5' : 'translate-x-1' }}"></span>
                        </button>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="newContent">
            <div class="p-6">
                <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'createTask' }}" class="space-y-5">

                    <!-- Task Details -->
                    <div class="space-y-3">
                        <input type="text" wire:model="taskTitle"
                            class="w-full px-3 py-2 border-0 border-b border-slate-200 dark:border-slate-700 bg-transparent text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition-colors {{ $taskIsDone ? 'line-through opacity-75' : '' }}"
                            placeholder="Titre de la tâche">
                        @error('taskTitle')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror

                        <textarea wire:model="taskDescription" rows="2"
                            class="w-full px-3 py-2 border-0 border-b border-slate-200 dark:border-slate-700 bg-transparent text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition-colors resize-none {{ $taskIsDone ? 'line-through opacity-75' : '' }}"
                            placeholder="Description..."></textarea>
                    </div>

                    <!-- Properties -->
                    <div class="grid grid-cols-3 gap-3">
                        <select wire:model="categoryId"
                            class="px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>

                        <select wire:model="priorityLevel"
                            class="px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors">
                            @foreach($priorityLevelsInfo as $level => $info)
                                <option value="{{ $level }}">{{ ucfirst($info) }}</option>
                            @endforeach
                        </select>

                        <input type="datetime-local" wire:model="taskDeadline"
                            class="px-3 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors">
                    </div>

                    <!-- Labels -->
                    @if(count($availableLabels) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($availableLabels as $label)
                                <button type="button" wire:click="toggleLabel({{ $label->id }})"
                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-medium transition-all {{ $this->isLabelSelected($label->id) ? 'ring-1 ring-blue-500' : '' }}"
                                    style="background-color: {{ $label->color }}15; color: {{ $label->color }};">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5"
                                        style="background-color: {{ $label->color }};"></span>
                                    {{ $label->name }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Team -->
                    <div>
                        @if(!empty($taskUsers))
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($taskUsers as $user)
                                    <div class="flex items-center space-x-2 px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded">
                                        <div class="w-5 h-5 bg-slate-500 rounded flex items-center justify-center">
                                            <span
                                                class="text-white font-medium text-xs">{{ strtoupper(substr($user['name'], 0, 1)) }}</span>
                                        </div>
                                        <span class="text-xs text-slate-900 dark:text-white">{{ $user['name'] }}</span>
                                        <button type="button" wire:click="removeUserFromTask({{ $user['id'] }})"
                                            class="text-slate-400 hover:text-red-500">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(($isEditing && $task) || (!$isEditing && $categoryId))
                            @if($this->getAssignableUsers()->count() > 0)
                                <div class="relative">
                                    <button type="button" wire:click="toggleUserDropdown"
                                        class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                                        + Ajouter membre
                                    </button>

                                    @if($showUserDropdown)
                                        <div
                                            class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg max-h-32 overflow-auto">
                                            @foreach($this->getAssignableUsers() as $user)
                                                <button type="button" wire:click="assignUserToTask({{ $user->id }})"
                                                    class="w-full flex items-center px-3 py-2 hover:bg-slate-50 dark:hover:bg-slate-700 text-left">
                                                    <div class="w-5 h-5 bg-slate-500 rounded flex items-center justify-center mr-2">
                                                        <span
                                                            class="text-white font-medium text-xs">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                    <span class="text-sm text-slate-900 dark:text-white">{{ $user->name }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between pt-3 border-t border-slate-200 dark:border-slate-700">
                        <button type="button" wire:click="resetForm"
                            class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                            Annuler
                        </button>

                        <div class="flex space-x-2">
                            @if($isEditing)
                                <button type="button" wire:click="deleteTask({{ $taskId }})"
                                    wire:confirm="Supprimer cette tâche ?"
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
            </div>
        </x-slot>
    </x-modal.dialog>
</div>