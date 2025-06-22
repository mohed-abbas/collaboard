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

    public function mount($project)
    {
        $this->project = $project;
        $this->categories = $project->categories()->with('tasks')->get();
        $this->tasks = $project->tasks()->with('category')->get();
    }

    public function render()
    {
        return view('livewire.list', [
            'categories' => $this->categories,
            'tasks' => $this->tasks,
        ]);
    }
}