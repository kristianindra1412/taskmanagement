<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('priority')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
{
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // next priority = current max + 1
        $nextPriority = (Task::max('priority') ?? 0) + 1;

        Task::create([
            'name' => $validated['name'],
            'priority' => $nextPriority,
        ]);

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $task->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('tasks.index');
    }

    public function delete(Task $task)
    {
        $task->delete();

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
