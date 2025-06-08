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

    public $isEditing = false;
    public $showModal = false;

    protected $listeners = [
        'openCreateTaskModal',
        'openEditTaskModal',
    ];

    public function resetForm()
    {
        $this->taskId = null;
        $this->taskTitle = '';
        $this->taskDescription = '';
        $this->categoryId = null;
        $this->isEditing = false;
        $this->showModal = false;
    }

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
        $task = Task::find($this->taskId);
        if ($task) {
            $this->taskTitle = $task->title;
            $this->taskDescription = $task->description;
            $this->categoryId = $task->category_id;
        }
    }

    public function createTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'categoryId' => 'required|exists:categories,id',
        ]);

        Task::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'category_id' => $this->categoryId,
            'priority_level' => 1, // Default priority level
            'position' => 1,
            'is_done' => false,
        ]);

        $this->resetForm();
        $this->dispatch('projectUpdated');
    }

    public function updateTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'categoryId' => 'required|exists:categories,id',
        ]);
        $task = Task::find($this->taskId);
        if($task) {
            $task->update([
                'title' => $this->taskTitle,
                'description' => $this->taskDescription,
                'category_id' => $this->categoryId,
            ]);
        }

        $this->resetForm();
        $this->dispatch('projectUpdated');
    }

    // updateTask, resetForm, etc...

    public function render()
    {
        return view('livewire.task-modal');
    }
}
