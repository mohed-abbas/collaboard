<x-modal.dialog wire:model="showModal">
    <x-slot name="title">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            {{ $isEditing ? 'Edit Project' : 'Create New Project' }}
        </h3>
    </x-slot>

    <x-slot name="newContent">
        <form wire:submit.prevent="{{ $isEditing ? 'updateProject' : 'createProject' }}" class="space-y-6">

            <!-- Project Name -->
            <div class="space-y-1">
                <label for="projectName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Project Name
                </label>
                <input id="projectName" type="text" wire:model="name" placeholder="Enter project name"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                @error('name')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Description -->
            <div class="space-y-1">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description
                </label>
                <textarea id="description" rows="4" wire:model.defer="description"
                    placeholder="Add more details about the project..."
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm"></textarea>
                @error('description')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3">
                <button type="button" wire:click="$set('showModal', false)"
                    class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $isEditing ? 'Update Project' : 'Add Project' }}
                </button>
            </div>
        </form>
    </x-slot>
</x-modal.dialog>
