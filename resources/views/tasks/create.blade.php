<!DOCTYPE html>
<html>
<head>
    <title>Create New Task</title>
    <link rel="stylesheet" href="{{ asset('css/task.css') }}">
</head>
<body>

    <h1>Create New Task</h1>

    <div class="action">
        <a href="{{ route('tasks.index') }}"><button class="btn btn-warning">< Back</button></a>
    </div>    
    

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="form">
            <label>Project</label><br>

            <select name="project_id">
                <option value="">(No project)</option>

                @foreach ($projects as $project)
                    <option
                        value="{{ $project->id }}"
                        @selected((int) old('project_id') === $project->id)
                    >
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>

            @error('project_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form">
            <label>Task name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Put your task here" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <button type="submit" class="btn btn-success">Save</button>
        </div>    
    </form>

</body>
</html>