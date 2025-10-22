<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

// --- Ruta inicial ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- Autenticación ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Rutas protegidas ---
Route::middleware('auth')->group(function () {
    // CRUD de trainers
    Route::resource('trainers', TrainerController::class);

    // Eliminación permanente
    Route::delete('/trainers/{id}/force', [TrainerController::class, 'forceDestroy'])
        ->name('trainers.force-destroy');
});

Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
