<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Task::create([
            'status' => 'done',
            'priority' => 1,
            'title' => 'Root Task',
            'description' => 'Don\'t delete',
            'parent_id' => null,
            'user_id' => null,
        ]);
    }
}
