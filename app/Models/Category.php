<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'project_id',
        'is_system', // Indicates if this is a system category
        'position', // Position for drag-and-drop sorting
        'color', // Optional color for the category
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the tasks witht their labels and users.
     * This method can be used to fetch tasks with their associated labels and users.
     */

    public function tasksWithRelations()
    {
        return $this->hasMany(Task::class)
            ->with(['labels', 'users']);
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }
    /**
     * Get the number of pending tasks in this category.
     */
    public function getPendingTasksCountAttribute(): int
    {
        return $this->tasks()->where('is_done', false)->count();
    }

    /**
     * Get the total number of tasks in this category.
     */
    public function getTotalTasksCountAttribute(): int
    {
        return $this->tasks()->count();
    }
}