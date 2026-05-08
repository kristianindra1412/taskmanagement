<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Prepare interview project',
                'priority' => 1,
                'project_id' => 1,
            ],
            [
                'name' => 'Create database migration',
                'priority' => 2,
                'project_id' => 1,
            ],
            [
                'name' => 'Implement drag and drop',
                'priority' => 3,
                'project_id' => 2,
            ],
            [
                'name' => 'Add task edit feature',
                'priority' => 4,
                'project_id' => 2,
            ],
            [
                'name' => 'Write README documentation',
                'priority' => 5,
                'project_id' => 3,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
