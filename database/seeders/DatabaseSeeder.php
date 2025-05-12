<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        
        // Create a project first (required for categories)
        $project = Project::factory()->create([
            'created_by' => 1, // First user is the creator
        ]);

        // Create a category belonging to the created project
        $category = Category::factory()->create([
            'project_id' => $project->id,
        ]);

        // Create a task belonging to the created category
        $task = Task::factory()->create([
            'category_id' => $category->id,
        ]);

        // Attacher la task au user 1
        $user = User::find(1);

        if (!$user) {
            throw new \Exception("L'utilisateur avec l'ID 1 n'existe pas.");
        }

        // Lier la tâche au user 1 comme créateur
        $task->users()->attach($user->id, ['is_creator' => true]);
    }
}
