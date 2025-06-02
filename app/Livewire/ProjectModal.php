<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectModal extends Component
{
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $editingId = null;
    
    public string $name = '';
    public string $description = '';

    protected $listeners = [
        'openCreateProjectModal' => 'openModal',
        'openEditProjectModal' => 'openEditModal'  // Ajouter cet écouteur
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

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

    public function createProject()
    {
        $this->validate();

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => auth()->id(),  // Utiliser user_id au lieu de owner_id
        ]);

        $this->showModal = false;
        $this->resetForm();

        // Émet un événement pour rafraîchir la liste des projets
        $this->dispatch('projectCreated');
        
        // Rediriger vers la page du projet créé
        return redirect()->route('projects.board', $project->id);
    }

    public function updateProject()
    {
        $this->validate();

        $project = Project::find($this->editingId);
        $project->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->showModal = false;
        $this->resetForm();

        // Émet un événement pour rafraîchir la liste des projets
        $this->dispatch('projectUpdated');
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'editingId', 'isEditing']);
    }

    public function render()
    {
        return view('livewire.project-modal');
    }
}
