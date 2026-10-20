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

        return redirect()->route('work_orders.index')->with('success', 'Ordem de trabalho criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
