<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
</head>
<body>

    <h1>Task List</h1>

    <div class="action">
        <a href="{{ route('tasks.create') }}"><button class="btn btn-success">+ Create New Task</button></a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Actions</th>                
                <th>Priority</th>
                <th>Task Name</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td style="text-align: center;">
                        <a href="{{ route('tasks.edit', $task) }}"><button class="btn btn-primary">> Edit</button></a>
                        <form method="POST" action="{{ route('tasks.delete', $task) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">
                                X Delete
                            </button>
                        </form>
                    </td>                    
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