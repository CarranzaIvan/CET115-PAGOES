<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Servicio;
use App\Models\Usuario;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $primaryKey = 'id_cita';

    protected $fillable = [
        'id_usuario',
        'id_servicio',
        'fecha_cita',
        'hora_cita',
        'title',
        'start',
        'end',
        'color',
        'estado',
        'pagado',
        'fyh_creacion',
        'fyh_actualizacion',
    ];

    public $timestamps = false;

    public function setFechaCitaAttribute($value)
    {
        $this->attributes['fecha_cita'] = $value;
        $this->attributes['start'] = $value;
        $this->attributes['end'] = $value;
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
