<!-- Tasks Container -->
<div class="my-2 max-h-[calc(100vh-16rem)] max-w-sm">
    <!-- Task Card -->
    <div data-task-id="{{ $task->id }}" data-category-id="{{ $task->category_id }}" draggable="true"
        class="task-item group p-4 rounded-lg border cursor-pointer transition-all duration-200 mb-3
                {{ $task->is_done == 1 ? 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-white dark:hover:bg-slate-700 hover:border-blue-300 dark:hover:border-blue-500' }}"
        onclick="if (!event.target.closest('.no-click')) { window.Livewire.dispatch('openEditTaskModal', { taskId: {{ $task->id }} }); }">

        <!-- Drag Handle -->
        <div class="drag-handle no-click absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity cursor-move z-10"
            onclick="event.stopPropagation()">
        </div>

        <!-- Task Labels -->
        @if($task->labels->count() > 0)
        <div class="flex flex-wrap gap-1 mb-3 no-click" onclick="event.stopPropagation()">
            @foreach($task->labels as $label)
            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-white rounded"
                style="background-color: {{ $label->color }}">
                {{ $label->name }}
            </span>
            @endforeach
        </div>
        @endif

        <!-- Task Header -->
        <div class="flex items-start justify-between mb-2">
            <h3 class="font-medium text-slate-900 dark:text-white {{ $task->is_done ? 'line-through opacity-75' : '' }}
                       {{ $task->isOverdue() ? 'text-red-600 dark:text-red-400' : '' }}">
                {{ Str::limit($task->title, 40) }}
            </h3>

            <!-- Task Completion Checkbox -->
            <div class="flex-shrink-0 ml-3 no-click">
                <input type="checkbox" wire:click.stop="$dispatch('toggleTaskDone', {taskId: {{ $task->id }}})"
                    {{ $task->is_done ? 'checked' : '' }} onclick="event.stopPropagation()"
                    class="w-4 h-4 text-green-600 bg-white dark:bg-slate-600 border-slate-300 dark:border-slate-500 rounded-full focus:ring-green-500 dark:focus:ring-green-400">
            </div>
        </div>

        <!-- Task Description -->
        @if($task->description)
        <p
            class="text-sm text-slate-600 dark:text-slate-400 mb-3 {{ $task->is_done ? 'line-through opacity-75' : '' }}">
            {{ Str::limit($task->description, 60) }}
        </p>
        @endif

        <!-- Task Meta -->
        <div class="flex items-center justify-between text-xs no-click" onclick="event.stopPropagation()">
            <div class="flex items-center gap-2">
                <!-- Priority Badge -->
                @if($task->priority_level > 1)
                <span
                    class="px-2 py-1 rounded font-medium
                             {{ $task->priority_level === 4 ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}
                             {{ $task->priority_level === 3 ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}
                             {{ $task->priority_level === 2 ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}">
                    {{ $task->priority_text }}
                </span>
                @endif

                <!-- Deadline -->
                @if($task->deadline)
                <span class="text-slate-500 dark:text-slate-400
                            {{ $task->isOverdue() ? 'text-red-600 dark:text-red-400 font-medium' : '' }}">
                    {{ $task->deadline->format('M j') }}
                </span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <!-- Assigned Users Count -->
                @if($task->users->count() > 0)
                <span class="flex items-center text-slate-500 dark:text-slate-400">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ $task->users->count() }}
                </span>
                @endif
            </div>
        </div>
    </div>
</div>