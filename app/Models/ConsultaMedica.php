<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultaMedica extends Model
{
    use HasFactory;

    protected $table = 'consultas_medicas';

    protected $fillable = [
        'cita_id',
        'diagnostico',
        'tratamiento',
        'medicamentos',
        'observaciones',
        'peso',
        'temperatura'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
    public function vacunas()
    {
    return $this->hasMany(Vacuna::class);
    }
}