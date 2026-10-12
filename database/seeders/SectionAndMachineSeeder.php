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
        $fresagem = Section::firstOrCreate(['code' => 'CM'], ['name' => 'Centros Maquinagem']);
        $torneamento = Section::firstOrCreate(['code' => 'TN'], ['name' => 'Torneamento CNC']);
        $corte = Section::firstOrCreate(['code' => 'CT'], ['name' => 'Cortes']);

        // Creating machines
        Machine::firstOrCreate(
            ['code' => 'MAZAK-VTC800'],
            [
                'section_id' => $fresagem->id,
                'brand' => 'Mazak',
                'model' => 'VTC800/30SR',
                'serial_number' => 'MZ-882341',
                'status' => 'operacional',
            ]
        );

        Machine::firstOrCreate(
            ['code' => 'OKUMA-LB2000'],
            [
                'section_id' => $torneamento->id,
                'brand' => 'Okuma',
                'model' => 'LB2000',
                'serial_number' => 'OK-123456',
                'status' => 'operacional',
            ]
        );

        Machine::firstOrCreate(
            ['code' => 'CORTES-001'],
            [
                'section_id' => $corte->id,
                'brand' => 'Cortes',
                'model' => 'Cortes 1',
                'serial_number' => 'CORTES-001',
                'status' => 'operacional',
            ]
        );
    }
}
