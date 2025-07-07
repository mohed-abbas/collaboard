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
        ['title' => 'À faire', 'sort_order' => 1, 'is_system' => true, 'color' => '#6b1bbb'], // Red for "To do"
        ['title' => 'En cours', 'sort_order' => 2, 'is_system' => true, 'color' => '#dd7c0e'], // Orange for "In progress"
        ['title' => 'Terminé', 'sort_order' => 3, 'is_system' => true, 'color' => '#048b0d'], // Green for "Completed"
    ];


    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    protected $messages = [
        'name.required' => 'Le nom du projet est obligatoire.',
        'name.max' => 'Le nom du projet ne peut pas dépasser 255 caractères.',
        'description.string' => 'La description doit être une chaîne de caractères valide.',
    ];

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

    #[On('openCreateProjectModal')]
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
                'is_system' => $categoryData['is_system'] ?? false, // Default to false if not set
                'position' => $categoryData['sort_order'],
                'color' => $categoryData['color'] ?? '#ef4444', // Default color if not set
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


    #[On('getProjectColors')]
    public function getProjectColors(string $projectName): array|string
    {
        $colors = [
            'A' => 'from-red-500 to-pink-600 shadow-red-500/25',
            'B' => 'from-blue-500 to-cyan-600 shadow-blue-500/25',
            'C' => 'from-green-500 to-emerald-600 shadow-green-500/25',
            'D' => 'from-purple-500 to-indigo-600 shadow-purple-500/25',
            'E' => 'from-yellow-500 to-orange-600 shadow-yellow-500/25',
            'F' => 'from-pink-500 to-rose-600 shadow-pink-500/25',
            'G' => 'from-teal-500 to-cyan-600 shadow-teal-500/25',
            'H' => 'from-indigo-500 to-purple-600 shadow-indigo-500/25',
            'I' => 'from-orange-500 to-red-600 shadow-orange-500/25',
            'J' => 'from-emerald-500 to-teal-600 shadow-emerald-500/25',
            'K' => 'from-violet-500 to-purple-600 shadow-violet-500/25',
            'L' => 'from-lime-500 to-green-600 shadow-lime-500/25',
            'M' => 'from-fuchsia-500 to-pink-600 shadow-fuchsia-500/25',
            'N' => 'from-sky-500 to-blue-600 shadow-sky-500/25',
            'O' => 'from-amber-500 to-orange-600 shadow-amber-500/25',
            'P' => 'from-rose-500 to-pink-600 shadow-rose-500/25',
            'Q' => 'from-cyan-500 to-teal-600 shadow-cyan-500/25',
            'R' => 'from-red-600 to-rose-700 shadow-red-500/25',
            'S' => 'from-blue-600 to-indigo-700 shadow-blue-500/25',
            'T' => 'from-green-600 to-emerald-700 shadow-green-500/25',
            'U' => 'from-purple-600 to-violet-700 shadow-purple-500/25',
            'V' => 'from-yellow-600 to-amber-700 shadow-yellow-500/25',
            'W' => 'from-pink-600 to-fuchsia-700 shadow-pink-500/25',
            'X' => 'from-teal-600 to-cyan-700 shadow-teal-500/25',
            'Y' => 'from-orange-600 to-red-700 shadow-orange-500/25',
            'Z' => 'from-indigo-600 to-purple-700 shadow-indigo-500/25',
        ];

        $firstletter = strtoupper(substr($projectName, 0, 1));
        return $colors[$firstletter] ?? 'from-gray-500 to-gray-600 shadow-gray-500/25';
    }


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