<div data-task-id="{{ $task->id }}"
    data-task-date="{{ Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, $day['day'])->format('Y-m-d') }}"
    draggable="true"
    class="calendar-task-item group p-1.5 text-xs rounded-md cursor-pointer transition-all border 
            {{ $task->is_done ?
    'opacity-70 dark:opacity-50 border-slate-300/30 dark:border-slate-700/50' :
    'hover:shadow-md dark:hover:shadow-lg dark:hover:shadow-black/30 border-slate-300/50 dark:border-slate-700' }}" style="background-color: {{ $task->is_done ?
    'rgba(var(--color-slate-200), 0.1)' :
    $task->category->color }}{{ $task->is_done ? '15' : '20' }};"
    onclick="if (!event.target.closest('.no-click')) { window.Livewire.dispatch('openEditTaskModal', { taskId: {{ $task->id }} }); }">

    <!-- Drag Handle -->
    <div class="calendar-drag-handle no-click absolute top-0.5 right-0.5 opacity-0 group-hover:opacity-100 transition-opacity cursor-move z-10"
        onclick="event.stopPropagation()">
        <svg class="w-3 h-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300" fill="currentColor"
            viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
            </path>
        </svg>
    </div>

    <!-- Top Row: Priority + Status -->
    <div class="flex items-center justify-between mb-1 space-x-1">
        <!-- Priority Badge -->
        <span
            class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] uppercase tracking-wide font-semibold
                    {{ $task->priority_level === 4 ? 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300' : '' }}
                    {{ $task->priority_level === 3 ? 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-300' : '' }}
                    {{ $task->priority_level === 2 ? 'bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300' : '' }}
                    {{ $task->priority_level === 1 ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300' : '' }}">
            {{ substr($task->priority_text, 0, 3) }}
        </span>

        <!-- Status Indicator -->
        @if($task->is_done)
            <span class="w-4 h-4 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center no-click">
                <svg class="w-2.5 h-2.5 text-green-700 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </span>
        @endif
    </div>

    <!-- Task Title -->
    <div
        class="font-medium truncate {{ $task->is_done ? 'line-through text-slate-500 dark:text-slate-500' : 'text-slate-900 dark:text-slate-100' }} group-hover:text-opacity-100">
        {{ $task->title }}
    </div>

    <!-- Bottom Row: Labels + Assignees -->
    <div class="flex items-center justify-between mt-1.5 no-click" onclick="event.stopPropagation()">
        <!-- Labels (show up to 2) -->
        @if($task->labels->count() > 0)
            <div class="flex space-x-1 overflow-hidden flex-shrink max-w-[60%]">
                @foreach($task->labels->take(2) as $label)
                    <div class="w-2 h-2 rounded-full flex-shrink-0 ring-1 ring-white/30 dark:ring-black/30 shadow-sm"
                        style="background-color: {{ $label->color }};">
                    </div>
                @endforeach
                @if($task->labels->count() > 2)
                    <span class="text-[9px] text-slate-500 dark:text-slate-400">
                        +{{ $task->labels->count() - 2 }}
                    </span>
                @endif
            </div>
        @endif

        <!-- Assignees (show up to 2) -->
        @if($task->users->count() > 0)
            <div class="flex -space-x-1 overflow-hidden">
                @foreach($task->users->take(2) as $user)
                    <div
                        class="w-4 h-4 rounded-full bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-900 flex items-center justify-center text-[8px] uppercase text-slate-700 dark:text-slate-200 shadow-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endforeach
                @if($task->users->count() > 2)
                    <div
                        class="w-4 h-4 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-900 flex items-center justify-center text-[8px] text-slate-500 dark:text-slate-400 shadow-sm">
                        +{{ $task->users->count() - 2 }}
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Time indicator if available -->
    @if($task->deadline && \Carbon\Carbon::parse($task->deadline)->format('H:i') !== '00:00')
        <div class="mt-1 text-[9px] text-slate-500 dark:text-slate-500 flex items-center no-click"
            onclick="event.stopPropagation()">
            <svg class="w-2.5 h-2.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ \Carbon\Carbon::parse($task->deadline)->format('H:i') }}
        </div>
    @endif
</div>