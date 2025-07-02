<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_done',
        'category_id',
        'created_by',
        'deadline',
        'priority_level',
        'position',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_done' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_creator');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all labels assigned to this task.
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label')
            ->withTimestamps();
    }

    /**
     * Get the creator of the task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if the task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->deadline && $this->deadline->isPast() && !$this->is_done;
    }

    /**
     * Get the task's priority level as a string.
     */
    public function getPriorityTextAttribute(): string
    {
        return match ($this->priority_level) {
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
            4 => 'Critical',
            default => 'Unknown'
        };
    }


    /**
     * Get the task's status as a string.
     */
    public function getStatusAttribute(): string
    {
        if ($this->is_done) {
            return 'Completed';
        }

        if ($this->isOverdue()) {
            return 'Overdue';
        }

        return 'Pending';
    }

    /**
     * Scope to get tasks with their labels.
     */
    public function scopeWithLabels($query)
    {
        return $query->with('labels');
    }

    /**
     * Scope to get tasks by label.
     */
    public function scopeByLabel($query, $labelId)
    {
        return $query->whereHas('labels', function ($q) use ($labelId) {
            $q->where('labels.id', $labelId);
        });
    }

    /**
     * Scope to get completed tasks.
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_done', true);
    }

    /**
     * Scope to get pending tasks.
     */
    public function scopePending($query)
    {
        return $query->where('is_done', false);
    }

    /**
     * Scope to get overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
            ->where('is_done', false);
    }

    /**
     * Check if the task has a specific label.
     */
    public function hasLabel($labelId): bool
    {
        return $this->labels()->where('labels.id', $labelId)->exists();
    }

    /**
     * Get labels as a comma-separated string.
     */
    public function getLabelsTextAttribute(): string
    {
        return $this->labels->pluck('name')->join(', ');
    }
}