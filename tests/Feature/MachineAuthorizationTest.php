<?php

use App\Models\Machine;
use App\Models\Section;
use App\Models\User;

function machineAttributes(Section $section): array
{
    return [
        'section_id' => $section->id,
        'code' => 'MACHINE-001',
        'brand' => 'Mazak',
        'model' => 'VTC-800',
        'serial_number' => 'SERIAL-001',
        'status' => 'operacional',
    ];
}

function createMachineSection(): Section
{
    return Section::create([
        'name' => 'Produção',
        'code' => 'PROD',
    ]);
}

it('restricts machine creation and editing to responsible users', function () {
    $operator = User::factory()->create(['role' => 'operador']);
    $section = createMachineSection();
    $machineData = machineAttributes($section);
    $machine = Machine::create($machineData);
    $machineToCreate = array_merge($machineData, ['code' => 'MACHINE-002']);

    $this->actingAs($operator)
        ->get(route('machines.create'))
        ->assertForbidden();

    $this->actingAs($operator)
        ->post(route('machines.store'), $machineToCreate)
        ->assertForbidden();

    $this->actingAs($operator)
        ->get(route('machines.edit', $machine))
        ->assertForbidden();

    $this->actingAs($operator)
        ->put(route('machines.update', $machine), array_merge(
            $machineData,
            ['brand' => 'Operator brand'],
        ))
        ->assertForbidden();

    expect($machine->refresh()->brand)->toBe('Mazak');
    expect(Machine::query()->count())->toBe(1);

    $this->actingAs($operator)
        ->get(route('machines.index'))
        ->assertSee(route('machines.update-status', $machine))
        ->assertDontSee(route('machines.create'))
        ->assertDontSee('Editar')
        ->assertDontSee('Eliminar');

    foreach (['avariada', 'manutencao', 'operacional'] as $status) {
        $this->actingAs($operator)
            ->patch(route('machines.update-status', $machine), [
                'status' => $status,
                'brand' => 'Operator brand',
            ])
            ->assertRedirect(route('machines.index'));

        expect($machine->refresh()->status)->toBe($status);
    }

    expect($machine->refresh()->brand)->toBe('Mazak');

    $this->actingAs($operator)
        ->patch(route('machines.update-status', $machine), ['status' => 'invalid'])
        ->assertSessionHasErrors('status');

    expect($machine->refresh()->status)->toBe('operacional');

    $responsible = User::factory()->create(['role' => 'responsavel']);

    $this->actingAs($responsible)
        ->get(route('machines.create'))
        ->assertSee('Guardar Máquina');

    $this->actingAs($responsible)
        ->get(route('machines.edit', $machine))
        ->assertSee('Atualizar Máquina');

    $this->actingAs($responsible)
        ->post(route('machines.store'), $machineToCreate)
        ->assertRedirect(route('machines.index'));

    $createdMachine = Machine::query()->where('code', 'MACHINE-002')->firstOrFail();
    $this->assertModelExists($createdMachine);

    $this->actingAs($responsible)
        ->put(route('machines.update', $machine), array_merge(
            $machineData,
            ['brand' => 'Updated brand'],
        ))
        ->assertRedirect(route('machines.index'));

    expect($machine->refresh()->brand)->toBe('Updated brand');
});
