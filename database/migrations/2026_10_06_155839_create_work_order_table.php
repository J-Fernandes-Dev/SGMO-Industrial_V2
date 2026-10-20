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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();

            // --- RELAÇÕES (Chaves Estrangeiras) ---
            $table->foreignId('machine_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->comment('Operador/Responsável que abriu a OT')->constrained('users');
            $table->foreignId('assigned_to')->nullable()->comment('Técnico atribuído para a manutenção')->constrained('users');
            $table->foreignId('component_id')->nullable()->comment('Componente específico afetado (ex: Spindle)')->constrained('components')->nullOnDelete();

            // --- DADOS DA ABERTURA (Preenchido pelo Operador) ---
            $table->string('type')->default('corretiva'); // 'corretiva' (avaria imediata) ou 'preventiva' (manutenção agendada)
            $table->string('priority')->default('media');  // 'baixa', 'media', 'alta', 'critica'
            $table->string('status')->default('pendente'); // 'pendente', 'em_andamento', 'concluida', 'cancelada'
            $table->text('description');                  // Descrição detalhada do sintoma / problema detetado no centro de maquinação

            // --- DADOS DA INTERVENÇÃO (Preenchido pelo Técnico de Manutenção) ---
            $table->text('technical_report')->nullable();  // Relatório técnico das ações efetuadas e peças substituídas
            $table->decimal('downtime_hours', 5, 2)->default(0.00); // Horas de máquina parada (essencial para o cálculo de KPIs no Mês 3!)

            // --- REGISTO TEMPORAL ---
            $table->timestamp('started_at')->nullable();   // Hora em que o técnico iniciou a reparação
            $table->timestamp('completed_at')->nullable(); // Hora em que a máquina ficou operacional e a OT foi fechada
            $table->timestamps();                          // created_at (hora de abertura) e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
