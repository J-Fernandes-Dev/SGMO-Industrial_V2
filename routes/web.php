<?php

use App\Http\Controllers\MachineController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

const PROFILE_PATH = '/profile';

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas protegidas por Autenticação
Route::middleware(['auth'])->group(function () {

    // Todos os utilizadores autenticados podem consultar máquinas.
    Route::resource('machines', MachineController::class)
        ->except(['destroy'])
        ->middlewareFor(['create', 'store', 'edit', 'update'], 'role:responsavel');

    Route::patch('machines/{machine}/status', [MachineController::class, 'updateStatus'])
        ->middleware('role:operador')
        ->name('machines.update-status');

    // Apenas o Responsável pode ELIMINAR máquinas
    Route::delete('machines/{machine}', [MachineController::class, 'destroy'])
        ->middleware('role:responsavel')
        ->name('machines.destroy');
});

Route::get('/dashboard', function () {
    return redirect()->route('machines.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get(PROFILE_PATH, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILE_PATH, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILE_PATH, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
