<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'cita_id',
        'diagnostico',
        'tratamiento',
        'medicamentos_recetados',
        'observaciones',
        'peso',
        'temperatura'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function archivos()
    {
        return $this->hasMany(ArchivoConsulta::class, 'consulta_id');
    }
}
