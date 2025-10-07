<?php

use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('trainers.index');
});

// Rutas principales con slug
Route::resource('trainers', TrainerController::class);

// Búsqueda
Route::get('/trainers-search', [TrainerController::class, 'search'])->name('trainers.search');

// Rutas para administración de eliminados - CORREGIDAS
Route::delete('/trainers/{id}/force', [TrainerController::class, 'forceDestroy'])
    ->name('trainers.force-destroy');

// Rutas CRUD estándar
Route::resource('trainers', TrainerController::class);
