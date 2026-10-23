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
      $workOrder = WorkOrder::with(['machine', 'creator', 'technician'])->latest()->get();
      return view('work_order.index', compact('workOrder'));
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
    public function store(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'type' => 'required|in:preventiva,corretiva',
            'priority' => 'required|in:baixa,media,alta,critica',
            'description' => 'required|string|max:1000',
        ]);

        WorkOrder::create([
            'machine_id' => $request->machine_id,
            'user_id' => Auth::id(), // Utilizador autenticado que está a abrir a OT
            'type' => $request->type,
            'priority' => $request->priority,
            'status' => 'pendente', // Estado inicial predefinido como 'pendente'
            'description' => $request->description,
        ]);

        $workOrder = new WorkOrder();
        $workOrder->machine_id = $request->machine_id;
        $workOrder->user_id = Auth::id(); // Assuming the logged-in user is the creator
        $workOrder->type = $request->type;
        $workOrder->priority = $request->priority;
        $workOrder->status = $request->status;
        $workOrder->description = $request->description;
        $workOrder->save();

        return redirect()->route('work_order.index')->with('success', 'Ordem de trabalho criada com sucesso.');
    }

    /**
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
    public function destroy(string $id)
    {
        //
    }
}
