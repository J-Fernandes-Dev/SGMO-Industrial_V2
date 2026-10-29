<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar / Atualizar o Responsável
        User::updateOrCreate(
            ['email' => 'responsavel@sgmo.pt'],
            [
                'name' => 'João Fernandes',
                'password' => Hash::make('12345678'), // Podes usar a tua password habitual
                'role' => 'responsavel',
            ]
        );

        // 2. Criar / Atualizar o Técnico
        User::updateOrCreate(
            ['email' => 'tecnico@sgmo.pt'],
            [
                'name' => 'Carlos Silva',
                'password' => Hash::make('12345678'),
                'role' => 'tecnico',
            ]
        );

        // 3. Criar / Atualizar o Operador
        User::updateOrCreate(
            ['email' => 'manuelsantos@sgmo.pt'],
            [
                'name' => 'Manuel Santos',
                'password' => Hash::make('12345678'),
                'role' => 'operador',
            ]
        );
                User::updateOrCreate(
            ['email' => 'lucas@sgmo.pt'],
            [
                'name' => 'Lucas',
                'password' => Hash::make('12345678'),
                'role' => 'operador',
            ]
        );


        // Chamar também o seeder das máquinas e secções se o tiveres aqui:
        $this->call([
            SectionAndMachineSeeder::class,
        ]);
    }
}
