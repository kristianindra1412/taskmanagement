<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
</head>
<body>

    <h1>Edit Task</h1>

    <div class="action">
        <a href="{{ route('tasks.index') }}"><button class="btn btn-warning">< Back</button></a>
    </div>    
    

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <div class="form">
            <label>Task name</label><br>
            <input type="text" name="name" value="{{ old('name', $task->name) }}" placeholder="Put your task here" required>

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <button type="submit" class="btn btn-success">Update</button>
        </div>    
    </form>

</body>
</html>