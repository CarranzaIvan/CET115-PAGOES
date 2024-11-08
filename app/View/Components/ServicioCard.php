<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServicioCard extends Component
{
    public $titulo;
    public $precio;
    public $descripcion;
    public $imagen;
    public $idServicio;

    // Método constructor del componente ServicioCard
    public function __construct($titulo = 'Servicio sin nombre', $precio = '$0.00', $descripcion = 'No hay descripción definida para este servicio por favor proporcione una', $imagen = null, $idServicio = '0')
    {
        $this->titulo = $titulo;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen ?? asset('images/logo.png'); // Ruta por defecto para la imagen
        $this->idServicio = $idServicio;
    }
    public function render()
    {
        return view('components.servicio-card');
    }
}
