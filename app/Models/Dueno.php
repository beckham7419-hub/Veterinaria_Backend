<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Dueno extends Authenticatable implements JWTSubject
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
        'contrasena' => 'hashed',
        'tokens_validos_desde' => 'datetime'
    ];

    public function getAuthPassword() {
        return $this->contrasena;
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}
