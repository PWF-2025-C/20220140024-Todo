<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/pzn', function (){
    return "Hello Programmer Zaman Now";
});

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route (Requires auth and email verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Authenticated User Routes
Route::middleware(['auth','verified'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Todo Routes (excluding 'show')
    Route::resource('todo', TodoController::class)->except(['show']);
    Route::delete('/todo', [TodoController::class, 'deleteAllCompleted'])->name('todo.deleteallcompleted');
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');

     Route::resource('category', CategoryController::class);

    // Admin user list (tambahan dari kode 2, hati-hati jika bentrok)
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
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

// Tambahan route Todo dari kode 2 (di luar group agar tetap tersedia)
Route::get('/todos', [TodoController::class, 'index'])->name('todo.list');
Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
Route::patch('/todo/{todo}', [TodoController::class, 'update'])->name('todo.manual.update');


require __DIR__.'/auth.php';
