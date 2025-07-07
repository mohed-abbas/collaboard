<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Label;
use App\Models\Project;

class LabelManager extends Component
{
    public $labels = [];
    public $project;
    public $showModal = false;
    public $isEditing = false;

    // form fields
    public $labelId;
    public $labelName = '';
    public $labelColor = '#3B82F6'; // Default color


    // Predefined colors
    public $predefinedColors = [
        '#3B82F6',
        '#F43F5E',
        '#FBBF24',
        '#34D399',
        '#60A5FA',
        '#F87171',
        '#A78BFA',
        '#FCD34D',
        '#10B981',
        '#EF4444',
        '#6366F1'
    ];

    protected $rules = [
        'labelName' => 'required|string|max:20',
        'labelColor' => 'required|string|size:7', // Hex color code
    ];

    protected $messages = [
        'labelName.required' => 'Le nom de l\'étiquette est requis.',
        'labelName.string' => 'Le nom de l\'étiquette doit être une chaîne de caractères.',
        'labelName.max' => 'Le nom de l\'étiquette ne peut pas dépasser 20 caractères.',
        'labelColor.required' => 'La couleur de l\'étiquette est requise.',
        'labelColor.size' => 'La couleur de l\'étiquette doit être un code hexadécimal valide (7 caractères).',
    ];

    // protected $validationAttributes = [
    //     'labelName' => 'nom de l\'étiquette',
    //     'labelColor' => 'couleur de l\'étiquette',
    // ];

    public function mount($project)
    {
        $this->project = $project;
        $this->loadLabels();
    }

    public function loadLabels()
    {
        $this->labels = $this->project->labels()->get();
    }

    #[On('openLabelModal')]
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal($labelId)
    {
        $label = Label::find($labelId);
        if ($label && $label->project_id === $this->project->id) {
            $this->labelId = $label->id;
            $this->labelName = $label->name;
            $this->labelColor = $label->color;
            $this->isEditing = true;
            $this->showModal = true;
        }
    }


    public function saveLabel()
    {
        $this->validate();
        $existingLabel = Label::where('project_id', $this->project->id)
            ->where('name', $this->labelName)
            ->when($this->isEditing, function ($query) {
                return $query->where('id', '!=', $this->labelId);
            })
            ->first();

        if ($existingLabel) {
            $this->addError('labelName', 'Une étiquette avec ce nom existe déjà.');
            return;
        }

        if ($this->isEditing) {
            $label = Label::find($this->labelId);
            if ($label && $label->project_id === $this->project->id) {
                $label->update([
                    'name' => $this->labelName,
                    'color' => $this->labelColor,
                ]);
                session()->flash('success', 'Étiquette mise à jour avec succès.');
            }
        } else {
            Label::create([
                'name' => $this->labelName,
                'color' => $this->labelColor,
                'project_id' => $this->project->id,
            ]);
            session()->flash('success', 'Étiquette créée avec succès.');
        }

        $this->loadLabels();
        $this->resetForm();
        $this->dispatch('labelUpdated');
    }

    public function deleteLabel($labelId)
    {
        $label = Label::find($labelId);
        if (!$label || $label->project_id !== $this->project->id) {
            session()->flash('error', 'Étiquette non trouvée ou vous n\'avez pas la permission de la supprimer.');
            return;
        }

        $taskCount = $label->tasks()->count();
        if ($taskCount > 0) {
            session()->flash('error', 'Impossible de supprimer l\'étiquette car elle est utilisée dans ' . $taskCount . ' tâche(s). Veuillez d\'abord retirer l\'étiquette des tâches associées.');
            return;
        }
        $label->delete();
        $this->loadLabels();
        session()->flash('success', 'Étiquette supprimée avec succès.');
        $this->dispatch('labelUpdated');
    }


    public function forceDeleteLabel($labelId)
    {
        $label = Label::find($labelId);
        if (!$label || $label->project_id !== $this->project->id) {
            session()->flash('error', 'Étiquette non trouvée ou vous n\'avez pas la permission de la supprimer.');
            return;
        }

        $label->delete();
        $this->loadLabels();
        session()->flash('success', 'Étiquette supprimée avec succès.');
        $this->dispatch('labelUpdated');
        $this->dispatch('projectUpdated');
    }


    public function resetForm()
    {
        $this->labelId = null;
        $this->labelName = '';
        $this->labelColor = '#3B82F6'; // Reset to default color
        $this->isEditing = false;
        $this->resetErrorBag();
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function setColor($color)
    {
        $this->labelColor = $color;
    }

    public function render()
    {
        return view('livewire.label-manager');
    }
}