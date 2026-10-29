@php
    use App\Models\Machine;
    $machines = Machine::all();
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }">
    <!-- Botão de Disparo na Navbar -->
    <button @click="open = !open" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-red-200 text-sm font-semibold rounded-lg text-red-600 bg-red-50 hover:bg-red-100 hover:border-red-300 hover:scale-110 focus:outline-none transition shadow-sm">
        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <span >Reportar Avaria</span>
        <svg class="w-3.5 h-3.5 text-red-400  transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Menu Dropdown Flutuante -->
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         style="display: none;"
         class="absolute right-0 mt-2 w-80 bg-white shadow-2xl border border-slate-300 rounded-xl p-4 z-50">

        <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800 uppercase tracking-wider">Registo Rápido de Avaria</h3>
            <button @click="open = false" class="text-slate-400 hover:text-slate-600 text-xs font-bold">&times;</button>
        </div>

        @if (session()->has('message'))
            <div class="mb-3 p-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-base rounded-md">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('work_order.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="corretiva">

            <!-- Selecionar Máquina -->
            <div class="mb-3 text-left">
                <label class="block text-base font-medium text-slate-400 mb-1">Equipamento</label>
                <select name="machine_id" required class="w-full rounded-md border-slate-300 text-lg shadow-sm focus:border-red-500 focus:ring-red-500 bg-white">
                    <option value="">-- Selecionar Máquina --</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">{{ $machine->code }} ({{ ucfirst($machine->status) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Prioridade -->
            <div class="mb-3 text-left">
                <label class="block text-base font-medium text-slate-400 mb-1">Prioridade</label>
                <select name="priority" class="w-full rounded-md border-slate-300 text-lg shadow-sm focus:border-red-500 focus:ring-red-500 bg-white">
                    <option value="baixa">Baixa</option>
                    <option value="media" selected>Média</option>
                    <option value="alta">Alta</option>
                    <option value="critica">Crítica</option>
                </select>
            </div>

            <!-- Descrição -->
            <div class="mb-3 text-left">
                <label class="block text-base font-medium text-red-500 mb-1">Sintoma / Problema</label>
                <textarea name="description" rows=10 required placeholder="Descreva sucintamente o problema..." class="w-full rounded-md border-slate-300 text-base shadow-sm focus:border-red-500 focus:ring-red-500 bg-white"></textarea>
            </div>

            <!-- Botão Submeter -->
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-1.5 px-3 rounded-xl text-base shadow transition">
                Criar Ordem de Trabalho
            </button>
        </form>
    </div>
</div>
