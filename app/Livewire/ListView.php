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
    public $listSortby = 'task';
    public $listSortDirection = 'asc';

    // Filters
    public $selectedCategory = '';
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
        $this->applyFilters();
    }

    // Auto-trigger filtering when properties change
    public function updatedSelectedCategory()
    {
        $this->applyFilters();
    }

    public function updatedSearchTerm()
    {
        $this->applyFilters();
    }

    public function updatedShowPendingOnly()
    {
        $this->applyFilters();
    }

    // Combined filtering method
    public function applyFilters()
    {
        $query = $this->project->tasks()->with('category');

        // Apply category filter
        if ($this->selectedCategory !== 'all' && $this->selectedCategory !== '') {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply search term filter - specify table name for title column
        if (!empty($this->searchTerm)) {
            $query->where('tasks.title', 'like', '%' . $this->searchTerm . '%');
        }

        // Apply pending only filter
        if ($this->showPendingOnly) {
            $query->where('is_done', false);
        }

        // Apply sorting - specify table name for title column
        if ($this->listSortby === 'task') {
            $query->orderBy('tasks.title', $this->listSortDirection);
        } elseif ($this->listSortby === 'status') {
            $query->orderBy('is_done', $this->listSortDirection);
        }

        $this->tasks = $query->get();
    }

    public function sortTasks($sortBy)
    {
        $this->listSortby = $sortBy;
        $this->listSortDirection = $this->listSortDirection === 'asc' ? 'desc' : 'asc';
        $this->applyFilters();
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->searchTerm = '';
        $this->showPendingOnly = false;
        $this->applyFilters();
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