<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duenos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo', 150);
            $table->string('telefono', 10);
            $table->string('correo', 150)->unique();
            $table->string('direccion', 255)->nullable();
            $table->string('contrasena', 255);
            $table->boolean('activo')->default(true);
            $table->dateTime('tokens_validos_desde')->nullable();
            $table->timestamps();
            
            $table->index('nombre_completo', 'idx_duenos_nombre');
            $table->index('telefono', 'idx_duenos_telefono');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duenos');
    }
};
