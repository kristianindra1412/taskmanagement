<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        table {
            width: 600px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background: #f5f5f5;
        }
    </style>
</head>
<body>

    <h1>Task List</h1>

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
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->created_at }}</td>
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