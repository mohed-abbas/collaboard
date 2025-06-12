<div>
    <x-modal.dialog wire:model="showCategoryModal">
        <x-slot name="title">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $isEditing ? 'Edit Category' : 'Create New Category' }}
            </h3>
        </x-slot>

        <x-slot name="newContent">
            <form wire:submit.prevent="{{ $isEditing ? 'updateCategory' : 'createCategory' }}" class="space-y-6">

                <!-- Category Title -->
                <div class="space-y-1">
                    <label for="categoryTitle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Category Title
                    </label>
                    <input id="categoryTitle" type="text" wire:model="categoryTitle" placeholder="Enter category title"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 sm:text-sm" />
                    @error('title')<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $isEditing ? 'Update category' : 'Add category' }}
                    </button>
                </div>
            </form>
        </x-slot>
    </x-modal.dialog>
</div>