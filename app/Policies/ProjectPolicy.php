<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any projects.
     */
    // Can the user view this project?
    public function view(User $user, Project $project): bool
    {
        return $user->id === $project->owner_id || $project->members->contains($user);
    }


    // Can the user update this project?
    public function update(User $user, Project $project): bool
    {
        // Maybe only owners can change project details:
        return $user->id === $project->owner_id;
    }

    // Can the user delete this project?
    public function delete(User $user, Project $project): bool
    {
        // Same as update:
        return $user->id === $project->owner_id;
    }

    // Optionally, can the user attach/detach members?
    public function manageMembership(User $user, Project $project): bool
    {
        return $user->id === $project->owner_id;
    }

    public function viewSettings(User $user, Project $project): bool
    {
        // Allow viewing settings if the user is the owner or a member of the project
        return $user->id === $project->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }


}