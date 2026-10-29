<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Machine;

class WorkOrderController extends Controller
{

/**
     * Display a listing of the resource.
     */
    public function index()
    {
      $workOrders= WorkOrder::all();
      return view('work_order.index', compact('workOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $machines = Machine::all();
        return view('work_order.create', compact('machines'));
    }

    /**
     * Store a newly created resource in storage.
     */
/**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Criar a Ordem de Trabalho
        WorkOrder::create([
            'machine_id' => $request->machine_id,
            'user_id' => auth::id() ?? 1,
            'type' => $request->type ?? 'corretiva',
            'priority' => $request->priority ?? 'media',
            'status' => 'pendente',
            'description' => $request->description,
            'started_at' => now(),
        ]);

        // 2. Atualizar o estado da máquina para avariada
        if ($request->filled('machine_id')) {
            $machine = Machine::find($request->machine_id);
            if ($machine) {
                $machine->update([
                    'status' => 'avariada'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Ordem de trabalho criada e máquina atualizada com sucesso!');
    }    /**
     * Display the specified resource.
     */
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['machine', 'creator', 'technician']);
        return view('work_order.show', compact('workOrder'));
    }

    // Mostrar o formulário para editar / fechar a Ordem de Trabalho

    public function edit(WorkOrder $workOrder   )
    {
        $workOrder->load(['machine', 'creator', 'component']);
        $technicians = \App\Models\User::where('role', 'tecnico')->get();// Lista de utilizadores para atribuição de técnico
        return view('work_order.edit', compact('workOrder', 'technicians'));

    }

    // Atualizar os dados da Ordem de Trabalho (Relatório técnico, estado e downtime)
    public function update(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'status' => 'required|in:pendente,em_andamento,concluida,cancelada',
            'technical_report' => 'nullable|string|max:2000', // Assuming technicians are users
            'downtime_hours' => 'nullable|numeric|min:0',
            "assigned_to" => "nullable|exists:users,id", // Assuming technicians are users
        ]);

        $workOrder->update([
            'status' => $request->status,
            'technical_report' => $request->technical_report,
            'downtime_hours' => $request->downtime_hours ?? 0,
            'assigned_to' => $request->assigned_to,
            "complet_at" => $request->status === 'concluida' ? now() : null,

        ]);

        // Se a ordem de trabalho for concluída, podemos atualizar o estado da máquina para 'operacional'
        if ($request->status === 'concluida') {
            $workOrder->machine->update(['status' => 'operacional']);

            }

            return redirect()->route('work_order.show', $workOrder)->with('success', 'Ordem de trabalho atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workOrder = WorkOrder::findOrFail($id);

        // Se a OT estiver associada a uma máquina, voltamos a colocá-la operacional (opcional, mas recomendado)
        if ($workOrder->machine_id) {
            $machine = Machine::find($workOrder->machine_id);
            if ($machine) {
                $machine->update([
                    'status' => 'operacional' // Ou 'ativa' / 'disponível' consoante o teu sistema
                ]);
            }
        }

        // Apagar a Ordem de Trabalho
        $workOrder->delete();

        return redirect()->back()->with('success', 'Ordem de trabalho apagada e máquina atualizada com sucesso!');
    }
}
