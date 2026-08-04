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
    Schema::create('consultas_medicas', function (Blueprint $table) {
        $table->id();

        $table->foreignId('cita_id')
            ->constrained('citas')
            ->cascadeOnDelete();

        $table->text('diagnostico');

        $table->text('tratamiento')->nullable();
        $table->longftext('medicamentos')->nullable();
        $table->text('observaciones')->nullable();

        $table->decimal('peso', 5, 2)->nullable();
        $table->decimal('temperatura', 4, 1)->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas_medicas');
    }
};
