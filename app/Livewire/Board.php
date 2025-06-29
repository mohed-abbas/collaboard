<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\On;

class Board extends Component
{
    public $viewMode = 'board'; // Default view mode


    public $project;
    public $categories;
    public $categoryTitle = '';
    public $tasks = [];
    public $tasksByCategory = [];

    public $showCategoryModal = false;
    public $showTaskModal = false;
    public $isEditing = false;

    public function loadBoard()
    {
        $this->categories = Category::where('project_id', $this->project->id)->with('tasks')
            ->orderBy('created_at', 'asc')
            ->get();
        $this->tasksByCategory = [];
        foreach ($this->categories as $category) {
            $this->tasksByCategory[$category->id] = $category->tasks;
        }
        // Initialize tasks for each category
        foreach ($this->categories as $category) {
            if (!isset($this->tasksByCategory[$category->id])) {
                $this->tasksByCategory[$category->id] = collect();
            }
            foreach ($category->tasks as $task) {
                $this->tasks[] = $task;
            }
        }
        // Ensure tasks are in the correct format
        foreach ($this->tasksByCategory as $categoryId => $taskCollection) {
            $this->tasksByCategory[$categoryId] = $taskCollection->map(function ($task) {
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
