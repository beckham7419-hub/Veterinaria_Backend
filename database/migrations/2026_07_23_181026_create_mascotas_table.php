<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dueno_id')->constrained('duenos');
            $table->string('numero_expediente', 20)->unique();
            $table->string('nombre', 100);
            $table->string('especie', 50);
            $table->string('raza', 50)->nullable();
            $table->enum('sexo', ['macho', 'hembra']);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('color', 50)->nullable();
            $table->string('foto_url')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index('nombre', 'idx_mascotas_nombre');
            $table->index('especie', 'idx_mascotas_especie');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
