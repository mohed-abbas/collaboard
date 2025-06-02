<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

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

    protected $listeners = [
        'openCreateProjectModal' => 'openCreateModal',
        'projectCreated' => 'reloadProjects',
        'projectUpdated' => 'reloadProjects',
        'projectDeleted' => 'reloadProjects',
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
    }

    public function reloadProjects()
    {
        // Récupérer tous les projets de l'utilisateur
        $this->projects = auth()->user()->projects()->latest()->get();
        // DEBUG:
        // dd($this->projects); // Décommenter pour vérifier les données récupérées
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
            'user_id' => auth()->id(),
            'owner_id' => auth()->id(),
        ]);

        $this->showModal = false;
        $this->resetForm();
        
        // Important: recharger la liste
        $this->reloadProjects();
        
        $this->dispatch('projectCreated');
    }

    //–– Edit Flow ––
    public function openEditModal($projectId)
    {
        $this->isEditing = true;
        $this->editingId = $projectId;
        
        // Charger les données du projet
        $project = Project::findOrFail($projectId);
        $this->name = $project->name;
        $this->description = $project->description;
        
        // Ouvrir la modale
        $this->showModal = true;
    }

    public function updateProject()
    {
        // Validation
        $this->validate();
        
        // Mise à jour du projet
        $project = Project::find($this->editingId);
        $project->update([
            'name' => $this->name,
            'description' => $this->description
        ]);
        
        // Fermer la modale et réinitialiser le formulaire
        $this->showModal = false;
        $this->resetForm();
        
        // Rafraîchir la liste des projets
        $this->reloadProjects();
        
        // Émettre un événement pour informer d'autres composants
        $this->dispatch('projectUpdated');
    }

    //–– Delete Flow ––
    public function deleteProject($projectId)
    {
        // Supprimer le projet
        Project::destroy($projectId);
        
        // Rafraîchir la liste
        $this->reloadProjects();
        
        // Émettre un événement
        $this->dispatch('projectDeleted');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    private function resetForm()
    {
        $this->reset(['name', 'description', 'editingId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.project-manager');
    }
}