<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;

class Board extends Component
{
    public $project;
    public $categories;
    public $labels;
    public $filteredTasks;
    public $viewMode = 'board'; // board or list

    // Filtering properties
    public $selectedCategory = '';
    public $searchTerm = '';
    public $showPendingOnly = false;
    public $selectedLabels = []; // Array of selected label IDs

    // Sorting properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Category management
    public $showCategoryModal = false;
    public $categoryId;
    public $categoryTitle = '';
    public $categoryColor = '#3B82F6';
    public $isEditingCategory = false;

    public $isEditing = false;

    public function mount($project)
    {
        $this->loadProject($project);
        $this->viewMode = session('board_view_mode', 'board'); // Default to 'board' view mode
        $this->applyFilters();
    }

    public function updatedViewMode()
    {
        session(['board_view_mode' => $this->viewMode]);
        $this->applyFilters();
    }

    public function loadProject($project)
    {
        $this->project = Project::findOrFail(is_object($project) ? $project->id : $project);
        $this->categories = $this->project->categories()->with([
            'tasks' => function ($query) {
                $query->with(['labels', 'users', 'category']);
            }
        ])->orderBy('position', 'asc')->get();
        $this->labels = $this->project->labels()->orderBy('name')->get();
    }

    // Auto-trigger filtering when properties change
    public function updatedSelectedCategory()
    {
        $this->applyFilters();
    }

    public function updatedSearchTerm()
    {
        $this->applyFilters();
    }

    public function updatedShowPendingOnly()
    {
        $this->applyFilters();
    }

    public function updatedSelectedLabels()
    {
        $this->applyFilters();
    }

    public function applyFilters()
    {
        $query = $this->project->tasks()->with(['category', 'labels', 'users']);

        // Apply category filter
        if ($this->selectedCategory !== '' && $this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply search term filter
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('tasks.title', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('tasks.description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply pending only filter
        if ($this->showPendingOnly) {
            $query->where('is_done', false);
        }

        // Apply label filters
        if (!empty($this->selectedLabels)) {
            $query->whereHas('labels', function ($q) {
                $q->whereIn('labels.id', $this->selectedLabels);
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'title':
                $query->orderBy('tasks.title', $this->sortDirection);
                break;
            case 'deadline':
                $query->orderBy('deadline', $this->sortDirection);
                break;
            case 'priority':
                $query->orderBy('priority_level', $this->sortDirection);
                break;
            case 'status':
                $query->orderBy('is_done', $this->sortDirection);
                break;
            default:
                $query->orderBy('created_at', $this->sortDirection);
        }

        $this->filteredTasks = $query->get();
    }

    public function sortTasks($sortBy)
    {
        if ($this->sortBy === $sortBy) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortBy;
            $this->sortDirection = 'asc';
        }
        $this->applyFilters();
    }

    public function toggleLabel($labelId)
    {
        if (in_array($labelId, $this->selectedLabels)) {
            $this->selectedLabels = array_diff($this->selectedLabels, [$labelId]);
        } else {
            $this->selectedLabels[] = $labelId;
        }
        $this->applyFilters();
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->searchTerm = '';
        $this->showPendingOnly = false;
        $this->selectedLabels = [];
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $this->applyFilters();
    }

    public function clearLabelFilters()
    {
        $this->selectedLabels = [];
        $this->applyFilters();
    }

    // Category Management Methods
    public function openCreateCategoryModal()
    {
        $this->resetCategoryForm();
        $this->isEditingCategory = false;
        $this->showCategoryModal = true;
    }

    public function openEditCategoryModal($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $this->categoryId = $categoryId;
            $this->categoryTitle = $category->title;
            $this->categoryColor = $category->color;
            $this->isEditingCategory = true;
            $this->showCategoryModal = true;
        }
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryTitle' => 'required|string|max:255',
            'categoryColor' => 'required|string',
        ]);

        if ($this->isEditingCategory) {
            $category = Category::find($this->categoryId);
            if ($category) {
                $category->update([
                    'title' => $this->categoryTitle,
                    'color' => $this->categoryColor,
                ]);
                session()->flash('success', 'Catégorie mise à jour avec succès.');
            }
        } else {
            Category::create([
                'title' => $this->categoryTitle,
                'color' => $this->categoryColor,
                'project_id' => $this->project->id,
                'position' => $this->categories->count() + 1, // Position for drag-and-drop sorting
            ]);
            session()->flash('success', 'Catégorie créée avec succès.');
        }

        $this->resetCategoryForm();
        $this->projectUpdated();
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category && $category->tasks()->count() === 0) {
            $category->delete();
            session()->flash('success', 'Catégorie supprimée avec succès.');
            $this->projectUpdated();
        } else {
            session()->flash('error', 'Impossible de supprimer une catégorie contenant des tâches.');
        }
    }

    private function resetCategoryForm()
    {
        $this->categoryId = null;
        $this->categoryTitle = '';
        $this->categoryColor = '#3B82F6';
        $this->showCategoryModal = false;
        $this->resetErrorBag();
    }

    #[On('projectUpdated')]
    public function projectUpdated()
    {
        $this->loadProject($this->project->id);
        $this->applyFilters();
    }

    #[On('labelUpdated')]
    public function labelUpdated()
    {
        $this->labels = $this->project->labels()->orderBy('name')->get();
        $this->applyFilters();
    }

    public function render()
    {
        return view('livewire.board');
    }
}