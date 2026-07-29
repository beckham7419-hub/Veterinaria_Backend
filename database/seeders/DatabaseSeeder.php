<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamamos a tu seeder personalizado
        $this->call([
            UsuarioSeederPruebas::class,
        ]);
    }
}