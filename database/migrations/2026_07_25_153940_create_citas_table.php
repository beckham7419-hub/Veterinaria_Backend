<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas');
            $table->foreignId('veterinario_id')->constrained('usuarios');
            $table->foreignId('dueno_id')->nullable()->constrained('duenos');
            $table->string('numero_folio', 20)->unique();
            $table->string('motivo', 255);
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado', ['agendada', 'confirmada', 'en_consulta', 'completada', 'cancelada'])->default('agendada');
            $table->dateTime('hora_llegada')->nullable();
            $table->string('motivo_cancelacion', 255)->nullable();
            $table->foreignId('cancelado_por_usuario_id')->nullable()->constrained('usuarios');
            $table->foreignId('cancelado_por_dueno_id')->nullable()->constrained('duenos');
            $table->dateTime('fecha_cancelacion')->nullable();
            $table->timestamps();

            $table->index('fecha', 'idx_citas_fecha');
            $table->index('estado', 'idx_citas_estado');
            $table->index(['veterinario_id', 'fecha'], 'idx_citas_vet_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
