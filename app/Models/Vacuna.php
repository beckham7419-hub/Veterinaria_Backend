<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    protected $table = 'vacunas';

    public $timestamps = false;

    protected $fillable = [
        'mascota_id',
        'consulta_id',
        'nombre_vacuna',
        'fecha_aplicacion',
        'fecha_proxima_dosis'
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
        'fecha_proxima_dosis' => 'date'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function aplicadaPor()
    {
        return $this->belongsTo(Usuario::class, 'aplicada_por_usuario_id');
    }
}
