<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'motivo',
        'fecha',
        'hora'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_llegada' => 'datetime',
        'fecha_cancelacion' => 'datetime'
    ];

    public function mascota() {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario() {
        return $this->belongsTo(Usuario::class, 'veterinario_id');
    }

    public function dueno() {
        return $this->belongsTo(Dueno::class);
    }

    public function consulta() {
        return $this->hasOne(Consulta::class);
    }
}
