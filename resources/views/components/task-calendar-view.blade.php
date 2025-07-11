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
            <button wire:click="goToToday"
                class="px-3 py-1 ml-2 text-sm bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 rounded hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                Aujourd'hui
            </button>
        </div>

        <!-- Filter indicators -->
        <div class="flex items-center space-x-3">
            @if (!empty($searchTerm) || $selectedCategory !== '' || $showPendingOnly || !empty($selectedLabels))
                <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                    <span class="mr-1">Filtres actifs:</span>
                    <button wire:click="clearFilters"
                        class="text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-300 hover:underline">
                        Effacer tout
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Week day headers -->
    <div class="grid grid-cols-7 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800">
        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $dayName)
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
                    @php
                        $dayDate = Carbon\Carbon::createFromDate($day['year'], $day['month'], $day['day']);
                        $isToday = $dayDate->isToday();
                    @endphp
                    <div class="calendar-day group min-h-[120px] border-r last:border-r-0 border-slate-200 dark:border-slate-800 p-1 
                                                       {{ $day['isCurrentMonth'] ? 'dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/50' : 'bg-slate-50 dark:bg-slate-900/70' }} 
                                                       {{ $isToday && $day['isCurrentMonth'] ? 'bg-blue-50/40 dark:bg-blue-950/50 ring-1 ring-inset ring-blue-500/20 dark:ring-blue-400/20' : '' }}
                                                       relative transition-colors" data-date="{{ $day['date'] }}">

                        <!-- Date indicator -->
                        <div class="calendar-day-content">
                            <div class="flex justify-between mb-1">
                                <span
                                    class="text-sm {{ $day['isCurrentMonth'] ? 'font-medium text-slate-800 dark:text-slate-300' : 'text-slate-400 dark:text-slate-600' }}
                                                                    {{ $isToday && $day['isCurrentMonth'] ? 'text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                                    {{ $day['day'] }}
                                    @if(isset($day['tasks']) && count($day['tasks']) > 3)
                                        <span
                                            class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-[10px] font-semibold">
                                            +{{ count($day['tasks']) - 3 }}
                                        </span>
                                    @endif
                                </span>

                                <!-- Add task button for this date -->
                                @if($day['isCurrentMonth'])
                                    <button wire:click="createTaskForDate('{{ $day['date'] }}')"
                                        class="opacity-0 group-hover:opacity-100 p-1 rounded bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <!-- Tasks for this date -->
                            <div class="space-y-1.5 overflow-y-auto max-h-[90px] scrollbar-hide">
                                @if(isset($day['tasks']))
                                    @foreach(array_slice($day['tasks'], 0, 3) as $task)
                                        @include('components.calendar-task-item', [
                                            'task' => $task,
                                            'calendarYear' => $calendarYear,
                                            'calendarMonth' => $calendarMonth,
                                            'day' => $day
                                        ])
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>