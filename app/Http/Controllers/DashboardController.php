<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer tous les projets de l'utilisateur connecté
        $projects = auth()->check() 
            ? Project::where('user_id', auth()->id())->latest()->get() 
            : collect();
        
        return view('dashboard', compact('projects'));
    }
}