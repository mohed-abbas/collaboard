<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MemberNotification;
use Livewire\Attributes\On;

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

    protected $messages = [
        'projectName.required' => 'Le nom du projet est requis.',
        'projectName.string' => 'Le nom du projet doit être une chaîne de caractères.',
        'projectDescription.string' => 'La description du projet doit être une chaîne de caractères.',
    ];


    public function saveSettings()
    {
        $this->validate();

        // Check if the user has permission to update project settings
        if (!Auth::user()->can('update', $this->project)) {
            session()->flash('error', 'Vous n\'avez pas la permission de mettre à jour les paramètres du projet.');
            $this->addError('projectName', 'Vous n\'avez pas la permission de mettre à jour les paramètres du projet.');
            return;
        }

        try {
            $this->project->name = $this->projectName;
            $this->project->description = $this->projectDescription;
            $this->project->save();
            session()->flash('success', 'Paramètres du projet mis à jour avec succès.');
            $this->dispatch('reloadProjects'); // Notify other components to reload projects
        } catch (\Exception $e) {
            session()->flash('error', 'Échec de la mise à jour des paramètres du projet.');
        }
        $this->members = $this->getMembers(); // Refresh members list
    }

    public function mount($project)
    {

        // Check if the user has permission to view the project
        if (!Auth::user()->can('viewSettings', Project::find($project))) {
            session()->flash('error', 'Vous n\'avez pas la permission de voir ce projet.');
            return redirect()->route('project.board', $project); //Redirect to project board page.
        }

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

    /**
     * This method is called whenever the searchMember property is updated.
     * It searches for users based on the input and updates the searchResults.
     */
    public function updatedSearchMember()
    {

        // Check if the user has the permission to search members
        if (!Auth::user()->can('manageMembership', $this->project)) {
            session()->flash('error', 'Vous n\'avez pas la permission de gérer les membres du projet.');
            $this->searchResults = [];
            $this->showSearchResults = false;
            $this->addError('newMemberEmail', 'Vous n\'avez pas la permission de gérer les membres du projet.');
        } else {
            $this->searchResults = User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchMember . '%')
                    ->orWhere('email', 'like', '%' . $this->searchMember . '%');
            })
                ->whereNotIn('id', $this->members->pluck('id')) // Exclude already added members
                ->limit(10)
                ->get();
            $this->showSearchResults = true;
        }
    }

    public function addMemberToProject($userId)
    {
        // Check if the user has permission to manage members
        if (!Auth::user()->can('manageMembership', $this->project)) {
            session()->flash('error', 'Vous n\'avez pas la permission de gérer les membres du projet.');
            $this->addError('newMemberEmail', 'Vous n\'avez pas la permission de gérer les membres du projet.');
            $this->searchResults = [];
            $this->showSearchResults = false;
            return;
        }


        $user = User::findOrFail($userId);
        // Check if user is already a member
        if ($this->project->members()->where('user_id', $userId)->exists()) {
            session()->flash('error', '' . $user->name . ' est déjà membre du projet.');
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

        // Send the notification to the user.
        $user->notify(new MemberNotification($this->project, $user, Auth::user(), 'added'));


        // Flash success message
        session()->flash('success', $user->name . ' a été ajouté au projet.');
    }

    public function removeMember($userId)
    {
        if (!Auth::user()->can('manageMembership', $this->project)) {
            session()->flash('error', 'Vous n\'avez pas la permission de gérer les membres du projet.');
            $this->addError('newMemberEmail', 'Vous n\'avez pas la permission de gérer les membres du projet.');
            $this->searchResults = [];
            $this->showSearchResults = false;
            return;
        }
        $user = User::findOrFail($userId);
        $this->project->members()->detach($userId);
        $this->members = $this->getMembers(); // Refresh members list

        // Clear search
        $this->searchMember = '';
        $this->searchResults = [];
        $this->showSearchResults = false;

        // Send the notification to the user.
        $user->notify(new MemberNotification($this->project, $user, Auth::user(), 'removed'));

        session()->flash('success', 'Membre supprimé avec succès.');
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