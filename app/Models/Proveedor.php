<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
