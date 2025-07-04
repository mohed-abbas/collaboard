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
    public $tasks = [];
    public $tasksByCategory = [];
    public $showCategoryModal = false;
    public $showTaskModal = false;
    public $isEditing = false;
    public $categoryTitle = '';
    public $labels = []; // Variable pour stocker les labels du projet
    public $editingCategoryId; // Variable pour stocker l'ID en cours d'édition
    public $filterByLabel = null; // Variable pour filtrer les tâches par label


    protected $rules = [
        'categoryTitle' => 'required|string|max:50|min:3',
    ];


    protected $messages = [
        'categoryTitle.required' => 'Le titre de la catégorie est requis.',
        'categoryTitle.string' => 'Le titre de la catégorie doit être une chaîne de caractères.',
        'categoryTitle.max' => 'Le titre de la catégorie ne peut pas dépasser 255 caractères.',
    ];


    // MODIFICATION: Méthode pour charger le tableau avec les catégories, tâches et labels
    public function loadBoard()
    {
        $query = Category::where('project_id', $this->project->id)
            ->with([
                'tasks' => function ($query) {
                    $query->with(['labels', 'users'])->orderBy('position');

                    if ($this->filterByLabel) {
                        $query->whereHas('labels', function ($labelQuery) {
                            $labelQuery->where('labels.id', $this->filterByLabel);
                        });
                    }
                }
            ]);

        $this->categories = $query->orderBy('position')->get();

        $this->tasksByCategory = [];
        $this->tasks = [];

        // Organisation des tâches par catégorie
        foreach ($this->categories as $category) {
            $this->tasksByCategory[$category->id] = $category->tasks;
            // Ajout de toutes les tâches dans le tableau global
            foreach ($category->tasks as $task) {
                $this->tasks[] = $task;
            }
        }

        // Initialisation des tâches pour chaque catégorie (au cas où elle serait vide)
        foreach ($this->categories as $category) {
            if (!isset($this->tasksByCategory[$category->id])) {
                $this->tasksByCategory[$category->id] = collect();
            }
        }

        // Charger les labels du projet
        $this->loadLabels();
    }


    // Add listener for filter changes
    public function updatedFilterByLabel()
    {
        $this->loadBoard();
    }

    public function clearLabelFilter()
    {
        $this->filterByLabel = null;
        $this->loadBoard();
    }


    // MODIFICATION: Nouvelle méthode pour charger les labels
    public function loadLabels()
    {
        $this->labels = $this->project->labels()->orderBy('name')->get();
    }

    // MODIFICATION: Écouteur pour les mises à jour de labels
    #[On('labelsUpdated')]
    public function refreshLabels()
    {
        $this->loadLabels();
        $this->loadBoard(); // Recharger le tableau pour avoir les labels mis à jour sur les tâches
    }

    // Méthode pour réinitialiser le formulaire modal
    public function resetForm()
    {
        $this->isEditing = false;
        $this->showCategoryModal = false;
        $this->showTaskModal = false;
        $this->reset(['categoryTitle', 'editingCategoryId']);
    }

    // Flux de création de catégorie - Ouverture du modal
    public function openCreateCategoryModal()
    {
        $this->resetForm();
        $this->showCategoryModal = true;
    }

    // Flux de création de catégorie - Création effective
    public function createCategory()
    {
        $this->validate();

        // Déterminer la position pour la nouvelle catégorie
        $maxPosition = Category::where('project_id', $this->project->id)->max('position') ?? 0;

        $category = Category::create([
            'title' => $this->categoryTitle,
            'project_id' => $this->project->id,
            'position' => $maxPosition + 1,
        ]);

        $this->resetForm();
        $this->loadBoard();

        session()->flash('success', 'Catégorie créée avec succès.');
    }

    // Flux d'édition de catégorie - Ouverture du modal d'édition
    public function openEditCategoryModal($categoryId)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingCategoryId = $categoryId;
        $category = $this->categories->find($categoryId);
        if ($category) {
            $this->categoryTitle = $category->title;
            $this->showCategoryModal = true;
        }
    }

    // Flux d'édition de catégorie - Mise à jour effective
    public function updateCategory()
    {
        $this->validate();

        $category = Category::find($this->editingCategoryId);
        if ($category) {
            $category->update([
                'title' => $this->categoryTitle
            ]);

            session()->flash('success', 'Catégorie mise à jour avec succès.');
        }

        $this->resetForm();
        $this->loadBoard();
    }

    // Flux de suppression de catégorie - Suppression en cascade des tâches
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $tasksCount = $category->tasks->count();

            // Suppression d'abord de toutes les tâches de cette catégorie
            // Les labels seront automatiquement détachés grâce aux contraintes de clé étrangère
            Task::where('category_id', $categoryId)->delete();

            // Puis suppression de la catégorie elle-même
            $category->delete();
            $this->loadBoard();

            session()->flash('success', "Catégorie supprimée avec succès ($tasksCount tâche(s) supprimée(s)).");
        }
    }

    // MODIFICATION: Nouvelle méthode pour filtrer les tâches par label
    public function getTasksByLabel($labelId)
    {
        return $this->tasks->filter(function ($task) use ($labelId) {
            return $task->labels->contains('id', $labelId);
        });
    }

    // MODIFICATION: Nouvelle méthode pour obtenir les statistiques des labels
    public function getLabelStats()
    {
        $stats = [];
        foreach ($this->labels as $label) {
            $stats[$label->id] = [
                'name' => $label->name,
                'color' => $label->color,
                'tasks_count' => $this->tasks->filter(function ($task) use ($label) {
                    return $task->labels->contains('id', $label->id);
                })->count()
            ];
        }
        return $stats;
    }

    // MODIFICATION: Nouvelle méthode pour obtenir les tâches avec labels pour une catégorie
    public function getCategoryTasksWithLabels($categoryId)
    {
        return $this->tasksByCategory[$categoryId] ?? collect();
    }

    // Écouteur pour les mises à jour de projet
    #[On('projectUpdated')]
    public function projectUpdated()
    {
        // Rechargement du tableau quand le projet est mis à jour
        $this->loadBoard();
    }

    // Méthode d'initialisation du composant avec vérification des droits d'accès
    public function mount(Project $project)
    {
        // Vérification que l'utilisateur a accès à ce projet
        if (!Auth::user()->can('view', $project)) {
            session()->flash('error', 'Vous n\'avez pas la permission de voir ce projet.');
            return redirect()->route('dashboard');
        }

        $this->project = $project;
        $this->loadBoard();
    }

    // Rendu de la vue avec layout personnalisé et titre dynamique
    public function render()
    {
        return view('livewire.board')->layout('components.layouts.app', ['title' => 'Tableau - ' . $this->project->name]);
    }
}