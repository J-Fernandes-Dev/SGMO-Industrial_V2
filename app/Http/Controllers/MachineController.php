<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineRequest;
use App\Models\Machine;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the machines.
     */
    public function index()
    {
        $machines = Machine::with('section')->get();

        return view('machines.index', compact('machines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();

        return view('machines.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMachineRequest $request)
    {
        Machine::create($request->validated());

        return redirect()->route('machines.index')
            ->with('success', 'Máquina registada com sucesso!');
    }

    /**
     * Display the specified machine.
     */
    public function show(Machine $machine)
    {
    $machine->load(['section', 'components', 'workOrders']);
    return view('machines.show', compact('machine', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        $sections = Section::all();

        return view('machines.edit', compact('machine', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Machine $machine)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'code' => 'required|string|max:50|unique:machines,code,'.$machine->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100',
            'status' => 'required|in:operacional,avariada,manutencao',
        ]);

        $machine->update($validated);

        return redirect()->route('machines.index')
            ->with('success', 'Dados da máquina actualizados!');
    }

    /**
     * Update only the machine status.
     */
    public function updateStatus(Request $request, Machine $machine): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:operacional,avariada,manutencao,pendente'],
        ]);

        $machine->update(['status' => $validated['status']]);

        return redirect()->route('machines.index')
            ->with('success', 'Estado da máquina actualizado!');
    }

    /**
     * Remove the specified machine from storage.
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect()->route('machines.index')
            ->with('success', 'Máquina removida com sucesso!');
    }
}
