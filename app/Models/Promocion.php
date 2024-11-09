<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';

    protected $fillable = [
        'nombrePromocion',
        'descuento',
        'descripcion',
        'servicio_id',
        'fecha_expiracion',
    ];
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
