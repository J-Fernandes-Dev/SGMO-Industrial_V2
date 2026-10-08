@extends('layouts.app')

@content
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Parque de Máquinas</h1>
    <a href="{{ route('machines.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm">
        + Adicionar Centro CNC
    </a>
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
                <th class="py-3 px-4 text-center">Ações</th>
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
                        @if($machine->status === 'operacional')
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-emerald-300">
                                Operacional
                            </span>
                        @elseif($machine->status === 'avariada')
                            <span class="bg-rose-100 text-rose-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-rose-300">
                                Avariada
                            </span>
                        @else
                            <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-amber-300">
                                Em Manutenção
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center space-x-2">
                        <a href="{{ route('machines.edit', $machine) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Editar</a>
                        <form action="{{ route('machines.destroy', $machine) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja remover esta máquina?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-sm">Eliminar</button>
                        </form>
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
@endcontent
