<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Indica que este modelo usa la tabla 'usuarios'
    protected $primaryKey = 'id_usuario'; // Indica que la clave primaria es 'id_usuario'

    /**
     * Los atributos que se pueden asignar de manera masiva.
     */
    protected $fillable = [
        'nombre_completo', 'correo', 'contraseña', 'direccion', 'telefono', 'id_rol',
    ];

    /**
     * Ocultar atributos al serializar.
     */
    protected $hidden = [
        'contraseña', 'remember_token',
    ];

    /**
     * Renombrar la columna 'contraseña' para que Laravel la trate como 'password'.
     */
    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
