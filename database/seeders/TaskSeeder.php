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
            ],
            [
                'name' => 'Create database migration',
                'priority' => 2,
            ],
            [
                'name' => 'Implement drag and drop',
                'priority' => 3,
            ],
            [
                'name' => 'Add task edit feature',
                'priority' => 4,
            ],
            [
                'name' => 'Write README documentation',
                'priority' => 5,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
