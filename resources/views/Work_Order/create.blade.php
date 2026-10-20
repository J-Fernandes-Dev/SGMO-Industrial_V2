@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Cabeçalho -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Registar Nova Ordem de Trabalho</h1>
        <p class="text-sm text-slate-500">Abra uma nova ocorrência de manutenção para intervenção no parque de máquinas.</p>
    </div>

    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <form action="{{ route('work_order.store') }}" method="POST">
            @csrf

            <!-- Seleção da Máquina -->
            <div class="mb-4">
                <label for="machine_id" class="block text-sm font-medium text-slate-700 mb-1">Centro CNC / Máquina</label>
                <select name="machine_id" id="machine_id" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-600 text-sm">
                    <option value="">Selecione a máquina afetada...</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">{{ $machine->code }} - {{ $machine->brand }} {{ $machine->model }} ({{ $machine->section->name ?? 'Sem Secção' }})</option>
                    @endforeach
                </select>
                @error('machine_id')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <!-- Tipo de Intervenção -->
                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 mb-1">Tipo de Manutenção</label>
                    <select name="type" id="type" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="corretiva">Corretiva (Avariada / Reparação)</option>
                        <option value="preventiva">Preventiva (Revisão Agendada)</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prioridade -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-slate-700 mb-1">Prioridade</label>
                    <select name="priority" id="priority" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="baixa">Baixa</option>
                        <option value="media" selected>Média</option>
                        <option value="alta">Alta</option>
                        <option value="critica">Crítica (Paragem Total)</option>
                    </select>
                    @error('priority')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descrição Detalhada da Avaria -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Descrição do Problema / Sintoma</label>
                <textarea name="description" id="description" rows="4" required placeholder="Descreva detalhadamente o comportamento da máquina, códigos de erro no painel ou sintomas detetados..." class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                @error('description')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('work_order.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2 px-4 rounded-lg text-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm shadow-sm transition">
                    Registar Ordem de Trabalho
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
