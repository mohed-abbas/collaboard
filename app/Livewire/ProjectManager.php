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

        $this->closeModal();
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
            session()->flash('error', 'Only the owner can delete this project.');
            return;
        }

        $project->delete();
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

    public function render()
    {
        return view('livewire.project-manager');
    }
}