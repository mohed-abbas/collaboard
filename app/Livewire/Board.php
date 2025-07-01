<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\On;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


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
        // MODIFICATION: Organisation des tâches par catégorie

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
        $this->reset(['categoryTitle', 'editingCategoryId']);
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

    // MODIFICATION: Flux d'édition de catégorie - Variable pour stocker l'ID en cours d'édition
    public $editingCategoryId;

    // MODIFICATION: Flux d'édition de catégorie - Ouverture du modal d'édition
    public function openEditCategoryModal($categoryId)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingCategoryId = $categoryId;
        $category = $this->categories->find($categoryId);
        $this->categoryTitle = $category->title;
        $this->showCategoryModal = true;
    }

    // MODIFICATION: Flux d'édition de catégorie - Mise à jour effective
    public function updateCategory()
    {
        $this->validate([
            'categoryTitle' => 'required|string|max:255',
        ]);

        $category = Category::find($this->editingCategoryId);
        $category->update([
            'title' => $this->categoryTitle
        ]);

        $this->resetForm();
        $this->loadBoard();
    }

    // MODIFICATION: Flux de suppression de catégorie - Suppression en cascade des tâches
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            // MODIFICATION: Suppression d'abord de toutes les tâches de cette catégorie
            Task::where('category_id', $categoryId)->delete();
            // MODIFICATION: Puis suppression de la catégorie elle-même
            $category->delete();
            $this->loadBoard();
        }
    }

    // MODIFICATION: Écouteur pour les mises à jour de projet
    #[On('projectUpdated')]
    public function projectUpdated()
    {
        // MODIFICATION: Rechargement du tableau quand le projet est mis à jour
        $this->loadBoard();
    }
    // MODIFICATION: Méthode d'initialisation du composant avec vérification des droits d'accès
    public function mount(Project $project)
    {
        // MODIFICATION: Vérification que l'utilisateur a accès à ce projet (membre ou propriétaire)
        // if (!$project->members->contains(Auth::id()) && $project->owner_id !== Auth::id()) {
        //     abort(403, 'Accès non autorisé à ce projet');
        // }

        if (!Auth::user()->can('view', $project)) {
            session()->flash('error', 'Vous n\'avez pas la permission de voir ce projet.');
            return redirect()->route('dashboard'); // Redirection vers le tableau de bord
        }

        $this->project = $project;
        $this->loadBoard();
    }

    // MODIFICATION: Rendu de la vue avec layout personnalisé et titre dynamique

    public function render()
    {
        return view('livewire.board')->layout('components.layouts.app', ['title' => 'Tableau - ' . $this->project->name]);
    }
}