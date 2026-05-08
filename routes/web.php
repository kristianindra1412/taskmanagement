<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/tasks');
})->name('home');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';

