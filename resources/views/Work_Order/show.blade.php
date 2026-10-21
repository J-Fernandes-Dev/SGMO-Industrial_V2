@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Cabeçalho -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('work_order.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition flex items-center mb-1">
                &larr; Voltar às Ordens de Trabalho
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Ordem de Trabalho #{{ $workOrder->id }}</h1>
        </div>

        <!-- Estado -->
        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full 
            {{ $workOrder->status == 'pendente' ? 'bg-amber-100 text-amber-800' : '' }}
            {{ $workOrder->status == 'em_andamento' ? 'bg-blue-100 text-blue-800' : '' }}
            {{ $workOrder->status == 'concluida' ? 'bg-emerald-100 text-emerald-800' : '' }}
            {{ $workOrder->status == 'cancelada' ? 'bg-red-100 text-red-800' : '' }}">
            {{ ucfirst(str_replace('_', ' ', $workOrder->status)) }}
        </span>
    </div>

    <!-- Detalhes da Ocorrência -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6">

        <!-- Informação da Máquina Afetada -->
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Equipamento Afetado</h2>
            <p class="text-base font-bold text-slate-900">{{ $workOrder->machine->code ?? 'N/D' }} - {{ $workOrder->machine->brand }} {{ $workOrder->machine->model }}</p>
            <p class="text-sm text-slate-600">Secção: {{ $workOrder->machine->section->name ?? 'N/D' }}</p>
        </div>

        <!-- Dados da Abertura -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-slate-200 pb-4">
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase">Tipo de Manutenção</span>
                <span class="text-sm font-medium text-slate-800 capitalize">{{ $workOrder->type }}</span>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase">Prioridade</span>
                <span class="text-sm font-medium text-slate-800 capitalize">{{ $workOrder->priority }}</span>
            </div>
            <div>
                <span class="block text-xs font-semibold text-slate-400 uppercase">Aberta por</span>
                <span class="text-sm font-medium text-slate-800">{{ $workOrder->creator->name ?? 'Sistema' }}</span>
            </div>
        </div>

        <!-- Descrição do Problema -->
        <div>
            <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Descrição do Sintoma / Problema</h2>
            <div class="bg-slate-50 rounded-lg p-4 text-sm text-slate-700 border border-slate-100">
                {{ $workOrder->description }}
            </div>
        </div>
        <a href="{{ route('work_order.edit', $workOrder) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-sm transition">
            Editar / Fechar OT
</a>

        <!-- Relatório Técnico (se já estiver concluída ou em andamento) -->
        @if($workOrder->technical_report)
            <div>
                <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Relatório Técnico da Intervenção</h2>
                <div class="bg-emerald-50 rounded-lg p-4 text-sm text-emerald-900 border border-emerald-100">
                    {{ $workOrder->technical_report }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
