<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display the project board.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function board(Project $project)
    {
        // Make sure the user has access to this project
        if (!auth()->user()->can('view', $project)) {
            abort(403);
        }
        
        return view('projects.board', compact('project'));
    }
}