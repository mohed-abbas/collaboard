<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'owner_id'];

    // Owner relation (the user who created it)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Members relation (users who belong to it)
    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('position'); // Order categories by sort_order
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Category::class);
    }
    /**
     * Get all the labels associated with this project.
     */
    public function labels()
    {
        return $this->hasMany(Label::class)->orderBy('name'); // Order labels by name
    }

    public function getStatsAttribute()
    {
        $tasks = $this->tasks()->get();
        return [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('is_done', true)->count(),
            'pending_tasks' => $tasks->where('is_done', false)->count(),
            'overdue_tasks' => $tasks->where('deadline', '<', now())->where('is_done', false)->count(),
        ];
    }

    /**
     * Check if a user is a member of the project.
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if a user is the owner of the project.
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    /**
     * Get tasks grouped by category with labels.
     */
    public function getTasksByCategory()
    {
        return $this->categories()
            ->with([
                'tasks' => function ($query) {
                    $query->with(['labels', 'users'])->orderBy('position');
                }
            ])
            ->get();
    }

}