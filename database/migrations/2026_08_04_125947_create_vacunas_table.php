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
    Schema::create('vacunas', function (Blueprint $table) {
        $table->id();

        $table->foreignId('mascota_id')
            ->constrained('mascotas')
            ->cascadeOnDelete();

        $table->foreignId('consulta_medica_id')
            ->constrained('consultas_medicas')
            ->cascadeOnDelete();

        $table->string('nombre');

        $table->date('fecha_aplicacion');

        $table->date('proxima_dosis')
            ->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacunas');
    }
};
