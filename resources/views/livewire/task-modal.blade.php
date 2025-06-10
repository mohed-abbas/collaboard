<div>
    <x-modal.dialog wire:model="showModal" class="w-full max-w-md">
        <x-slot name="title">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $isEditing ? 'Edit Task' : 'Create New Task' }}
            </h3>
        </x-slot>

        <x-slot name="newContent">
            <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'createTask' }}" class="space-y-6">
                <!-- Task Title -->
                <div class="space-y-1">
                    <label for="taskTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Title
                    </label>
                    <input id="taskTitle" type="text" wire:model="taskTitle" placeholder="Enter title"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                    @error('title')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Task Description -->
                <div class="space-y-1">
                    <label for="taskDescription" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <input id="taskDescription" type="text" wire:model="taskDescription"
                        placeholder="Enter description"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                    @error('title')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Task Deadline -->
                <div class="space-y-1">
                    <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Due Date
                    </label>
                    <input id="deadline" type="datetime-local" wire:model="taskDeadline" placeholder="Select due date"
                        value="{{ old('taskDeadline', $taskDeadline ? \Illuminate\Support\Carbon::parse($taskDeadline)->format('Y-m-d\TH:i') : '') }}"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                    @error('taskDeadline')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                @if ($isEditing)
                    {{-- Category --}}
                    <div class="space-y-1">
                        <label for="categoryId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Category
                        </label>
                        <select id="categoryId" wire:model="categoryId"
                            class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm">
                            <option value="{{ $categoryId }}">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- is Done --}}
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <label for="taskIsDone" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-0">
                                Is Done
                            </label>
                            <input id="taskIsDone" type="checkbox" wire:model="taskIsDone"
                                :checked="!!@js($taskIsDone)"
                                class="rounded border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200" />
                        </div>
                        @error('is_done')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
                @if (!empty($task['users']))
                <div class="space-y-1">
                        {{-- Afficher le creator --}}
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Creator
                        </label>
                        <ul class="text-sm text-gray-800 dark:text-gray-200">
                            @foreach ($task['users'] as $user)
                                @if ($user['pivot']['is_creator'])
                                    <li>{{ $user['name'] }} &lt;{{ $user['email'] }}&gt;</li>
                                @endif
                            @endforeach
                        </ul>

                        {{-- Afficher uniquement si il y a des users qui ne sont creator --}}
                        @if (collect($task['users'])->where('pivot.is_creator', false)->isNotEmpty())
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Assigned Users
                            </label>
                        @endif
                        <ul class="list-disc list-inside text-sm text-gray-800 dark:text-gray-200">
                            @foreach ($task['users'] as $user)
                                @if (!$user['pivot']['is_creator'])
                                    <li>{{ $user['name'] }} &lt;{{ $user['email'] }}&gt;</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- Actions -->
                {{-- delete Task --}}
                @if ($isEditing)
                    <div class="flex space-x-3 gap-2">
                        <button type="button" wire:click="deleteTask({{ $taskId }})"
                            class="px-4 py-2 bg-red-500 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Task
                        </button>
                    </div>
                @endif

                <div class="flex justify-end space-x-3 gap-2">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="flex-1 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class=" flex-1 px-4 py-2 bg-blue-500 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $isEditing ? 'Update Task' : 'Add Task' }}
                    </button>
                </div>
            </form>
        </x-slot>
    </x-modal.dialog>
</div>
