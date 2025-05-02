<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
