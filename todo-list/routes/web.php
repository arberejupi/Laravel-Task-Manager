<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/todo', function () {
    return view('todo');
})->middleware(['auth', 'verified'])->name('todo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/todo', [TaskController::class, 'showAllTasks'])->name('todo');
    Route::get('/todo/filter', [TaskController::class, 'filterTasks'])->name('tasks.filter');
    Route::post('/todo', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/todo/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/todo/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');


});

require __DIR__.'/auth.php';
