<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
