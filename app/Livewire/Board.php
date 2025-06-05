<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use stdClass;

class Board extends Component
{

    public $project;
    public $categories;
    public $categoryTitle = '';
    public $tasks = [];
    public $showModal = false;
    public $isEditing = false;

    public function loadBoard()
    {
        $this->categories = Category::where('project_id', $this->project->id)->with('tasks')
            ->orderBy('created_at', 'asc')
            ->get();
        $this->tasks = [];
        foreach ($this->categories as $category) {
            $this->tasks[$category->id] = $category->tasks;
        }
        // Initialize tasks for each category
        foreach ($this->categories as $category) {
            if (!isset($this->tasks[$category->id])) {
                $this->tasks[$category->id] = collect();
            }
        }
        // Ensure tasks are in the correct format
        foreach ($this->tasks as $categoryId => $taskCollection) {
            $this->tasks[$categoryId] = $taskCollection->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status,
                    'category_id' => $task->category_id,
                ];
            })->toArray();
        }
    }

    public function resetForm()
    {
        $this->isEditing = false;
        $this->showModal = false;
        $this->reset(['categoryTitle', 'taskTitle', 'taskDescription', 'taskStatus', 'taskCategoryId']);
    }

    //   Category: Create Flow
    public function openCreateCategoryModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function createCategory()
    {
        $this->validate([
            'categoryTitle' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'title' => $this->categoryTitle,
            'project_id' => $this->project->id,
        ]);

        $this->categories->push($category);
        $this->resetForm();
        $this->loadBoard();
    }

    //   Task: Create Flow

    public $taskTitle = '';
    public $taskDescription = '';
    public $taskStatus = '';
    public $categoryId = '';

    public function openCreateTaskModal($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->showModal = true;
    }

    public function createTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            // 'taskStatus' => 'required|string|max:255',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $task = Task::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'category_id' => $this->categoryId,
            'is_done' => false,
            'deadline' => null,
            'priority_level' => 1,
            'position' => 0,
        ]);
        
        // Add the new task to the correct category's task array
        $this->tasks[$this->categoryId][] = [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'category_id' => $task->category_id,
        ];

        $this->showModal = false;
        $this->loadBoard();
    }

    public function resetTaskForm()
    {
        $this->isEditing = false;
        $this->showModal = false;
        $this->reset(['taskTitle', 'taskDescription', 'taskStatus', 'taskCategoryId']);
    }


    // Listener for project updates
    #[On('projectUpdated')]
    public function projectUpdated()
    {
        // $this->project = Project::find($this->project->id);
        $this->loadBoard();
    }

    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->loadBoard();
    }
    public function render()
    {
        return view('livewire.board');
    }
}
