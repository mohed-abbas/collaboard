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

    // MODIFICATION: Méthode pour charger le tableau avec les catégories et tâches
    public function loadBoard()
    {
        // MODIFICATION: Récupération des catégories avec leurs tâches associées, triées par date de création
        $this->categories = Category::where('project_id', $this->project->id)->with('tasks')
            ->orderBy('created_at', 'asc')
            ->get();
        $this->tasksByCategory = [];
        foreach ($this->categories as $category) {
            $this->tasksByCategory[$category->id] = $category->tasks;
        }
        
        // MODIFICATION: Initialisation des tâches pour chaque catégorie (au cas où elle serait vide)
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

    // MODIFICATION: Méthode pour réinitialiser le formulaire modal
    public function resetForm()
    {
        $this->isEditing = false;
        $this->showCategoryModal = false;
        $this->showTaskModal = false;
        $this->reset(['categoryTitle']);
    }

    // MODIFICATION: Flux de création de catégorie - Ouverture du modal
    public function openCreateCategoryModal()
    {
        $this->resetForm();
        $this->showCategoryModal = true;
    }

    // MODIFICATION: Flux de création de catégorie - Création effective
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

    // MODIFICATION: Méthode d'initialisation du composant avec vérification des droits d'accès
    public function mount(Project $project)
    {
        // MODIFICATION: Vérification que l'utilisateur a accès à ce projet (membre ou propriétaire)
        if (!$project->members->contains(auth()->id()) && $project->owner_id !== auth()->id()) {
            abort(403, 'Accès non autorisé à ce projet');
        }
        
        $this->project = $project;
        $this->loadBoard();
    }

    // MODIFICATION: Rendu de la vue avec layout personnalisé et titre dynamique
    public function render()
    {
        return view('livewire.board')
            ->layout('components.layouts.app', ['title' => 'Tableau - ' . $this->project->name]);
    }


}