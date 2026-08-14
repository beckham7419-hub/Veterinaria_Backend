<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo', 150);
            $table->string('correo', 150)->unique();
            $table->string('contrasena', 255);
            $table->enum('rol', ['administrador', 'veterinario', 'recepcionista']);
            $table->boolean('activo')->default(true);
            $table->unsignedTinyInteger('intentos_fallidos')->default(0);
            $table->dateTime('bloqueado_hasta')->nullable();
            $table->dateTime('tokens_validos_desde')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
