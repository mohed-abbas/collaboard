<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use App\Models\User;


class ProjectSettings extends Component
{
    public $project;
    public $projectName;
    public $projectDescription;
    public $members = [];
    public $searchMember = '';
    public $searchResults = [];
    public $showSearchResults = false;

    protected function rules()
    {
        return [
            'projectName' => 'required|string|max:255',
            'projectDescription' => 'nullable|string',
            'members' => 'array',
        ];
    }

    public function saveSettings()
    {
        $this->validate();
        try {
            $this->project->name = $this->projectName;
            $this->project->description = $this->projectDescription;
            $this->project->save();

            session()->flash('success', 'Project settings updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update project settings.');
        }
        $this->members = $this->getMembers(); // Refresh members list
    }

    public function mount($project)
    {
        $this->project = Project::findOrFail($project);
        $this->projectName = $this->project->name;
        $this->projectDescription = $this->project->description;
        $this->members = $this->getMembers();
    }

    private function getMembers()
    {
        $query = $this->project->members();
        if (!empty($this->searchMember)) {
            $query->where('email', 'like', '%' . $this->searchMember . '%');
        }
        return $query->get();
    }

    public function updatedSearchMember()
    {
        if (strlen($this->searchMember) >= 2) {
            $this->searchResults = User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchMember . '%')
                    ->orWhere('email', 'like', '%' . $this->searchMember . '%');
            })
                ->whereNotIn('id', $this->members->pluck('id')->toArray()) // Exclude already added members
                ->limit(10)
                ->get();

            $this->showSearchResults = true;
        } else {
            $this->searchResults = [];
            $this->showSearchResults = false;
        }
    }

    public function addMemberToProject($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Check if user is already a member
            if ($this->project->members()->where('user_id', $userId)->exists()) {
                session()->flash('error', 'User is already a member of this project.');
                return;
            }

            // Add user to project
            $this->project->members()->attach($userId);

            // Refresh members list
            $this->members = $this->project->members;

            // Clear search
            $this->searchMember = '';
            $this->searchResults = [];
            $this->showSearchResults = false;

            session()->flash('success', $user->name . ' has been added to the project.');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add member to project.');
        }
    }

    public function removeMember($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Remove user from project
            $this->project->members()->detach($userId);

            // Refresh members list
            $this->members = $this->project->members;

            session()->flash('success', $user->name . ' has been removed from the project.');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove member from project.');
        }
    }

    // Add this method to hide search results when clicking outside
    public function hideSearchResults()
    {
        $this->showSearchResults = false;
    }

    public function render()
    {
        return view('livewire.project-settings');
    }
}