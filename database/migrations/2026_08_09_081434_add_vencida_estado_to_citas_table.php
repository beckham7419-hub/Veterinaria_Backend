<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE citas MODIFY estado ENUM('agendada', 'confirmada', 'en_consulta', 'completada', 'cancelada', 'vencida') NOT NULL DEFAULT 'agendada'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE citas SET estado = 'cancelada' WHERE estado = 'vencida'");
        DB::statement("ALTER TABLE citas MODIFY estado ENUM('agendada', 'confirmada', 'en_consulta', 'completada', 'cancelada') NOT NULL DEFAULT 'agendada'");
    }
};
