<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'correo',
        'contrasena',
        'rol'
    ];

    protected $hidden = [
        'contrasena'
    ];

    protected $casts = [
        'activo'     => 'boolean',
        'contrasena' => 'hashed'
    ];

    public function getAuthPassword() {
        return $this->contrasena;
    }
}
