<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'color',
        'foto_url'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date'
    ];

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function vacunas()
    {
        return $this->hasMany(Vacuna::class);
    }

    public function consultasMedicas()
    {
        return $this->hasManyThrough(
            ConsultaMedica::class,
            Cita::class,
            'mascota_id',
            'cita_id',
            'id',
            'id'
        );
    }
}