<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
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

        // Attacher la task 1 au user 1
        $task = Task::find(1);
        $user = User::find(1);

        if (!$task || !$user) {
            throw new \Exception("La tâche ou l'utilisateur avec l'ID 1 n'existe pas.");
        }

        // Lier la tâche au user 1 comme créateur
        $task->users()->attach($user->id, ['is_creator' => true]);
    }
}
