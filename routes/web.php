<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route (Requires auth and email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Todo Routes (excluding 'show')
    Route::resource('todo', TodoController::class)->except(['show']);
    // Additional todo actions
    Route::delete('/todo', [TodoController::class, 'deleteAllCompleted'])->name('todo.deleteallcompleted');
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // User Routes
    Route::resource('user', UserController::class)->except(['show']);
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    
    // Category Routes
    Route::resource('category', CategoryController::class);
});

// Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
