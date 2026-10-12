<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MachineController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

const PROFILE_PATH = '/profile';

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas protegidas por Autenticação
Route::middleware(['auth'])->group(function () {
    
    // Ver e criar/editar máquinas disponível para utilizadores autenticados
    Route::resource('machines', MachineController::class)->except(['destroy']);

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
