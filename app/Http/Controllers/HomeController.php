<?php

namespace App\Http\Controllers;

use App\Models\Preguntas;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Vísta de Inicio
    public function welcome()
    {
        return view('welcome');
    }

    // Vísta de terminos
    public function verTerminos()
    {
        return view('terminos');
    }

    // Vísta de terminos
    public function verChatbot()
    {
        return view('chatbot');
    }

    public function verServicios()
    {
        return view('services');
    }

    // Vísta de Preguntas Frecuentes
    public function verPreguntas()
    {
        $preguntas = Preguntas::all();
        return view('preguntas', compact('preguntas'));
    }
    
}
