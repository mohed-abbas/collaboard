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
    // Filter by category
    public $selectedCategory = 'all';
    public $searchTerm = '';

    public function mount($project)
    {
        $this->project = Project::findOrFail(is_object($project) ? $project->id : $project);
        $this->categories = $this->project->categories()->with('tasks')->get();
        $this->tasks = $this->project->tasks()->with('category')->get();
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

    public function render()
    {
        return view('livewire.list', [
            'categories' => $this->categories,
            'tasks' => $this->tasks,
            'selectedCategory' => $this->selectedCategory,
            'searchTerm' => $this->searchTerm,
        ]);
    }
}
