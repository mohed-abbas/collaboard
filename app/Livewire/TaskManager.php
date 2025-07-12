<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskManager extends Component
{

    // Props from Board component
    public $categories = [];
    public $viewMode = 'board'; // Default view mode
    public $taskId;
    public $taskTitle = '';
    public $taskDescription = '';
    public $categoryId; // Default to first category if available
    public $taskDeadline;
    public $taskIsDone = 0; // Default to not done
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
        'selectedLabels.array' => 'Les étiquettes sélectionnées doivent être un tableau.',
        'selectedLabels.*.exists' => 'Une ou plusieurs étiquettes sélectionnées n\'existent pas.',
        'taskUsers.array' => 'Les utilisateurs assignés doivent être un tableau.',
        'taskUsers.*.id.exists' => 'Un ou plusieurs utilisateurs assignés n\'existent pas.',
        'taskUsers.*.name.string' => 'Le nom de l\'utilisateur doit être une chaîne de caractères.',
        'taskUsers.*.email.email' => 'L\'email de l\'utilisateur doit être une adresse email valide.',
    ];

    public function mount($categories, $viewMode = 'board')
    {
        $this->categories = $categories;
        $this->viewMode = $viewMode;
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
    public function openCreateTaskModal($categoryId = null, $deadline = null)
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;

        // Set category - prefer "À faire" system category as default
        if ($categoryId === null || $categoryId === 'null') {
            // Try to find "À faire" system category first
            $todoCategory = collect($this->categories)->where('title', 'À faire')->where('is_system', true)->first();
            $this->categoryId = $todoCategory ? $todoCategory->id : ($this->categories[0]->id ?? null);
        } else {
            $this->categoryId = $categoryId;
        }

        // Set deadline - use provided deadline or default to one day from now
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
    }

    #[On('deleteTask')]
    public function deleteTask($taskId)
    {
        try {
            $task = Task::find($taskId);

            if (!$task) {
                session()->flash('error', 'Tâche non trouvée.');
                return;
            }

            // Store info before deletion
            $taskTitle = $task->title;

            // First, reset UI state and close any modals
            // $this->showModal = false;
            // $this->isEditing = false;
            // $this->taskId = null;
            // $this->task = null;

            // Reset form fields
            $this->resetForm();

            // Then delete the task
            $task->delete();

            // Success notification
            session()->flash('success', "Tâche \"{$taskTitle}\" supprimée avec succès.");

            // For calendar view, add a JavaScript redirect
            if ($this->viewMode === 'calendar') {
                // This will trigger a page reload only for calendar view
                $this->dispatch('forceCalendarRefresh');
            } else {
                // Dispatch event to update the UI
                $this->dispatch('projectUpdated');
            }


        } catch (\Exception $e) {
            // Handle any unexpected errors
            $this->resetForm();
            session()->flash('error', 'Erreur lors de la suppression de la tâche: ' . $e->getMessage());
            Log::error('Task deletion error: ' . $e->getMessage());
        }
    }

    #[On('toggleTaskDone')]
    public function toggleTaskDone($taskId)
    {
        $task = Task::find($taskId);

        if (!$task) {
            session()->flash('error', 'Tâche non trouvée.');
            return;
        }

        // Toggle the is_done status
        $task->is_done = !$task->is_done;

        $project = $task->category->project;
        // If task is being marked as done, move it to the "Terminé" category
        if ($task->is_done) {
            // Find the "Terminé" category that is marked as system category
            $doneCategory = $project->categories()
                ->where('title', 'Terminé')
                ->where('is_system', true)
                ->first();

            // If "Terminé" category exists, move the task there
            if ($doneCategory) {
                $task->category_id = $doneCategory->id;
            }
        } else {
            // If task is being unmarked as done, we could optionally move it back
            // to a default category or keep it in the current category

            // If task is being unmarked as done, move it back to "À faire" category
            $todoCategory = $project->categories()
                ->where('title', 'À faire')
                ->where('is_system', true)
                ->first();

            if ($todoCategory) {
                $task->category_id = $todoCategory->id;
            }
        }

        $task->save();
        $this->resetForm(); // Reset form after toggling task status
        $this->dispatch('projectUpdated');

        // Optional: Flash success message
        $statusMessage = $task->is_done ? 'Tâche marquée comme terminée' : 'Tâche marquée comme non terminée';
        session()->flash('success', $statusMessage);
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
            $rules['taskDeadline'] = 'required|date';
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
        $this->resetErrorBag();
        $this->resetValidation();
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

    public function updatedTaskIsDone()
    {
        // This method will be called automatically when taskIsDone property changes
        if ($this->isEditing && $this->taskId) {
            $this->toggleTaskDone($this->taskId);
        }
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