<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacuna extends Model
{
    use HasFactory;

    protected $table = 'vacunas';

    protected $fillable = [
        'mascota_id',
        'consulta_medica_id',
        'nombre',
        'fecha_aplicacion',
        'proxima_dosis'
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
        'proxima_dosis' => 'date'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function consultaMedica()
    {
        return $this->belongsTo(ConsultaMedica::class);
    }
}
