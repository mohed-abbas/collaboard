<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\On;


class ListView extends Component
{
    public $project;
    public $categories;
    public $tasks;

    // Sorting
    public $listSortby = 'task'; // Default sort by task
    public $listSortDirection = 'asc'; // Default sort direction

    // Filters
    public $selectedCategory = 'all';
    public $searchTerm = '';
    public $showPendingOnly = false;

    public function mount($project)
    {
        $this->loadList($project);
    }

    public function loadList($project)
    {
        $this->project = Project::findOrFail(is_object($project) ? $project->id : $project);
        $this->categories = $this->project->categories()->with('tasks')->get();
        $this->tasks = $this->project->tasks()->with('category')->get();
    }

    public function sortTasks($categoryId, $sortBy)
    {
        if ($sortBy === 'task') {
            $this->tasks[$categoryId] = collect($this->tasks[$categoryId])->sortBy('title')->values()->toArray();
        } elseif ($sortBy === 'status') {
            $this->tasks[$categoryId] = collect($this->tasks[$categoryId])->sortBy('status')->values()->toArray();
        }
        $this->listSortby = $sortBy;
    }

    public function filterByCategory()
    {
        if ($this->selectedCategory == 'all') {
            $this->tasks = $this->project->tasks()->with('category')->get();
            return;
        }
        $this->tasks = $this->project->tasks()
            ->when($this->selectedCategory, function ($query) {
                return $query->where('category_id', $this->selectedCategory);
            })
            ->with('category')
            ->get();
    }

    public function filterBySearchTerm()
    {
        $this->tasks = $this->project->tasks()
            ->when($this->searchTerm, function ($query) {
                return $query->where('tasks.title', 'like', '%' . $this->searchTerm . '%');
            })
            ->with('category')
            ->get();
    }

    public function filterByIsDone()
    {
        if ($this->showPendingOnly == false) {
            $this->tasks = $this->project->tasks()->with('category')->get();
            return;
        }
        $this->tasks = $this->project->tasks()
            ->when($this->showPendingOnly, function ($query) {
                return $query->where('is_done', false);
            })
            ->with('category')
            ->get();
    }

    #[On('projectUpdated')]
    public function projectUpdated()
    {
        $this->loadList($this->project->id);
    }

    public function render()
    {
        return view('livewire.list', [
            'categories' => $this->categories,
            'tasks' => $this->tasks
        ]);
    }
}
