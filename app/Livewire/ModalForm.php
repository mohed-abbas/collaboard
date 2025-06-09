<?php

namespace App\Livewire;

use Livewire\Component;

class ModalForm extends Component
{
    public bool $visible = false;
    public string $mode = '';      // 'create' or 'edit'
    public ?int $modelId = null;
    public string $title = '';      // e.g. 'Project'
    public array $fields = [];      // e.g. ['name','description']
    public array $formData = [];     // holds input values

    protected $listeners = ['openModal', 'closeModal'];

    public function openModal(array $payload)
    {
        $this->mode = $payload['mode'];
        $this->title = $payload['title'];
        $this->fields = $payload['fields'];
        $this->modelId = $payload['mode'] === 'edit' ? $payload['id'] : null;

        // If editing, load existing data
        if ($this->mode === 'edit' && $this->modelId) {
            $modelClass = $payload['model']; // e.g. \App\Models\Project
            $model = $modelClass::findOrFail($this->modelId);
            foreach ($this->fields as $field) {
                $this->formData[$field] = $model->$field;
            }
        } else {
            // Clear old form data
            $this->formData = [];
        }

        $this->visible = true;
    }

    public function closeModal()
    {
        $this->visible = false;
    }

    public function save()
    {
        $rules = [];
        foreach ($this->fields as $field) {
            // simple required rule for all fields; customize further as needed
            $rules["formData.$field"] = ['required'];
        }
        $validated = $this->validate($rules);

        // Determine model class
        $modelClass = request()->input('_livewire_payload.model') ?? null;
        // Fallback: pass 'model' in payload to openModal

        if ($this->mode === 'create') {
            $model = ($payloadModel = $validated) && $modelClass
                ? ($modelClass::create($validated['formData']))
                : null;
        } else {
            $model = $modelClass::findOrFail($this->modelId);
            $model->update($validated['formData']);
        }

        // Emit event so other components (e.g. ProjectManager) can refresh
        $this->emit('formSubmitted');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modal-form');
    }
}