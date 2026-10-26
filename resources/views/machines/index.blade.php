@extends('layouts.app')

@section('content')
<!-- Reduzimos o padding-top de 'py-6' para 'pt-2', mantendo 'pb-6' -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 pt-0 pb-6">

    <!-- Cabecalho da Página e Botão Adicionar -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="ml-20 text-3xl font-bold text-slate-500">Gestão de Máquinas</h1>

        @if(auth()->user()->role === 'responsavel')
            <a href="{{ route('machines.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium mr-5 py-2 px-4 rounded transition-transform duration-200 hover:scale-110">
            + Adicionar Nova Máquina
        </a>
        @endif
    </div>
    <!-- Tabela de Máquinas -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">

            <!-- Cabeçalho da Tabela -->
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Código</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Marca / Modelo</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Secção</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Nº Série</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Ações</th>
                </tr>
            </thead>

            <!-- Corpo da Tabela -->
            <tbody class="divide-y divide-slate-200">
                @forelse($machines as $machine)
                    <tr class="hover:bg-slate-50 transition">

                        <!-- Código -->
                        <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                            {{ $machine->code }}
                        </td>

                        <!-- Marca / Modelo -->
                        <td class="px-6 py-4 text-slate-600">
                            {{ $machine->brand }} {{ $machine->model }}
                        </td>

                        <!-- Secção -->
                        <td class="px-6 py-4 text-slate-600">
                            {{ $machine->section->name ?? 'N/D' }}
                        </td>

                        <!-- Nº de Série -->
                        <td class="px-6 py-4 text-slate-500 text-sm">
                            {{ $machine->serial_number }}
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(auth()->user()->role === 'operador')
                                <div x-data="{ status: '{{ $machine->status }}' }">
                                    <select
                                        name="status"
                                        form="status-form-{{ $machine->id }}"
                                        x-model="status"
                                        :class="{
                                            'bg-emerald-100 text-emerald-800': status == 'operacional',
                                            'bg-amber-100 text-amber-800': status == 'manutencao',
                                            'bg-rose-100 text-rose-800': status == 'avariada'
                                        }"
                                        class="text-xs font-semibold rounded-full px-3 py-1 border-0 transition-colors duration-200 cursor-pointer shadow-sm"
                                    >
                                        <option value="operacional" class="bg-white text-slate-800">Operacional</option>
                                        <option value="manutencao" class="bg-white text-slate-800">Em Manutenção</option>
                                        <option value="avariada" class="bg-white text-slate-800">Avariada</option>
                                    </select>
                                </div>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $machine->status === 'operacional' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $machine->status === 'manutencao' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $machine->status === 'avariada' ? 'bg-rose-100 text-rose-800' : '' }}">
                                    {{ ucfirst($machine->status) }}
                                </span>
                            @endif
                        </td>

                        <!-- Ações -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(auth()->user()->role === 'operador')
                                <form id="status-form-{{ $machine->id }}" action="{{ route('machines.update-status', $machine) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs bg-slate-900 text-white px-3 py-1.5 rounded-lg hover:bg-slate-800 shadow-sm transition font-medium">
                                        Guardar
                                    </button>
                                </form>
                            @else
                                <div class="inline-flex items-center space-x-3">
                                    <a href="{{ route('machines.edit', $machine) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <form action="{{ route('machines.destroy', $machine) }}" method="POST" class="inline" onsubmit="return confirm('Tens a certeza que pretendes eliminar esta máquina?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900">Eliminar</button>
                                    </form>
                                </div>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-500">
                            Nenhuma máquina registada no sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
