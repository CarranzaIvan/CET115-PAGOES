<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';
    protected $fillable = ['email', 'token', 'created_at'];
    public $timestamps = false;

    protected $dates = ['created_at'];

    // Indica que 'email' es la clave primaria
    protected $primaryKey = 'email';

    // Indica que la clave primaria no es autoincremental
    public $incrementing = false;

    // Especifica el tipo de clave primaria como string
    protected $keyType = 'string';
}
