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

        // --- SECÇÃO: TORNEAMENTO CNC (ID: 1) ---

        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'TN-001',
            'brand' => 'Okuma',
            'model' => 'LB2000 EX II',
            'serial_number' => 'OK-982341',
            'status' => 'operacional',
        ]);
        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'TN-002',
            'brand' => 'DMG Mori',
            'model' => 'NLX 2500',
            'serial_number' => 'DM-445120',
            'status' => 'operacional',
        ]);


        Machine::updateOrCreate([
            'section_id' => $torneamento->id,
            'code' => 'TN-003',
            'brand' => 'Mazak',
            'model' => 'Quick Turn 250MY',
            'serial_number' => 'MZ-778291',
            'status' => 'manutencao',
        ]);


        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'TN-004',
            'brand' => 'Doosan',
            'model' => 'Puma 2600SY',
            'serial_number' => 'DS-109283',
            'status' => 'operacional',
        ]);

        Machine::updateOrCreate([
            'section_id' => $torneamento->id,
            'code' => 'TN-005',
            'brand' => 'Haas',
            'model' => 'ST-20Y',
            'serial_number' => 'HS-554192',
            'status' => 'operacional',
        ]);

        // --- SECÇÃO: CENTROS DE MAQUINAGEM (ID: 2) ---

        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'CM-001',
            'brand' => 'Mazak',
            'model' => 'VTC-800/30',
            'serial_number' => 'MZ-112384',
            'status' => 'operacional',
        ]);
        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'CM-002',
            'brand' => 'DMG Mori',
            'model' => 'CMX 600 V',
            'serial_number' => 'DM-667902',
            'status' => 'operacional',
        ]);

        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'CM-003',
            'brand' => 'Haas',
            'model' => 'VF-2SS',
            'serial_number' => 'HS-334910',
            'status' => 'avariada',
        ]);

        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'CM-004',
            'brand' => 'Makino',
            'model' => 'a51nx',
            'serial_number' => 'MK-889021',
            'status' => 'operacional',
        ]);

        Machine::updateOrCreate([
            'section_id' => $fresagem->id,
            'code' => 'CM-005',
            'brand' => 'Hermle',
            'model' => 'C 250',
            'serial_number' => 'HM-221093',
            'status' => 'operacional',
        ]);
    }
}
