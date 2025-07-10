<div class="bg-white dark:bg-slate-900 rounded-lg shadow dark:shadow-slate-800/40">
    <!-- Calendar Header -->
    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center space-x-2">
            <button wire:click="previousMonth"
                class="p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                {{ Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, 1)->format('F Y') }}
            </h2>
            <button wire:click="nextMonth"
                class="p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <button wire:click="currentMonth"
                class="px-3 py-1 ml-2 text-sm bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 rounded hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                Today
            </button>
        </div>

        <!-- Filter indicators -->
        <div class="flex items-center space-x-3">
            @if (!empty($searchTerm) || $selectedCategory !== '' || $showPendingOnly || !empty($selectedLabels))
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="mr-1">Filters active:</span>
                <button wire:click="clearFilters"
                    class="text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-300 hover:underline">
                    Clear all
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Week day headers -->
    <div class="grid grid-cols-7 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800">
        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dayName)
        <div class="px-2 py-2 text-sm font-medium text-center text-slate-500 dark:text-slate-400">
            {{ $dayName }}
        </div>
        @endforeach
    </div>

    <!-- Calendar days -->
    <div class="overflow-hidden">
        @foreach($calendarWeeks as $week)
        <div class="grid grid-cols-7 border-b last:border-b-0 border-slate-200 dark:border-slate-800">
            @foreach($week as $day)
            <div
                class="min-h-[120px] border-r last:border-r-0 border-slate-200 dark:border-slate-800 p-1 
                                                                                                                {{ $day['isCurrentMonth'] ? 'dark:bg-slate-900' : 'bg-slate-50 dark:bg-slate-900/70' }} 
                                                                                                                {{ Carbon\Carbon::now()->format('Y-m-d') === Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, $day['day'])->format('Y-m-d') && $day['isCurrentMonth'] ? 'bg-blue-50/40 dark:bg-blue-950/50 ring-1 ring-inset ring-blue-500/20 dark:ring-blue-400/20' : '' }}
                                                                                                                relative">

                <!-- Date indicator -->
                <div class="flex justify-between mb-1">
                    <span
                        class="text-sm {{ $day['isCurrentMonth'] ? 'font-medium text-slate-800 dark:text-slate-300' : 'text-slate-400 dark:text-slate-600' }}
                                                                                                                        {{ Carbon\Carbon::now()->format('Y-m-d') === Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, $day['day'])->format('Y-m-d') && $day['isCurrentMonth'] ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                        {{ $day['day'] }}
                        @if(isset($day['tasks']) && count($day['tasks']) > 1)
                        <span
                            class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-[10px] font-semibold">
                            +{{ count($day['tasks']) }}
                        </span>
                        @endif
                    </span>

                    <!-- Add task button for this date -->
                    @if($day['isCurrentMonth'])
                    <button
                        wire:click="$dispatch('openCreateTaskModal', {categoryId: null, deadline: '{{ Carbon\Carbon::createFromDate($calendarYear, $calendarMonth, $day['day'])->format('Y-m-d\TH:i') }}'})"
                        class="text-slate-400 dark:text-slate-500 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    @endif
                </div>

                <!-- Tasks for this date -->
                <div class="space-y-1.5 overflow-y-auto max-h-[90px] scrollbar-hide">
                    @foreach($day['tasks'] as $task)
                    <div wire:click="$dispatch('openEditTaskModal', {taskId: {{ $task->id }}})"
                        class="p-1.5 text-xs rounded-md cursor-pointer transition-all group border 
                                                                                                                                                                                                                            {{ $task->is_done ?
                                'opacity-70 dark:opacity-50 border-slate-300/30 dark:border-slate-700/50' :
                                'hover:shadow-md dark:hover:shadow-lg dark:hover:shadow-black/30 border-slate-300/50 dark:border-slate-700' }}" style="background-color: {{ $task->is_done ?
                                'rgba(var(--color-slate-200), 0.1)' :
                                $task->category->color }}{{ $task->is_done ? '15' : '20' }};">

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
                            <span
                                class="w-4 h-4 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-green-700 dark:text-green-400" fill="currentColor"
                                    viewBox="0 0 20 20">
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
                        <div class="flex items-center justify-between mt-1.5">
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
                        <div class="mt-1 text-[9px] text-slate-500 dark:text-slate-500 flex items-center">
                            <svg class="w-2.5 h-2.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($task->deadline)->format('H:i') }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>