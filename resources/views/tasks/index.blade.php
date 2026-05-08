<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
</head>
<body>

    <h1>Task List</h1>

    <div class="action">
        <a href="{{ route('tasks.create') }}"><button>+ Create New Task</button></a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Priority</th>
                <th>Task Name</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td style="text-align: right;">{{ $task->priority }}</td>
                    <td>{{ $task->name }}</td>
                    <td style="text-align: right;">{{ $task->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        No tasks found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>