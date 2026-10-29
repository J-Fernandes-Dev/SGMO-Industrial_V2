<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MachineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;

const PROFILE_PATH = '/profile';

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas protegidas por Autenticação
Route::middleware(['auth'])->group(function () {

// 5. Gestão de Ordem de Trabalho
    Route::resource('work_order', WorkOrderController::class);


    // Adiciona esta linha para definir a rota 'dashboard'
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // 1. Visualização do Parque de Máquinas (Operadores, Técnicos e Responsáveis)
   Route::get('/machines', [MachineController::class, 'index'])->name('machines.index');

// 2. Rotas de criação e ações exclusivas ( SÃO ROTAS ESTÁTICAS E DEVEM VIR ANTES DE /{machine})
Route::middleware(['role:responsavel'])->group(function () {
    Route::get('/machines/create', [MachineController::class, 'create'])->name('machines.create');
    Route::post('/machines', [MachineController::class, 'store'])->name('machines.store');
    Route::get('/machines/{machine}/edit', [MachineController::class, 'edit'])->name('machines.edit');
    Route::put('/machines/{machine}', [MachineController::class, 'update'])->name('machines.update');
    Route::delete('/machines/{machine}', [MachineController::class, 'destroy'])->name('machines.destroy');
});

    // 3. Ver detalhes de uma máquina específica (Vem DEPOIS das rotas estáticas)
    Route::get('/machines/{machine}', [MachineController::class, 'show'])->name('machines.show');

    // 3. Apenas Operador e Técnico podem alterar o estado da máquina
    Route::patch('/machines/{machine}/status', [MachineController::class, 'updateStatus'])
        ->middleware('role:operador,tecnico')
        ->name('machines.update-status');

    // 4. Gestão de Perfil do Utilizador
    Route::get(PROFILE_PATH, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILE_PATH, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILE_PATH, [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
