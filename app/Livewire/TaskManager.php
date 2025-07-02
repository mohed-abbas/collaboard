<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    // Props from Board component
    public $categories = [];
    public $taskId;
    public $taskTitle = '';
    public $taskDescription = '';
    public $categoryId;
    public $taskDeadline;
    public $taskIsDone;
    public $task;
    public $taskUsers = [];
    public $isEditing = false;
    public $showModal = false;


    // Labels variables
    public $selectedLabels = []; // Array to hold selected label IDs
    public $availableLabels = []; // Array to hold available labels for the project


    protected $messages = [
        'taskTitle.required' => 'Le titre de la tâche est requis.',
        'taskDescription.string' => 'La description de la tâche doit être une chaîne de caractères.',
        'categoryId.required' => 'Veuillez sélectionner une catégorie pour la tâche.',
        'taskDeadline.required' => 'Veuillez définir une date limite pour la tâche.',
        'taskDeadline.date' => 'La date limite doit être une date valide.',
        'taskDeadline.after_or_equal' => 'La date limite doit être aujourd\'hui ou plus tard.',
    ];

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->loadLabels(); // Load available labels when component mounts
    }

    public function loadLabels()
    {
        // Get labels from the project (through categories)
        $project = collect($this->categories)->first()?->project;
        if ($project) {
            $this->availableLabels = $project->labels()->orderBy('name')->get();
        }
    }

    #[On('labelUpdated')]
    public function refreshLabels()
    {
        // Refresh the available labels from the database
        $this->loadLabels();
    }

    #[On('openCreateTaskModal')]
    public function openCreateTaskModal($categoryId)
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
        $this->categoryId = $categoryId;
        // Set default deadline to one day from now for new tasks
        $this->taskDeadline = now()->addDay()->format('Y-m-d\TH:i');
    }

    #[On('openEditTaskModal')]
    public function openEditTaskModal($taskId)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->showModal = true;
        $this->taskId = $taskId;
        // Load task data here if needed
        $this->task = Task::find($taskId);
        if ($this->task) {
            $this->taskTitle = $this->task->title;
            $this->taskDescription = $this->task->description;
            $this->categoryId = $this->task->category_id;
            // Format deadline for datetime-local input
            $this->taskDeadline = $this->task->deadline ?
                \Carbon\Carbon::parse($this->task->deadline)->format('Y-m-d\TH:i') :
                now()->addDay()->format('Y-m-d\TH:i');
            $this->taskIsDone = $this->task->is_done;
            // Load selected labels
            $this->selectedLabels = $this->task->labels->pluck('id')->toArray();
            $this->taskUsers = $this->task->users->toArray(); // Get array of user objects
        }
    }

    // Task : CRUD operations

    public function createTask()
    {
        // Prepare data for validation
        $this->prepareTaskDeadline();
        $this->validateTask();

        $task = Task::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'category_id' => $this->categoryId,
            'deadline' => $this->taskDeadline,
            'priority_level' => 1, // Default priority level
            'position' => 1,
            'is_done' => 0, // Set is_done explicitly
        ]);

        // Attach current user as creator
        $task->users()->attach(Auth::id(), ['is_creator' => true, 'created_at' => now()]);

        // Attach selected labels to the task
        if (!empty($this->selectedLabels)) {
            $task->labels()->attach($this->selectedLabels);
        }

        $this->dispatch('projectUpdated');
        session()->flash('success', 'Tâche créée avec succès.');
        // Reset form after creation
        $this->resetForm();
    }

    public function updateTask()
    {
        // Prepare data for validation
        $this->prepareTaskDeadline();
        $this->validateTask();

        $task = Task::find($this->taskId);
        if ($task) {
            $task->update([
                'title' => $this->taskTitle,
                'description' => $this->taskDescription,
                'category_id' => $this->categoryId,
                'deadline' => $this->taskDeadline,
                'is_done' => $this->taskIsDone,
            ]);
            // Sync labels (this will remove old labels and add new ones)
            $task->labels()->sync($this->selectedLabels);
        }
        $this->dispatch('projectUpdated');
        session()->flash('success', 'Tâche mise à jour avec succès.');
        $this->resetForm();
    }

    #[On('deleteTask')]
    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
            $this->resetForm();
            $this->dispatch('projectUpdated');
            $this->isEditing = false;
            session()->flash('success', 'Tâche supprimée avec succès.');
        }
    }

    #[On('toggleTaskDone')]
    public function toggleTaskDone($taskId)
    {
        // Toggle the is_done status of the task
        $task = Task::find($taskId);

        if ($task) {
            $task->is_done = !$task->is_done;
            $task->save();
            $this->dispatch('projectUpdated');
        }
    }

    // End CRUD operations

    private function prepareTaskDeadline()
    {
        // If deadline is empty or null, set it to one day from now
        if (empty($this->taskDeadline)) {
            $this->taskDeadline = now()->addDay()->format('Y-m-d\TH:i');
        }
    }

    public function validateTask()
    {
        $rules = [
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'categoryId' => 'required|exists:categories,id',
            'taskDeadline' => 'required|date',
            'selectedLabels' => 'nullable|array', // Validate selected labels as an array
            'selectedLabels.*' => 'exists:labels,id', // Each label must exist in
        ];

        // Only apply the after_or_equal validation for new tasks
        if (!$this->isEditing) {
            $rules['taskDeadline'] = 'required|date|after_or_equal:today';
        }

        $this->validate($rules);
    }

    public function resetForm()
    {
        $this->taskId = null;
        $this->taskTitle = '';
        $this->taskDescription = '';
        $this->categoryId = null;
        $this->taskDeadline = null;
        $this->taskIsDone = 0;
        $this->task = null;
        $this->taskUsers = [];

        // Reset modal state
        $this->isEditing = false;
        $this->showModal = false;
    }


    public function toggleLabel($labelId)
    {
        if (in_array($labelId, $this->selectedLabels)) {
            // If label is already selected, remove it
            $this->selectedLabels = array_diff($this->selectedLabels, [$labelId]);
        } else {
            // If label is not selected, add it
            $this->selectedLabels[] = $labelId;
        }

    }

    public function isLabelSelected($labelId)
    {
        // Check if a label is selected
        return in_array($labelId, $this->selectedLabels);
    }


    // updateTask, resetForm, etc...

    public function render()
    {
        return view('livewire.task-modal');
    }
}