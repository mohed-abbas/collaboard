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

    public $showCategoryModal = false;
    public $showTaskModal = false;
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
        $this->showCategoryModal = false;
        $this->showTaskModal = false;
        $this->reset(['categoryTitle']);
    }

    //   Category: Create Flow
    public function openCreateCategoryModal()
    {
        $this->resetForm();
        $this->showCategoryModal = true;
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
