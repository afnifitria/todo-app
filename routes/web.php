<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use Illuminate\Support\Facades\Route;

// Membuat route untuk home yang akan menampilkan halaman utama
Route::get('/', [TaskController::class, 'index'])->name('home');

// Mendefinisikan resource route untuk TaskListController
// Route ini akan otomatis menangani operasi CRUD untuk TaskList (index, create, store, show, edit, update, destroy)
Route::resource('lists', TaskListController::class);

// Mendefinisikan resource route untuk TaskController
// Route ini akan otomatis menangani operasi CRUD untuk Task (index, create, store, show, edit, update, destroy)
Route::resource('tasks', TaskController::class);

// Membuat route khusus untuk menyelesaikan task (mark as complete)
// Menggunakan method PATCH untuk mengupdate status task menjadi selesai
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

// Membuat route khusus untuk mengubah list tempat task berada
// Menggunakan method PATCH untuk mengupdate task dengan list baru
Route::patch('/tasks/{task}/change-list', [TaskController::class, 'changeList'])->name('tasks.changeList');
