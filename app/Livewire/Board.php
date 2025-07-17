<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Category;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Board extends Component
{
    public $project;
    public $categories;
    public $labels;
    public $filteredTasks;
    public $viewMode = 'board'; // board, list, or calendar

    // Filtering properties
    public $selectedCategory = '';
    public $searchTerm = '';
    public $showPendingOnly = false;
    public $selectedLabels = []; // Array of selected label IDs

    // Sorting properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Category management
    public $showCategoryModal = false;
    public $categoryId;
    public $categoryTitle = '';
    public $categoryColor = '#060436';
    public $isEditingCategory = false;
    public $isEditing = false;

    // Calendar view properties
    public $calendarMonth;
    public $calendarYear;
    public $calendarView = 'month'; // month, week, day
    public $calendarDays = [];
    public $calendarWeeks = [];

    // Drag-and-drop properties
    public $draggedTask = null; // Task being dragged
    public $draggedCategory = null; // Category being dragged


    protected $messages = [
        'categoryTitle.required' => 'Le titre de la catégorie est obligatoire.',
        'categoryColor.required' => 'La couleur de la catégorie est obligatoire.',
        'categoryTitle.max' => 'Le titre de la catégorie ne peut pas dépasser 255 caractères.',
        'categoryColor.regex' => 'La couleur de la catégorie doit être un code hexadécimal valide.',
        'searchTerm.max' => 'Le terme de recherche ne peut pas dépasser 255 caractères.',
        'selectedLabels.array' => 'Les étiquettes sélectionnées doivent être un tableau.',
        'selectedLabels.*.exists' => 'Une ou plusieurs étiquettes sélectionnées n\'existent pas.',
        'selectedCategory.exists' => 'La catégorie sélectionnée n\'existe pas.',
        'sortBy.in' => 'Le critère de tri sélectionné n\'est pas valide.',
        'sortDirection.in' => 'La direction de tri sélectionnée n\'est pas valide.',
        'categoryTitle.title' => 'Le titre de la catégorie ne peut pas être "Terminé" car c\'est une catégorie système.',
    ];

    public function mount($project)
    {
        $this->loadProject($project);
        $this->viewMode = session('board_view_mode', 'board'); // Default to 'board' view mode
        $this->applyFilters();

        // If calendar view, generate the calendar data
        if ($this->viewMode === 'calendar') {
            // Initialize calendar with current month/year
            $now = Carbon::now();
            $this->calendarMonth = $now->month;
            $this->calendarYear = $now->year;
        }
    }

    public function updatedViewMode()
    {
        session(['board_view_mode' => $this->viewMode]);

        // Generate calendar data when switching to calendar view
        if ($this->viewMode === 'calendar') {
            if (!$this->calendarMonth || !$this->calendarYear) {
                $now = Carbon::now();
                $this->calendarMonth = $now->month;
                $this->calendarYear = $now->year;
            }
            $this->generateCalendarData();
        }

        $this->applyFilters();
    }

    /**
     * Generate calendar data based on the selected month/year
     */
    public function generateCalendarData()
    {
        $this->calendarDays = [];
        $this->calendarWeeks = [];

        $date = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1);
        $daysInMonth = $date->daysInMonth;

        // Get the first day of the month
        $firstDay = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1);
        // Get day of week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        $dayOfWeek = $firstDay->dayOfWeek;

        // Adjust for Monday as first day of week
        $dayOfWeek = $dayOfWeek == 0 ? 6 : $dayOfWeek - 1;

        // Calculate previous month's spillover days
        $previousMonth = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1)->subMonth();
        $daysInPreviousMonth = $previousMonth->daysInMonth;

        // Create calendar grid with previous month spillover
        $day = 1;
        $nextMonthDay = 1;

        // Build 6-week calendar (42 days) to ensure consistent height
        for ($week = 0; $week < 6; $week++) {
            $this->calendarWeeks[$week] = [];

            for ($i = 0; $i < 7; $i++) {
                if ($week === 0 && $i < $dayOfWeek) {
                    // Previous month days
                    $calendarDay = [
                        'day' => $daysInPreviousMonth - ($dayOfWeek - $i) + 1,
                        'month' => $previousMonth->month,
                        'year' => $previousMonth->year,
                        'isCurrentMonth' => false,
                        'date' => Carbon::createFromDate($previousMonth->year, $previousMonth->month, $daysInPreviousMonth - ($dayOfWeek - $i) + 1)->format('Y-m-d'),
                        'tasks' => []
                    ];
                } elseif ($day > $daysInMonth) {
                    // Next month days
                    $nextMonth = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1)->addMonth();
                    $calendarDay = [
                        'day' => $nextMonthDay,
                        'month' => $nextMonth->month,
                        'year' => $nextMonth->year,
                        'isCurrentMonth' => false,
                        'date' => Carbon::createFromDate($nextMonth->year, $nextMonth->month, $nextMonthDay)->format('Y-m-d'),
                        'tasks' => []
                    ];
                    $nextMonthDay++;
                } else {
                    // Current month days
                    $calendarDay = [
                        'day' => $day,
                        'month' => $this->calendarMonth,
                        'year' => $this->calendarYear,
                        'isCurrentMonth' => true,
                        'date' => Carbon::createFromDate($this->calendarYear, $this->calendarMonth, $day)->format('Y-m-d'),
                        'tasks' => []
                    ];
                    $day++;
                }

                // Add day to the calendar
                $this->calendarWeeks[$week][$i] = $calendarDay;
                $this->calendarDays[] = $calendarDay;
            }
        }

        // Assign tasks to calendar days based on deadline
        $this->assignTasksToCalendar();
    }

    /**
     * Assign tasks to calendar days based on task deadline
     */
    private function assignTasksToCalendar()
    {
        // Clear existing tasks from calendar days first
        foreach ($this->calendarWeeks as $weekIndex => $week) {
            foreach ($week as $dayIndex => $day) {
                $this->calendarWeeks[$weekIndex][$dayIndex]['tasks'] = [];
            }
        }

        // Reset all calendar days tasks arrays
        foreach ($this->calendarDays as $index => $day) {
            $this->calendarDays[$index]['tasks'] = [];
        }

        // Then assign current tasks - with safety checks
        foreach ($this->filteredTasks as $task) {
            // Skip any null or invalid tasks
            if (!$task || !$task->exists || empty($task->deadline)) {
                continue;
            }

            try {
                $deadline = Carbon::parse($task->deadline)->format('Y-m-d');

                // Find the matching calendar day
                foreach ($this->calendarWeeks as $weekIndex => $week) {
                    foreach ($week as $dayIndex => $day) {
                        if ($day['date'] === $deadline) {
                            $this->calendarWeeks[$weekIndex][$dayIndex]['tasks'][] = $task;
                        }
                    }
                }

                // Also update calendarDays for consistency
                foreach ($this->calendarDays as $index => $day) {
                    if ($day['date'] === $deadline) {
                        $this->calendarDays[$index]['tasks'][] = $task;
                    }
                }
            } catch (\Exception $e) {
                // Log any parsing errors but don't break the calendar
                \Illuminate\Support\Facades\Log::error('Calendar task assignment error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Change calendar to previous month
     */
    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1)->subMonth();
        $this->calendarMonth = $date->month;
        $this->calendarYear = $date->year;
        $this->generateCalendarData();
    }

    /**
     * Change calendar to next month
     */
    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->calendarYear, $this->calendarMonth, 1)->addMonth();
        $this->calendarMonth = $date->month;
        $this->calendarYear = $date->year;
        $this->generateCalendarData();
    }

    /**
     * Set calendar to current month
     */
    public function currentMonth()
    {
        $now = Carbon::now();
        $this->calendarMonth = $now->month;
        $this->calendarYear = $now->year;
        $this->generateCalendarData();
    }


    // In your Board component where you load the project
    public function syncAllTasksStatus()
    {
        foreach ($this->project->tasks as $task) {
            $isInDoneCategory = $task->category->title === 'Terminé' && $task->category->is_system;

            if ($task->is_done !== $isInDoneCategory) {
                $task->update(['is_done' => $isInDoneCategory]);
            }
        }
    }

    public function loadProject($project)
    {
        $this->project = Project::findOrFail(is_object($project) ? $project->id : $project);
        $this->categories = $this->project->categories()->with([
            'tasks' => function ($query) {
                $query->with(['labels', 'users', 'category']);
            }
        ])->orderBy('position', 'asc')->get();
        $this->labels = $this->project->labels()->orderBy('name')->get();
        $this->syncAllTasksStatus();
    }

    // Auto-trigger filtering when properties change
    public function updatedSelectedCategory()
    {
        $this->applyFilters();
    }

    public function updatedSearchTerm()
    {
        $this->applyFilters();
    }

    public function updatedShowPendingOnly()
    {
        $this->applyFilters();
    }

    public function updatedSelectedLabels()
    {
        $this->applyFilters();
    }

    public function applyFilters()
    {
        $query = $this->project->tasks()->with(['category', 'labels', 'users']);

        // Apply category filter
        if ($this->selectedCategory !== '' && $this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply search term filter
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('tasks.title', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('tasks.description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply pending only filter
        if ($this->showPendingOnly) {
            $query->where('is_done', false);
        }

        // Apply label filters
        if (!empty($this->selectedLabels)) {
            $query->whereHas('labels', function ($q) {
                $q->whereIn('labels.id', $this->selectedLabels);
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'title':
                $query->orderBy('tasks.title', $this->sortDirection);
                break;
            case 'deadline':
                $query->orderBy('deadline', $this->sortDirection);
                break;
            case 'priority':
                $query->orderBy('priority_level', $this->sortDirection);
                break;
            case 'status':
                $query->orderBy('is_done', $this->sortDirection);
                break;
            default:
                $query->orderBy('created_at', $this->sortDirection);
        }

        $this->filteredTasks = $query->get();

        // Regenerate calendar if in calendar view
        if ($this->viewMode === 'calendar') {
            $this->generateCalendarData();
        }
    }

    public function sortTasks($sortBy)
    {
        if ($this->sortBy === $sortBy) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortBy;
            $this->sortDirection = 'asc';
        }
        $this->applyFilters();
    }

    public function toggleLabel($labelId)
    {
        if (in_array($labelId, $this->selectedLabels)) {
            $this->selectedLabels = array_diff($this->selectedLabels, [$labelId]);
        } else {
            $this->selectedLabels[] = $labelId;
        }
        $this->applyFilters();
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->searchTerm = '';
        $this->showPendingOnly = false;
        $this->selectedLabels = [];
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $this->applyFilters();
    }

    public function clearLabelFilters()
    {
        $this->selectedLabels = [];
        $this->applyFilters();
    }

    // Category Management Methods
    public function openCreateCategoryModal()
    {
        $this->resetCategoryForm();
        $this->isEditingCategory = false;
        $this->showCategoryModal = true;
    }

    public function openEditCategoryModal($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $this->categoryId = $categoryId;
            $this->categoryTitle = $category->title;
            $this->categoryColor = $category->color;
            $this->isEditingCategory = true;
            $this->showCategoryModal = true;
        }
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryTitle' => 'required|string|max:255',
            'categoryColor' => 'required|string',
        ]);

        if ($this->isEditingCategory) {
            $category = Category::find($this->categoryId);
            if ($category->is_system && (strtoupper($category->title) === 'TERMINÉ' || strtoupper($category->title) === 'À FAIRE')) {
                $this->addError('categoryTitle', $this->messages['categoryTitle.title']);
                return;
            }

            if ($category) {
                $category->update([
                    'title' => $this->categoryTitle,
                    'color' => $this->categoryColor,
                ]);
                session()->flash('success', 'Catégorie mise à jour avec succès.');
            }
        } else {
            Category::create([
                'title' => $this->categoryTitle,
                'color' => $this->categoryColor,
                'project_id' => $this->project->id,
                'position' => $this->categories->count() + 1, // Position for drag-and-drop sorting
            ]);
            session()->flash('success', 'Catégorie créée avec succès.');
        }

        $this->resetCategoryForm();
        $this->projectUpdated();
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category && $category->tasks()->count() === 0) {
            $category->delete();
            session()->flash('success', 'Catégorie supprimée avec succès.');
            $this->projectUpdated();
        } else {
            session()->flash('error', 'Impossible de supprimer une catégorie contenant des tâches.');
        }
    }

    private function resetCategoryForm()
    {
        $this->categoryId = null;
        $this->categoryTitle = '';
        $this->categoryColor = '#060436'; // Default color
        $this->showCategoryModal = false;
        $this->resetErrorBag();
    }

    #[On('projectUpdated')]
    public function projectUpdated()
    {

        $this->loadProject(project: $this->project->id);
        $this->applyFilters();
    }

    #[On('labelUpdated')]
    public function labelUpdated()
    {
        $this->labels = $this->project->labels()->orderBy('name')->get();
        $this->applyFilters();
    }

    /**
     * Handle task drag and drop between categories
     */
    #[On('taskMoved')]
    public function handleTaskMove($taskId, $newCategoryId, $newPosition = null)
    {
        try {
            $task = Task::findOrFail($taskId);
            $newCategory = Category::findOrFail($newCategoryId);

            // Store old category for logging
            $oldCategoryId = $task->category_id;

            // Get current position in new category
            if ($newPosition === null) {
                $maxPosition = Task::where('category_id', $newCategoryId)->max('position') ?? 0;
                $newPosition = $maxPosition + 1;
            }

            // Update task category and position
            $task->update([
                'category_id' => $newCategoryId,
                'position' => $newPosition
            ]);


            // Reorder tasks in both categories if they're different
            if ($oldCategoryId != $newCategoryId) {
                $this->reorderTasksInCategory($oldCategoryId);
                $this->reorderTasksInCategory($newCategoryId);
            }

            // Refresh the component data
            $this->loadProject($this->project->id);
            $this->applyFilters();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du déplacement de la tâche: ' . $e->getMessage());
        }
    }

    /**
     * Reorder tasks within a category
     */
    private function reorderTasksInCategory($categoryId)
    {
        $tasks = Task::where('category_id', $categoryId)
            ->orderBy('position')
            ->get();

        foreach ($tasks as $index => $task) {
            $newPosition = $index + 1;
            $task->update(['position' => $newPosition]);
        }
    }

    /**
     * Handle task date change from calendar drag and drop
     */
    #[On('taskDateMoved')]
    public function handleTaskDateMove($taskId, $newDate)
    {
        try {
            $task = Task::findOrFail($taskId);

            // Parse the new date
            $newDeadline = Carbon::parse($newDate);
            $oldDeadline = $task->deadline;

            // Update task deadline
            $task->update([
                'deadline' => $newDeadline
            ]);

            // Refresh the component data
            $this->loadProject($this->project->id);
            $this->applyFilters();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du changement de date: ' . $e->getMessage());
        }
    }

    /**
     * Handle creating a new task with a specific deadline from calendar
     */
    #[On('createTaskForDate')]
    public function createTaskForDate($date, $categoryId = null)
    {
        try {
            // Set default category if none provided - find "À faire" category first
            if (!$categoryId && $this->categories->count() > 0) {
                // Try to find "À faire" system category first
                $todoCategory = $this->categories->where('title', 'À faire')->where('is_system', true)->first();
                $categoryId = $todoCategory ? $todoCategory->id : $this->categories->first()->id;
            }

            $deadline = Carbon::parse($date);

            // Dispatch event to open task creation modal with pre-filled deadline
            $this->dispatch('openCreateTaskModal', $categoryId, $deadline->format('Y-m-d\TH:i'));

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création de la tâche.');
        }
    }

    /**
     * Go to today's date in calendar
     */
    public function goToToday()
    {
        $today = Carbon::today();
        $this->calendarYear = $today->year;
        $this->calendarMonth = $today->month;
        $this->generateCalendarData();
    }
    public function render()
    {
        return view('livewire.board');
    }
}