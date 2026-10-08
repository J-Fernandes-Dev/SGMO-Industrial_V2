<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Machine;

class SectionAndMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating sections
        $fresagem = Section::create(['code' => 'CM', 'name' => 'Centros Maquinagem']);
        $torneamento = Section::create(['code' => 'TN', 'name' => 'Torneamento CNC']);
        $corte = Section::create(['code' => 'CT', 'name' => 'Cortes']);

        // Creating machines
        Machine::create([
            'section_id' => $fresagem->id,
            'code' => 'MAZAK-VTC800',
            'brand' => 'Mazak',
            'model' => 'VTC800/30SR',
            'serial_number' => 'MZ-882341',
            'status' => 'operacional',
        ]);

        Machine::create([
            'section_id' => $torneamento->id,
            'code' => 'OKUMA-LB2000',
            'brand' => 'Okuma',
            'model' => 'LB2000',
            'serial_number' => 'OK-123456',
            'status' => 'operacional',
        ]);

        Machine::create([
            'section_id' => $corte->id,
            'code' => 'CORTES-001',
            'brand' => 'Cortes',
            'model' => 'Cortes 1',
            'serial_number' => 'CORTES-001',
            'status' => 'operacional',
        ]);
    }
}
