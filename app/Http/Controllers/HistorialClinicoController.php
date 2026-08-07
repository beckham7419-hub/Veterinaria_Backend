<?php

namespace App\Http\Controllers;

use App\Models\Mascota;

class HistorialClinicoController extends Controller
{
    public function show(Mascota $mascota)
    {
        return response()->json([
            'mascota' => $mascota->load([
                'consultasMedicas',
                'vacunas'
            ])
        ]);
    }
}