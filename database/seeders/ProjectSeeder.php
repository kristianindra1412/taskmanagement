<?php

namespace Database\Seeders;

use App\Models\Project;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            ['name' => 'Website Redesign'],
            ['name' => 'Mobile App'],
            ['name' => 'Internal Tools'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
