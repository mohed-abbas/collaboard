<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskManager extends Component
{
    // Props from Board component
    public $categories = [];
    public $taskId;
    public $taskTitle = '';
    public $taskDescription = '';
    public $categoryId; // Default to first category if available
    public $taskDeadline;
    public $taskIsDone;
    public $task;
    public $priorityLevelsInfo = [];
    public int $priorityLevel = 1; // Default priority level
    public $taskUsers = [];
    public $isEditing = false;
    public $showModal = false;


    // Labels variables
    public $selectedLabels = []; // Array to hold selected label IDs
    public $availableLabels = []; // Array to hold available labels for the project

    // User assignment variables
    public $availableUsers = []; // Project members who can be assigned
    public $userSearchTerm = ''; // Search term for finding users
    public $showUserDropdown = false; // Control dropdown visibility


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
        // $this->categoryId = $this->categories[0]->id ?? null; // Default to first category if available
        $this->loadLabels(); // Load available labels when component mounts
        $this->loadPriorityLevels(); // Load priority levels when component mounts
        $this->loadAvailableUsers(); // Load project members
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
    public function openCreateTaskModal($categoryId, $deadline = null)
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;

        $this->categoryId = ($categoryId === null || $categoryId === 'null')
            ? ($this->categories[0]->id ?? null)
            : $categoryId;

        // Set default deadline to one day from now for new tasks
        $this->taskDeadline = $deadline ?: now()->addDay()->format('Y-m-d\TH:i');
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
            $this->priorityLevel = $this->task->priority_level; // Default to 1 if not set
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
            'priority_level' => $this->priorityLevel,
            'position' => 1,
            'is_done' => 0,
            'created_by' => Auth::id(),
        ]);

        // Attach selected labels to the task
        if (!empty($this->selectedLabels)) {
            $task->labels()->attach($this->selectedLabels);
        }

        // Attach assigned users to the task
        if (!empty($this->taskUsers)) {
            foreach ($this->taskUsers as $user) {
                $isCreator = ($user['id'] == Auth::id());
                $task->users()->attach($user['id'], [
                    'is_creator' => $isCreator,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $this->dispatch('projectUpdated');
        session()->flash('success', 'Tâche créée avec succès.');
        $this->resetForm();
        $this->dispatch('$refresh');
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
                'priority_level' => $this->priorityLevel, // Keep default priority level
            ]);
            // Sync labels (this will remove old labels and add new ones)
            $task->labels()->sync($this->selectedLabels);
        }
        $this->dispatch('projectUpdated');
        session()->flash('success', 'Tâche mise à jour avec succès.');
        $this->resetForm();
        $this->dispatch('$refresh'); // Refresh the component
    }

    #[On('deleteTask')]
    public function deleteTask($taskId)
    {
        try {
            $task = Task::find($taskId);

            if ($task) {
                // Store info before deletion
                $taskTitle = $task->title;

                // Close modal and reset form FIRST
                $this->resetForm();

                // Delete the task (labels automatically detached)
                $task->delete();

                // Success feedback
                session()->flash('success', "Tâche \"{$taskTitle}\" supprimée avec succès.");
                // Refresh the board
                $this->dispatch('projectUpdated');
            } else {
                // Task not found
                $this->resetForm();
                session()->flash('error', 'Tâche non trouvée.');
            }

        } catch (\Exception $e) {
            // Handle any unexpected errors
            $this->resetForm();
            session()->flash('error', 'Erreur lors de la suppression de la tâche.');
            Log::error('Task deletion error: ' . $e->getMessage());
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
        $this->priorityLevel = 1; // Reset to default priority level
        $this->selectedLabels = []; // Reset selected labels

        // Reset user assignment fields
        $this->userSearchTerm = '';
        $this->showUserDropdown = false;

        // Reset modal state
        $this->isEditing = false;
        $this->showModal = false;

        $this->dispatch('$refresh'); // Refresh the component
        $this->resetErrorBag();
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

    /**
     * Load priority levels for tasks.
     * This can be loaded from the database or defined statically.
     */
    public function loadPriorityLevels()
    {
        // Get the priority levels from the Task model.
        $this->priorityLevelsInfo = Task::getPriorityLevels();
    }
    /**
     * Load available users for task assignment.
     * This can be loaded from the project associated with the categories.
     *
     * @return array
     */
    public function loadAvailableUsers()
    {
        // Get the project members from the categories
        $project = collect($this->categories)->first()?->project;
        if (!$project) {
            return [];
        }
        $this->availableUsers = $project->members()->orderBy('name')->get([
            'id',
            'name',
            'email'
        ]);
        return $this->availableUsers;
    }


    public function assignUserToTask($userId)
    {
        // For task creation mode, we'll store users in a temporary array
        if (!$this->isEditing) {
            // Check if user is not already in the temporary list
            if (!in_array($userId, array_column($this->taskUsers, 'id'))) {
                // Find the user from available users
                $user = $this->availableUsers->firstWhere('id', $userId);
                if ($user) {
                    $this->taskUsers[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'pivot' => ['is_creator' => false] // Default to not creator for new assignments
                    ];
                }
            }
            $this->showUserDropdown = false;
            return;
        }

        // Existing logic for editing mode
        if ($this->task && !in_array($userId, array_column($this->taskUsers, 'id'))) {
            // Check if this user is the creator of the task
            $isCreator = ($this->task->created_by == $userId);

            $this->task->users()->attach($userId, [
                'is_creator' => $isCreator,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->taskUsers = $this->task->users->toArray();
            $this->showUserDropdown = false;
            $this->dispatch('projectUpdated');
        }
    }


    public function removeUserFromTask($userId)
    {
        // For task creation mode, remove from temporary array
        if (!$this->isEditing) {
            $this->taskUsers = array_filter($this->taskUsers, function ($user) use ($userId) {
                return $user['id'] != $userId;
            });
            // Reindex the array
            $this->taskUsers = array_values($this->taskUsers);
            return;
        }

        // Existing logic for editing mode
        if ($this->task) {
            $this->task->users()->detach($userId);
            $this->taskUsers = $this->task->users->toArray();
            $this->dispatch('projectUpdated');
        }
    }

    public function toggleUserDropdown()
    {
        $this->showUserDropdown = !$this->showUserDropdown;
    }

    public function getAssignableUsers()
    {
        // Get users who are not already assigned to the task
        $assignedUserIds = array_column($this->taskUsers, 'id');

        // If we're creating a new task, show all available users
        // If we're editing, show users not already assigned
        return $this->availableUsers->filter(function ($user) use ($assignedUserIds) {
            return !in_array($user->id, $assignedUserIds);
        });
    }

    public function focusUserSearch()
    {
        $this->showUserDropdown = true;
    }

    public function hideUserDropdown()
    {
        // Hide dropdown after a short delay to allow for clicks
        $this->showUserDropdown = false;
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.task-modal');
    }
}