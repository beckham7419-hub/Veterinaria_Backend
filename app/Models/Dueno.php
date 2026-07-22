<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dueno extends Authenticatable
{
    use HasFactory;

    protected $table = 'duenos';

    protected $fillable = [
        'nombre_completo',
        'telefono',
        'correo',
        'contrasena',
        'direccion'
    ];

    protected $hidden = [
        'contrasena'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'contrasena' => 'hashed'
    ];

    public function getAuthPassword() {
        return $this->contrasena;
    }
}
