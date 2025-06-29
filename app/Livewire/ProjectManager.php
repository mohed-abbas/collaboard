<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\On;

class ProjectManager extends Component
{
    public $projects = [];
    // Modal state
    public bool $showModal = false;
    public bool $isEditing = false;
    // Form fields
    public ?int $editingId = null;
    public string $name = '';
    public string $description = '';


    private array $defaultCategories = [
        ['title' => 'À faire', 'sort_order' => 1],
        ['title' => 'En cours', 'sort_order' => 2],
        ['title' => 'Terminé', 'sort_order' => 3],
    ];


    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->reloadProjects();

        // Si on vient de projects.create, ouvrir automatiquement le modal
        if (request()->routeIs('projects.create')) {
            $this->openCreateModal();
        }
    }

    #[On('reloadProjects')]
    public function reloadProjects()
    {
        $this->projects = auth()->user()
            ->projects()
            ->orderBy('sort_order')
            ->get();
    }

    //–– Create Flow ––
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function createProject()
    {
        $this->validate();

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'owner_id' => auth()->id(),
        ]);
        $project->members()->attach(auth()->id());


        foreach ($this->defaultCategories as $categoryData) {
            Category::create([
                'title' => $categoryData['title'],
                'project_id' => $project->id,
                'sort_order' => $categoryData['sort_order'],
            ]);
        }
        $this->closeModal();

        // Redirect to the project board after creation
        redirect()->route('project.board', $project->id)
            ->with('success', 'Projet créé avec succès.');
        $this->reloadProjects();
    }

    //–– Edit Flow ––
    public function openEditModal(int $id)
    {
        $project = Project::findOrFail($id);

        $this->editingId = $project->id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function updateProject()
    {
        $this->validate();

        Project::findOrFail($this->editingId)
            ->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
        $this->dispatch('projectUpdated', $this->editingId);

        $this->closeModal();
        $this->reloadProjects();
    }

    //–– Delete Flow ––
    public function deleteProject(int $id)
    {
        $project = Project::findOrFail($id);

        // Only owner can delete
        if ($project->owner_id !== auth()->id()) {
            session()->flash('error', 'Vous n\'avez pas la permission de supprimer ce projet.');
            return;
        }

        $project->delete();

        //redirect to the dashboard or projects list
        redirect()->route('dashboard')
            ->with('success', 'Project deleted successfully.');
        // Reload projects after deletion
        $this->reloadProjects();
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->description = '';
    }

    protected $listeners = [
        'viewProjectBoard' => 'viewBoard',
        'open-create-project' => 'openCreateModal' // Ajouter cet écouteur
    ];

    public function viewBoard($projectId)
    {
        return $this->redirect(route('project.board', $projectId));
    }

    public function render()
    {
        return view('livewire.project-manager')
            ->layout('layouts.app', ['title' => 'Gestion des Projets']);
    }
}