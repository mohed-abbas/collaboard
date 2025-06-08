<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;

class TaskManager extends Component
{
    public $taskId;
    public $taskTitle = '';
    public $taskDescription = '';
    public $categoryId;
    public $taskDeadline;
    public $taskIsDone;
    public $categories = [];

    public $isEditing = false;
    public $showModal = false;

    #[On('openCreateTaskModal')]
    public function openCreateTaskModal($categoryId)
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
        $task = Task::find($taskId);
        if ($task) {
            $this->taskTitle = $task->title;
            $this->taskDescription = $task->description;
            $this->categoryId = $task->category_id;
            $this->taskDeadline = $task->deadline;
            $this->taskIsDone = $task->is_done;
        }
    }

    // Task : CRUD operations

    public function createTask()
    {
        $this->validateTask();

        Task::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'category_id' => $this->categoryId,
            'deadline' => $this->taskDeadline ?? now(), // Use user input or default
            'priority_level' => 1, // Default priority level
            'position' => 1,
            'is_done' => $this->taskIsDone,
        ]);

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

    // End CRUD operations

    public function validateTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'categoryId' => 'required|exists:categories,id',
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

        $this->isEditing = false;
        $this->showModal = false;
    }

    // updateTask, resetForm, etc...

    public function render()
    {
        return view('livewire.task-modal');
    }
}
