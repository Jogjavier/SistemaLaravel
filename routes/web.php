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
    
    // Custom trainer routes (MUST be BEFORE resource route)
    Route::get('/trainers/trashed', [TrainerController::class, 'trashed'])->name('trainers.trashed');
    Route::post('/trainers/empty-trash', [TrainerController::class, 'emptyTrash'])->name('trainers.emptyTrash');
    Route::get('/trainers/pdf-all', [TrainerController::class, 'downloadPdf'])->name('trainers.pdf.all');
    
    // CRUD de trainers (Resource route)
    Route::resource('trainers', TrainerController::class);
    
    // Routes with {id} parameter (MUST be AFTER resource route to avoid conflicts)
    Route::get('/trainers/{id}/pdf', [TrainerController::class, 'downloadPdf'])->name('trainers.pdf');
    Route::delete('/trainers/{id}/force', [TrainerController::class, 'forceDestroy'])->name('trainers.force-destroy');
});

// PDF Controller route (if still needed)
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);