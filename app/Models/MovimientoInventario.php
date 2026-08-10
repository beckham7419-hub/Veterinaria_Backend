<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    public $timestamps = false;

    protected $fillable = [
        'medicamento_id',
        'tipo',
        'cantidad',
        'motivo'
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];

    public function medicamento() {
        return $this->belongsTo(Medicamento::class);
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class);
    }
}
