<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Dashboard extends Component
{
    // Propriétés du modal
    public bool $showModal = false;
    public bool $isEditing = false;
    
    // Champs du formulaire
    public ?int $editingId = null;
    public string $name = '';
    public string $description = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
    
    public function render()
    {
        $projects = Project::where('user_id', auth()->id())
            ->orWhereHas('members', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('livewire.dashboard', [
            'projects' => $projects
        ]);
    }
    
    // Fonctions pour le modal de création
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }
    
    // Fonctions pour le modal d'édition
    public function openEditModal(int $id)
    {
        $project = Project::findOrFail($id);
        
        $this->editingId = $project->id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->isEditing = true;
        $this->showModal = true;
    }
    
    // Fonction de création de projet
    public function createProject()
    {
        $this->validate();
        
        $project = new Project();
        $project->name = $this->name;
        $project->description = $this->description;
        $project->owner_id = auth()->id();
        $project->user_id = auth()->id();
        $project->save();
        
        $project->members()->attach(auth()->id());
        
        $this->closeModal();
    }
    
    // Fonction de mise à jour de projet
    public function updateProject()
    {
        $this->validate();
        
        Project::findOrFail($this->editingId)
            ->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            
        $this->closeModal();
    }
    
    // Fonction de suppression de projet
    public function deleteProject(int $id)
    {
        $project = Project::findOrFail($id);
        
        // Vérification que l'utilisateur est bien propriétaire
        if ($project->owner_id !== auth()->id()) {
            session()->flash('error', 'Only the owner can delete this project.');
            return;
        }
        
        $project->delete();
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
}
