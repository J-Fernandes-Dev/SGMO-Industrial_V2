@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Cabeçalho -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Intervenção / Fecho da Ordem de Trabalho #{{ $workOrder->id }}</h1>
        <p class="text-sm text-slate-500">Registe o relatório técnico, atribua o técnico e atualize o estado da máquina.</p>
    </div>

    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <form action="{{ route('work_order.update', $workOrder) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Informação da Máquina (Apenas leitura) -->
            <div class="mb-4 bg-slate-50 p-4 rounded-lg border border-slate-100">
                <span class="block text-xs font-semibold text-slate-400 uppercase">Equipamento</span>
                <span class="text-sm font-bold text-slate-800">{{ $workOrder->machine->code }} - {{ $workOrder->machine->brand }} {{ $workOrder->machine->model }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <!-- Estado da OT -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Estado da Intervenção</label>
                    <select name="status" id="status" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="pendente" {{ $workOrder->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em_andamento" {{ $workOrder->status == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluida" {{ $workOrder->status == 'concluida' ? 'selected' : '' }}>Concluída (Reparado)</option>
                        <option value="cancelada" {{ $workOrder->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <!-- Atribuir Técnico -->
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-1">Técnico Responsável</label>
                    <select name="assigned_to" id="assigned_to" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Selecione o técnico...</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ $workOrder->assigned_to == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Horas de Paragem (Downtime) -->
            <div class="mb-4">
                <label for="downtime_hours" class="block text-sm font-medium text-slate-700 mb-1">Horas de Paragem (Downtime)</label>
                <input type="number" step="0.5" name="downtime_hours" id="downtime_hours" value="{{ $workOrder->downtime_hours }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Ex: 2.5">
                <p class="text-xs text-slate-400 mt-1">Essencial para o cálculo de KPIs industriais de disponibilidade no Mês 3.</p>
            </div>

            <!-- Relatório Técnico -->
            <div class="mb-6">
                <label for="technical_report" class="block text-sm font-medium text-slate-700 mb-1">Relatório Técnico / Ações Efetuadas</label>
                <textarea name="technical_report" id="technical_report" rows="4" placeholder="Descreva a reparação efetuada, peças substituídas ou ajustes realizados..." class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $workOrder->technical_report }}</textarea>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('work_order.show', $workOrder) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2 px-4 rounded-lg text-sm transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm shadow-sm transition">
                    Guardar Intervenção
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
