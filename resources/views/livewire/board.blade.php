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
                        {{-- Task card --}}
                        <div wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
                            class="task rounded-lg p-3 cursor-pointer transition-colors duration-150
                                {{ $task->is_done == 1 ? 'bg-green-100 hover:bg-green-200 line-through opacity-70' : 'bg-gray-100 hover:bg-blue-100' }}">
                            <div class="flex items-center justify-between">
                                {{-- Task Title --}}
                                <h3 class="font-medium">{{ $task->title }}</h3>
                                {{-- Checkbox isDone --}}
                                <label class="mt-2 inline-flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox"
                                        wire:click.stop="$dispatch('toggleTaskDone', {taskId: {{ $task->id }}})"
                                        {{ $task->is_done ? 'checked' : '' }}
                                        class="form-checkbox h-5 w-5 text-green-600 transition duration-150 rounded checked:bg-green-600">
                                </label>
                            </div>
                            <p class="text-sm text-gray-600 ">{{ $task->description }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs text-gray-500">
                                    {{ $task->deadline ? 'Deadline : ' . \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:i') : '' }}
                                </span>
                            </div>
                        </div>
                        {{-- End Task Card --}}
                    @empty
                        <div class="text-gray-400 italic text-center p-2">No tasks</div>
                    @endforelse
                    <button wire:click="$dispatch('openCreateTaskModal', {categoryId: {{ $category->id }}})"
                        class="mt-2 px-3 py-1 border text-black rounded cursor-pointer hover:bg-gray-100 transition-colors duration-150">
                        + Add Task
                    </button>
                </div>
            </div>
        @endforeach

    </div>
    <!-- Category Modal -->
    @include('livewire.category-modal')
    {{-- Task Modal --}}
    <livewire:task-manager :categories="$categories" />
</div>
