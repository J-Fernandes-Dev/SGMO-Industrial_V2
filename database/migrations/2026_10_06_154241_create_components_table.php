<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();

            // --- RELAÇÃO (Chave Estrangeira) ---
            // Liga o componente à máquina correspondente (ex: Mazak VTC-800)
            $table->foreignId('machine_id')->constrained()->cascadeOnDelete();

            // --- DADOS TÉCNICOS DO COMPONENTE ---
            $table->string('name'); // Nome do componente (ex: Spindle / Eixo Árvore, Eixo X, Guias Lineares, Trocador de Ferramentas, Sistema de Refrigeração)
            $table->string('part_number')->nullable(); // Número de peça/referência do fabricante para encomendar substitutos
            $table->string('category')->nullable(); // Categoria técnica: 'mecanico', 'eletrico', 'pneumatico', 'hidraulico'

            // --- ESTADO / MANUTENÇÃO ---
            $table->string('status')->default('operacional'); // 'operacional', 'com_desgaste', 'danificado', 'em_substituicao'
            $table->text('notes')->nullable(); // Notas ou observações técnicas adicionais (ex: "Instalado em Jan/2025")

            $table->timestamps();
        });
    }
};
