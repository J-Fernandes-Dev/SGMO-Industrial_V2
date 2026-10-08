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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            // Relation with sections table
            $table->foreignId('section_id')->constrained()->cascadeOnDelete(); //in CascadeOnDelete delete the machines if the section is deleted
            $table->string('code')->unique();
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number')->nullable();
            $table->string('status')->default('operacional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
