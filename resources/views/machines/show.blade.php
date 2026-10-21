@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Cabeçalho com Botão de Voltar -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('machines.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition flex items-center mb-1">
                &larr; Voltar ao Parque de Máquinas
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Ficha Técnica: {{ $machine->code }}</h1>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Estado Atual -->
            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full 
                {{ $machine->status == 'operacional' ? 'bg-emerald-100 text-emerald-800' : '' }}
                {{ $machine->status == 'manutencao' ? 'bg-amber-100 text-amber-800' : '' }}
                {{ $machine->status == 'avariada' ? 'bg-rose-100 text-rose-800' : '' }}">
                {{ ucfirst($machine->status) }}
            </span>

            @if(auth()->user()->role === 'responsavel')
                <a href="{{ route('machines.edit', $machine) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm py-2 px-4 rounded-lg shadow-sm transition">
                    Editar Máquina
                </a>
            @endif
        </div>
    </div>

    <!-- Grelha de Informações da Máquina -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Cartão de Informação Geral -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 col-span-2">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3 mb-4">Informação Geral</h2>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-xs font-semibold text-slate-500 uppercase">Código Interno</dt>
                    <dd class="text-sm font-bold text-slate-900 mt-1">{{ $machine->code }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-slate-500 uppercase">Secção Fabril</dt>
                    <dd class="text-sm text-slate-800 mt-1">{{ $machine->section->name ?? 'Sem Secção' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-slate-500 uppercase">Marca / Modelo</dt>
                    <dd class="text-sm text-slate-800 mt-1">{{ $machine->brand }} {{ $machine->model }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-slate-500 uppercase">Número de Série</dt>
                    <dd class="text-sm text-slate-800 mt-1 font-mono">{{ $machine->serial_number ?? 'N/D' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Cartão de Componentes Registados -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3 mb-4">Componentes Críticos</h2>

            <ul class="divide-y divide-slate-100">
                @forelse($machine->components as $component)
                    <li class="py-2.5 flex justify-between items-center text-sm">
                        <span class="font-medium text-slate-700">{{ $component->name }}</span>
                        <span class="text-xs text-slate-400 font-mono">{{ $component->part_number ?? 'S/N' }}</span>
                    </li>
                @empty
                    <p class="text-sm text-slate-500 italic py-2">Nenhum componente registado para este equipamento.</p>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Tabela de Histórico de Ordens de Trabalho (Manutenções) -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
            <h2 class="text-base font-bold text-slate-900">Histórico de Ordens de Trabalho / Manutenções</h2>
            <a href="{{ route('work-orders.create') }}" class="text-xs bg-slate-800 text-white hover:bg-slate-700 px-3 py-1.5 rounded transition">
                + Abrir OT nesta máquina
            </a>
        </div>

        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold uppercase">ID</th>
                    <th class="px-6 py-3 text-xs font-semibold uppercase">Tipo</th>
                    <th class="px-6 py-3 text-xs font-semibold uppercase">Prioridade</th>
                    <th class="px-6 py-3 text-xs font-semibold uppercase">Estado</th>
                    <th class="px-6 py-3 text-xs font-semibold uppercase">Descrição</th>
                    <th class="px-6 py-3 text-xs font-semibold uppercase">Data</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($machine->workOrders as $wo)
                    <tr class="hover:bg-slate-50 transition text-sm">
                        <td class="px-6 py-4 font-bold text-slate-900">#{{ $wo->id }}</td>
                        <td class="px-6 py-4 capitalize text-slate-700">{{ $wo->type }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                {{ $wo->priority == 'critica' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($wo->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                {{ $wo->status == 'concluida' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 truncate max-w-xs">{{ $wo->description }}</td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $wo->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-500 text-sm">
                            Sem registos de manutenção no histórico desta máquina.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
