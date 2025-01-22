<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

// Botón de "Crear Nuevo" → formulario
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
// Guardar el nuevo usuario
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Editar usuario → mismo formulario
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
// Actualizar usuario
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

// Eliminar usuario
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';





