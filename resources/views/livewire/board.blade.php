<div>
    <h1 class="text-2xl font-bold mb-4">
        {{ $project->name }}
    </h1>
    <!-- Create category button in the board -->
    <button wire:click="openCreateCategoryModal" class="mb-4 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
        + Create Category
    </button>
    <!-- Categories -->
    <div class="flex flex-row gap-4 overflow-x-auto items-start py-4 px-2">
        @foreach ($categories as $category)
            <div class="flex flex-col min-w-[280px] bg-white rounded-lg shadow px-2 py-3">
                <h2 class="text-lg font-semibold mb-2">{{ $category->title }}</h2>
                <div class="flex flex-col gap-2">
                    @forelse($category->tasks as $task)
                        <div class="bg-gray-100 rounded-lg p-3">
                            <h3 class="font-medium">{{ $task->title }}</h3>
                            @if ($task->is_done == 1)
                                <div class="text-green-600">Done</div>
                            @endif
                            <p class="text-sm text-gray-600">{{ $task->description }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs text-gray-500">
                                {{ $task->deadline ? 'Deadline : ' . \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:m') : '' }}</span>
                                <button wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }}})"
                                    class="text-blue-500 hover:underline">
                                    Edit
                                </button>
                            </div>
                        </div>
                        {{-- Create task button at the end of the task list --}}
                    @empty
                        <div class="text-gray-400 italic text-center p-2">No tasks</div>
                    @endforelse
                    <button wire:click="$dispatch('openCreateTaskModal', {categoryId: {{ $category->id }}})"
                        class="mt-2 px-3 py-1 bg-gray-100 text-black rounded hover:bg-green-500 cursor-pointer hover:text-white">
                        Add Task
                    </button>
                </div>
            </div>
        @endforeach

    </div>
    <!-- Category Modal -->
    @include('livewire.category-modal')
    {{-- Task Modal --}}
    <livewire:task-manager />
</div>
