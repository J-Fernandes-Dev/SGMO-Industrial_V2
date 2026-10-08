@extends('layouts.app')

@content
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-6 text-slate-800 border-b pb-2">Editar Máquina: {{ $machine->code }}</h2>

    <form action="{{ route('machines.update', $machine) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="code" class="block text-sm font-medium text-slate-700">Código da Máquina</label>
                <input type="text" name="code" id="code" value="{{ old('code', $machine->code) }}" required class="mt-1 w-full p-2 border rounded border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                @error('code') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="section_id" class="block text-sm font-medium text-slate-700">Secção</label>
                <select name="section_id" id="section_id" required class="mt-1 w-full p-2 border rounded border-slate-300">
                    <option value="">Selecione uma secção...</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id', $machine->section_id) == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
                @error('section_id') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="brand" class="block text-sm font-medium text-slate-700">Marca</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand', $machine->brand) }}" required class="mt-1 w-full p-2 border rounded border-slate-300">
                @error('brand') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="model" class="block text-sm font-medium text-slate-700">Modelo</label>
                <input type="text" name="model" id="model" value="{{ old('model', $machine->model) }}" required class="mt-1 w-full p-2 border rounded border-slate-300">
                @error('model') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="serial_number" class="block text-sm font-medium text-slate-700">Número de Série</label>
                <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $machine->serial_number) }}" class="mt-1 w-full p-2 border rounded border-slate-300">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-slate-700">Estado</label>
                <select name="status" id="status" required class="mt-1 w-full p-2 border rounded border-slate-300">
                    <option value="operacional" {{ old('status', $machine->status) == 'operacional' ? 'selected' : '' }}>Operacional</option>
                    <option value="avariada" {{ old('status', $machine->status) == 'avariada' ? 'selected' : '' }}>Avariada</option>
                    <option value="manutencao" {{ old('status', $machine->status) == 'manutencao' ? 'selected' : '' }}>Em Manutenção</option>
                </select>
                @error('status') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('machines.index') }}" class="px-4 py-2 border rounded text-slate-600 hover:bg-slate-50">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Atualizar Máquina</button>
        </div>
    </form>
</div>
@endcontent
