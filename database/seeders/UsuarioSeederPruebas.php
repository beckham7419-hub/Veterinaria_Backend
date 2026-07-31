<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeederPruebas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
             [
                'nombre_completo' => 'Rafael Moreno',
                'correo'          => 'administrador@veterinaria.com',
                'contrasena'      => Hash::make('12345678'), 
                'rol'             => 'administrador',
                'activo'          => true,
                'intentos_fallidos' => 0,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]
        ]);
    }
}
