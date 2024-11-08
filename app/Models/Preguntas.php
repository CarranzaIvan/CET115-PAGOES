<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'preguntas';

    // Campos que se pueden llenar de forma masiva
    protected $fillable = ['pregunta', 'respuesta'];
}
