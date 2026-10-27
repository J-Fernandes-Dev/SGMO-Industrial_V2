<?php

use Livewire\Component;
use App\Models\Machine;
use App\Models\WorkOrder;

new class extends Component {
    public $machines;
    public $selectedMachineId;
    public $description;
    public $priority = 'media';

    public function mount()
    {
        $this->loadMachines();
    }

    public function loadMachines()
    {
        $this->machines = Machine::all();
    }

    public function reportarAvaria()
    {
        $this->validate([
            'selectedMachineId' => 'required|exists:machines,id',
            'description' => 'required|string|min:5',
        ]);

        WorkOrder::create([
            'machine_id' => $this->selectedMachineId,
            'user_id' => auth()->id() ?? 1,
            'type' => 'corretiva',
            'priority' => $this->priority,
            'status' => 'pendente',
            'description' => $this->description,
            'started_at' => now(),
        ]);

        $machine = Machine::find($this->selectedMachineId);
        $machine->update(['status' => 'avariada']);

        $this->reset(['selectedMachineId', 'description', 'priority']);
        $this->loadMachines();

        session()->flash('message', 'Avaria reportada com sucesso e máquina marcada como avariada!');
    }
};
?>

<div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-xl mx-auto mb-6">
    <!-- Cabeçalho / Botão Toggler (Acordeão) -->
    <button @click="open = !open" type="button" class="w-full px-6 py-4 bg-slate-50 hover:bg-slate-100 flex items-center justify-between text-left transition font-medium text-slate-800">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Registo Rápido de Avaria (Livewire)
        </span>
        <!-- Seta que roda ao abrir/fechar -->
        <svg class="w-5 h-5 text-slate-500 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Conteúdo Retrátil do Formulário -->
    <div x-show="open" x-transition class="p-6 border-t border-slate-200">
        @if (session()->has('message'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="reportarAvaria">
            <!-- Selecionar Máquina -->
            <div class="mb-4 text-left">
                <label class="block text-sm font-medium text-slate-700 mb-1">Selecionar Máquina Mazak</label>
                <select wire:model="selectedMachineId" class="w-full rounded-lg border-slate-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Escolha o equipamento --</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">
                            {{ $machine->code }} ({{ ucfirst($machine->status) }})
                        </option>
                    @endforeach
                </select>
                @error('selectedMachineId') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Prioridade -->
            <div class="mb-4 text-left">
                <label class="block text-sm font-medium text-slate-700 mb-1">Prioridade</label>
                <select wire:model="priority" class="w-full rounded-lg border-slate-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                    <option value="critica">Crítica</option>
                </select>
            </div>

            <!-- Descrição da Avaria -->
            <div class="mb-4 text-left">
                <label class="block text-sm font-medium text-slate-700 mb-1">Descrição do Problema</label>
                <textarea wire:model="description" rows="3" placeholder="Descreva o sintoma de avaria..." class="w-full rounded-lg border-slate-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Botão Submeter -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-sm shadow-sm transition">
                Reportar Avaria Rapidamente
            </button>
        </form>
    </div>
</div>
