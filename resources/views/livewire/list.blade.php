{{-- filepath: resources/views/livewire/board-list.blade.php --}}
<div>
    <input
        class="search-bar rounded px-4 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4"
        type="text" placeholder="Search tasks..." wire:model="searchTerm" wire:change="filterBySearchTerm" />

    <select name="filter-category" id="filter-category" class="mb-4 p-2 border rounded" wire:model="selectedCategory"
        wire:change="filterByCategory">
        <option value="all">All Categories</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" class="text-gray-700 hover:bg-gray-100 ">
                {{ $category->title }}
            </option>
        @endforeach
    </select>

        <label class="text-gray-700 mr-2 font-medium select-none" for="show-pending-only">
            Show Pending Tasks Only
        </label>
        <input
            id="show-pending-only"
            type="checkbox"
            wire:model="showPendingOnly"
            wire:change="filterByIsDone"
            class="form-checkbox h-5 w-5 ml-2 text-blue-600 transition duration-150 ease-in-out border-gray-300 rounded focus:ring-2 focus:ring-blue-400"
        />

    <table class="min-w-full bg-white rounded shadow w-full">
        <thead>
            <tr>
                <th class="text-left px-4 py-2">Task</th>
                <th class="text-left px-4 py-2">Description</th>
                <th class="text-left px-4 py-2">Category</th>
                <th class="text-left px-4 py-2">Status</th>
                <th class="text-left px-4 py-2">Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
                    class="cursor-pointer hover:bg-blue-100">
                    <td class="border px-4 py-2">{{ $task->title }}</td>
                    <td class="border px-4 py-2">{{ $task->description }}</td>
                    <td class="border px-4 py-2">{{ $task->category->title }}</td>
                    <td class="border px-4 py-2">
                        {{ $task->is_done ? 'Done' : 'Pending' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:i') : '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button wire:click="$dispatch('openCreateTaskModal')"
        class="px-3 py-2 w-full border rounded hover:bg-gray-100 transition-colors duration-150 cursor-pointer mt-4">
        + Add Task
    </button>
</div>

