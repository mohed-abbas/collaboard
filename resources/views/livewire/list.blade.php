{{-- filepath: resources/views/livewire/board-list.blade.php --}}
<div>
    <table class="min-w-full bg-white rounded shadow w-full">
        <thead>
            <tr>
                <th class="text-left px-4 py-2">Task</th>
                <th class="text-left px-4 py-2">Description</th>
                <th class="text-left px-4 py-2">Category</th>
                <th class="text-left px-4 py-2">Status</th>
                <th class="text-left px-4 py-2">Deadline</th>
                <th class="text-left px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td class="border px-4 py-2">{{ $task->title }}</td>
                    <td class="border px-4 py-2">{{ $task->description }}</td>
                    <td class="border px-4 py-2">{{ $task->category->title }}</td>
                    <td class="border px-4 py-2">
                        {{ $task->is_done ? 'Done' : 'Pending' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:i') : '' }}
                    </td>
                    <td class="border px-4 py-2">
                        <button wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
                            class="text-blue-500 hover:underline cursor-pointer">Edit</button>
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
