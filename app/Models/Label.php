<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'color',
        'project_id',
    ];

    protected $casts = [
        'project_id' => 'integer', // Ensure project_id is stored as an integer
    ];

    /**
     * Get the project that owns the label.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Project, Label>
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The tasks that have this label.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Task, Label>
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_label')
            ->withTimestamps();
    }
    /**
     * Scope a query to only include labels for a given project.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $projectId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Get the display name for the label with color indicator.
     * @return string
     */

    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    /**
     * Check if the label has valid hex color format.
     */

    public function hasValidColor()
    {
        return preg_match('/^#[0-9A-Fa-f]{6}$/', $this->color) === 1;
    }
}