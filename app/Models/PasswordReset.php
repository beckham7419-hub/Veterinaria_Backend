<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    public $timestamps = false;

    protected $fillable = [
        'correo',
        'tipo',
        'token',
        'expira_en'
    ];

    protected $casts = [
        'expira_en' => 'datetime'
    ];
}
