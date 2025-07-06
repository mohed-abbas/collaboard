<!-- Tasks Container -->
<div class="my-2 max-h-[calc(100vh-16rem)] max-w-sm">
    <!-- Task Card -->
    <div wire:click="$dispatch('openEditTaskModal', { taskId: {{ $task->id }} })"
        class="group p-4 rounded-lg border cursor-pointer transition-all duration-200
                                {{ $task->is_done == 1 ? 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-white dark:hover:bg-slate-700 hover:border-blue-300 dark:hover:border-blue-500' }}">

        <!-- Task Labels -->
        @if($task->labels->count() > 0)
        <div class="flex flex-wrap gap-1 mb-3">
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
                {{ Str::limit($task->title, 60) }}
            </h3>

            <!-- Task Completion Checkbox -->
            <div class="flex-shrink-0 ml-3">
                <input type="checkbox" wire:click.stop="$dispatch('toggleTaskDone', {taskId: {{ $task->id }}})"
                    {{ $task->is_done ? 'checked' : '' }}
                    class="w-4 h-4 text-green-600 bg-white dark:bg-slate-600 border-slate-300 dark:border-slate-500 rounded focus:ring-green-500 dark:focus:ring-green-400">
            </div>
        </div>

        <!-- Task Description -->
        @if($task->description)
        <p
            class="text-sm text-slate-600 dark:text-slate-400 mb-3 {{ $task->is_done ? 'line-through opacity-75' : '' }}">
            {{ Str::limit($task->description, 80) }}
        </p>
        @endif

        <!-- Task Meta -->
        <div class="flex items-center justify-between text-xs">
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

                <!-- Team Size -->
                @if($task->users->count() > 1)
                <span
                    class="flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded font-medium">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ $task->users->count() }}
                </span>
                @endif
            </div>

            <!-- Deadline -->
            @if($task->deadline)
            <div
                class="flex items-center gap-1 {{ $task->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-slate-500 dark:text-slate-400' }}">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $task->deadline->format('j M') }}</span>

                @if($task->isOverdue())
                <span class="px-1 py-0.5 bg-red-500 text-white text-[10px] font-bold rounded">
                    {{ $task->getStatusAttribute() }}
                </span>
                @endif

            </div>
            @endif
        </div>
    </div>
</div>