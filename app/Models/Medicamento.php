<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';

    protected $fillable = [
        'proveedor_id',
        'nombre',
        'tipo',
        'unidad_medida',
        'cantidad_actual',
        'cantidad_minima_alerta'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'cantidad_actual' => 'decimal:2',
        'cantidad_minima_alerta' => 'decimal:2'
    ];

    public function proveedor() {
        return $this->belongsTo(Proveedor::class);
    }
}
