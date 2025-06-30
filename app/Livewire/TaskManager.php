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

    #[On('openCreateTaskModal')]
    public function openCreateTaskModal($categoryId = null)
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
        $this->categoryId = $categoryId;
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
            $this->taskDeadline = $this->task->deadline;
            $this->taskIsDone = $this->task->is_done;
            $this->taskUsers = $this->task->users->toArray(); // Get array of user objects
        }
    }

    // Task : CRUD operations

    public function createTask()
    {
        $this->validateTask();

        $task = Task::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'category_id' => $this->categoryId ?? null, // Use user input or default
            'deadline' => $this->taskDeadline ?? now(), // Use user input or default
            'priority_level' => 1, // Default priority level
            'position' => 1,
            'is_done' => 0, // Set is_done explicitly
        ]);

        // Attach current user as creator
        $task->users()->attach(Auth::id(), ['is_creator' => true, 'created_at' => now()]);

        $this->dispatch('projectUpdated');
        $this->resetForm();
    }

    public function updateTask()
    {
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
        }
        $this->dispatch('projectUpdated');
        $this->resetForm();
    }

    #[On('deleteTask')]
    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
            $this->dispatch('projectUpdated');
            $this->resetForm();
        }
    }

    #[On('toggleTaskDone')]
    public function toggleTaskDone($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->is_done = !$task->is_done;
            $task->save();
            $this->dispatch('projectUpdated');
        }
    }

    // End CRUD operations

    public function validateTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'categoryId' => 'nullable|exists:categories,id',
            'taskDeadline' => 'nullable|date',
        ]);
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

    // updateTask, resetForm, etc...

    public function render()
    {
        return view('livewire.task-modal');
    }
}
