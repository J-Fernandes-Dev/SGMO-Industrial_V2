@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Parque de Máquinas</h1>
    @if(auth()->user()->role === 'responsavel')
        <a href="{{ route('machines.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm">
            + Adicionar Centro CNC
        </a>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-800 text-white text-sm uppercase tracking-wider">
                <th class="py-3 px-4">Código</th>
                <th class="py-3 px-4">Marca / Modelo</th>
                <th class="py-3 px-4">Secção</th>
                <th class="py-3 px-4">Nº Série</th>
                <th class="py-3 px-4">Estado</th>
                @if(auth()->user()->role === 'responsavel')
                    <th class="py-3 px-4 text-center">Ações</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($machines as $machine)
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-3 px-4 font-bold text-slate-900">{{ $machine->code }}</td>
                    <td class="py-3 px-4">{{ $machine->brand }} {{ $machine->model }}</td>
                    <td class="py-3 px-4 text-slate-600">{{ $machine->section->name ?? 'N/D' }}</td>
                    <td class="py-3 px-4 text-slate-500 text-sm">{{ $machine->serial_number ?? '---' }}</td>
                    <td class="py-3 px-4">
                    <td class="px-6 py-4 whitespace-nowrap">
                @if(auth()->user()->role === 'operador')
                   <form action="{{ route('machines.update', $machine) }}" method="POST" class="inline-flex items-center space-x-2">
                   @csrf
                   @method('PUT')

            <!-- Contenedor com Alpine.js para atualizar a cor dinamicamente -->
            <div x-data="{ status: '{{ $machine->status }}' }">
                <select name="status"
                    x-model="status"
                    :class="{
                        'bg-emerald-100 text-emerald-800': status == 'operacional',
                        'bg-amber-100 text-amber-800': status == 'manutencao',
                        'bg-rose-100 text-rose-800': status == 'avariada'
                    }"
                    class="text-xs font-semibold rounded-full px-3.5 py-1.5 border-0 transition-colors duration-200 cursor-pointer shadow-sm">
                    <option value="operacional" class="bg-white text-slate-800">Operacional</option>
                    <option value="manutencao" class="bg-white text-slate-800">Em Manutenção</option>
                    <option value="avariada" class="bg-white text-slate-800">Avariada</option>
                </select>
            </div>

            <button type="submit" class="text-xs bg-slate-800 text-white px-2.5 py-1.5 rounded hover:bg-slate-700 shadow-sm transition">
                Guardar
            </button>
        </form>
    @else
        <!-- Para o responsável (etiqueta estática) -->
        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
            {{ $machine->status == 'operacional' ? 'bg-emerald-100 text-emerald-800' : '' }}
            {{ $machine->status == 'manutencao' ? 'bg-amber-100 text-amber-800' : '' }}
            {{ $machine->status == 'avariada' ? 'bg-rose-100 text-rose-800' : '' }}">
            {{ ucfirst($machine->status) }}
        </span>
    @endif
</td>                    @if(auth()->user()->role === 'responsavel')
                        <td class="py-3 px-4 text-center space-x-2">
                            <a href="{{ route('machines.edit', $machine) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Editar</a>
                            <form action="{{ route('machines.destroy', $machine) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja remover esta máquina?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-sm">Eliminar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'responsavel' ? 6 : 5 }}" class="py-6 text-center text-slate-500">
                        Nenhuma máquina registada no sistema.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
