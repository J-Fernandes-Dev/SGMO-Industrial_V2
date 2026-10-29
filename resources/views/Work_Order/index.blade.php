@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-4 lg:px-8 py-6">

    <!-- Cabeçalho e Botão Nova Avaria -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="ml-20 text-3xl font-bold text-slate-500">Ordens de Trabalho (Manutenção)</h1>


        <a href="{{ route('work_order.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-medium mr-5 py-2 px-4 rounded transition-transform duration-200 hover:scale-110">
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

        <tbody class="divide-y divide-slate-200 bg-white">
            @forelse($workOrders as $workOrder)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-bold text-slate-900">#{{ $workOrder->id }}</td>

                    <td class="px-6 py-4 text-slate-700 font-semibold">
                        {{ $workOrder->machine->code ?? 'N/D' }}
                        <span class="block text-xs font-normal text-slate-500">{{ $workOrder->machine->brand ?? '' }} {{ $workOrder->machine->model ?? '' }}</span>
                    </td>

                    <td class="px-6 py-4 text-slate-600 capitalize">
                        {{ $workOrder->type }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full
                            {{ $workOrder->priority == 'baixa' ? 'bg-slate-100 text-slate-800' : '' }}
                            {{ $workOrder->priority == 'media' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $workOrder->priority == 'alta' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $workOrder->priority == 'critica' ? 'bg-rose-100 text-rose-800 font-bold' : '' }}">
                            {{ ucfirst($workOrder->priority) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full
                            {{ $workOrder->status == 'pendente' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $workOrder->status == 'em andamento' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $workOrder->status == 'concluida' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                            {{ ucfirst($workOrder->status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-slate-600">
                        {{ $workOrder->user->name ?? 'N/D' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-xs flex items-center space-x-3">
                        <a href="{{ route('work_order.show', $workOrder->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Detalhes</a>

                        <form action="{{ route('work_order.destroy', $workOrder->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que pretendes apagar esta Ordem de Trabalho?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                Apagar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-slate-500">Nenhuma Ordem de Trabalho encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
