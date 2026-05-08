<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $projectId = $request->integer('project_id'); // null if not present / invalid

        $tasksQuery = Task::query();

        if ($projectId) {
            $tasksQuery->where('project_id', $projectId);
        }

        $tasks = $tasksQuery->with('project')->orderBy('priority')->get();

        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();

        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
        ]);

        $projectId = $validated['project_id'] ?? null;

        // next priority = current max + 1
        $nextPriority = (Task::max('priority') ?? 0) + 1;

        Task::create([
            'name' => $validated['name'],
            'priority' => $nextPriority,
            'project_id' => $projectId,
        ]);

        return redirect()->route('tasks.index', [
            'project_id' => $projectId, // keep filter UX
        ]);
    }

    public function edit(Task $task)
    {
        $projects = Project::orderBy('name')->get();
        
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
        ]);

        $projectId = $validated['project_id'] ?? null;

        $task->update([
            'name' => $validated['name'],
            'project_id' => $projectId,
        ]);

        return redirect()->route('tasks.index', [
            'project_id' => $projectId, // keep filter UX
        ]);        
    }

    public function delete(Task $task)
    {
        DB::transaction(function () use ($task) {
            $task->delete();

            // Handling if middle priority is deleted, we need to reassign priorities to maintain contiguous order.
            $tasks = Task::orderBy('priority')->get(['id']);

            foreach ($tasks as $index => $t) {
                Task::where('id', $t->id)->update([
                    'priority' => $index + 1,
                ]);
            }
        });

        return redirect()->route('tasks.index');
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'distinct', 'exists:tasks,id'],
        ]);

        $ids = array_values($data['ids']);

        // Reorder expects the full list so final priorities stay unique and contiguous.
        if (count($ids) !== Task::count()) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid reorder payload.',
            ], 422);
        }

        DB::transaction(function () use ($ids) {
            $temporaryStart = (Task::max('priority') ?? 0) + count($ids) + 1000;

            // First pass: move all rows to a safe temporary range to avoid unique collisions.
            foreach ($ids as $index => $id) {
                Task::where('id', $id)->update([
                    'priority' => $temporaryStart + $index,
                ]);
            }

            // Second pass: assign final contiguous priorities.
            foreach ($ids as $index => $id) {
                Task::where('id', $id)->update([
                    'priority' => $index + 1,
                ]);
            }
        });

        return response()->json(['ok' => true]);
    }
}
