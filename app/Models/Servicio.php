<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    // Define the table associated with the model
    protected $table = 'servicios';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'nomServicio',
        'descripcion',
        'precio',
        'imagen', // Recebimiento de la imagen
    ];

    // Define the relationship with the model Promocion
    public function promocion()
    {
        return $this->hasOne(Promocion::class);
    }
}
