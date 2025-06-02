<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'owner_id',  // Ajoutez cette ligne
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}