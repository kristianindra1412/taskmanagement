<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">

    <!-- SortableJS for drag-and-drop reordering -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <tbody id="task-list">
            @forelse ($tasks as $task)
                <tr data-id="{{ $task->id }}">
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
                    <td style="text-align: right;" data-col="priority">{{ $task->priority }}</td>
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

<script>
    const taskList = document.getElementById('task-list');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    new Sortable(taskList, {
        animation: 150,
        onEnd: async () => {
            const ids = Array.from(taskList.querySelectorAll('tr'))
                .map(row => Number(row.dataset.id));

            const res = await fetch("{{ route('tasks.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: JSON.stringify({ ids })
            });

            if (!res.ok) {
                alert("Reorder failed. The page will be refreshed, please try again.");
                location.reload();
                return;
            }

            // update priority numbers in the table without reload
            Array.from(taskList.querySelectorAll('tr')).forEach((row, i) => {
                row.querySelector('[data-col="priority"]').textContent = i + 1;
            });
        }
    });
</script>

</body>
</html>