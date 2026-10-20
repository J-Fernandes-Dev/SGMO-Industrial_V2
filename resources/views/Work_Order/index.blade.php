@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-4 lg:px-8 py-6">

    <!-- Cabeçalho e Botão Nova Avaria -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Ordens de Trabalho (Manutenção)</h1>

        <a href="{{ route('work_order.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded transition-transform duration-200 hover:scale-110">
            + Registar Nova Avaria / OT
        </a>
    </div>

    <!-- Tabela de Ordens de Trabalho -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">

            <thead class="bg-orange-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Máquina</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Tipo</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Prioridade</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Aberta por</th>
                    <th scope="col" class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Ações</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @forelse($workOrder as $wo)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900">#{{ $wo->id }}</td>

                        <td class="px-6 py-4 text-slate-700 font-semibold">
                            {{ $wo->machine->code ?? 'N/D' }}
                            <span class="block text-xs font-normal text-slate-500">{{ $wo->machine->brand }} {{ $wo->machine->model }}</span>
                        </td>

                        <td class="px-6 py-4 text-slate-600 capitalize">
                            {{ $wo->type }}
                        </td>

                        <!-- Prioridade com cores dinâmicas -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full 
                                {{ $wo->priority == 'baixa' ? 'bg-slate-100 text-slate-800' : '' }}
                                {{ $wo->priority == 'media' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $wo->priority == 'alta' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $wo->priority == 'critica' ? 'bg-rose-100 text-rose-800 font-bold' : '' }}">
                                {{ ucfirst($wo->priority) }}
                            </span>
                        </td>

                        <!-- Estado com cores dinâmicas -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full 
                                {{ $wo->status == 'pendente' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $wo->status == 'em_andamento' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $wo->status == 'concluida' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $wo->status == 'cancelada' ? 'bg-slate-100 text-slate-500' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-600 text-sm">
                            {{ $wo->creator->name ?? 'Sistema' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Detalhes</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500">
                            Nenhuma ordem de trabalho registada no sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
