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

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_creator');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}