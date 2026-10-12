<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Executar o Seeder das Secções e Máquinas
        $this->call([
            SectionAndMachineSeeder::class,
        ]);

        // 2. Criar Utilizador Responsável de Turno (Pode eliminar máquinas)
        User::firstOrCreate(
            ['email' => 'responsavel@sgmo.pt'],
            [
                'name'     => 'João Fernandes (Responsável)',
                'password' => bcrypt('password'),
                'role'     => 'responsavel',
            ]
        );

        // 3. Criar Utilizador Operador (Não pode eliminar máquinas)
        User::firstOrCreate(
            ['email' => 'operador@sgmo.pt'],
            [
                'name'     => 'Operador de Maquinação',
                'password' => bcrypt('password'),
                'role'     => 'operador',
            ]
        );
    }
}