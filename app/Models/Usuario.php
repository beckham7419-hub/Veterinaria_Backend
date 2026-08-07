<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
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
        'activo' => 'boolean',
        'contrasena' => 'hashed',
        'bloqueado_hasta' => 'datetime',
        'tokens_validos_desde' => 'datetime'
    ];

    public function getAuthPassword() {
        return $this->contrasena;
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [
            'rol' => $this->rol,
            'nombre_completo' => $this->nombre_completo
        ];
    }
}
