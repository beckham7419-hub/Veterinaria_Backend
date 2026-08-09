<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores');
            $table->string('nombre');
            $table->string('tipo');
            $table->string('unidad_medida');
            $table->decimal('cantidad_actual', 10, 2)->default(0);
            $table->decimal('cantidad_minima_alerta', 10, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
