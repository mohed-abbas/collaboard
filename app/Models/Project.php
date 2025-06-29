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
        return $this->hasMany(\App\Models\Category::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(\App\Models\Task::class, \App\Models\Category::class);
    }
}
