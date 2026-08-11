<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacunas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('aplicada_por_usuario_id')->constrained('usuarios');
            $table->string('nombre_vacuna');
            $table->date('fecha_aplicacion');
            $table->date('fecha_proxima_dosis')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacunas');
    }
};
