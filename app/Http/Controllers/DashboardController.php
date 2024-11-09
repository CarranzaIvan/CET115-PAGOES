<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas\Cita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function dashboard()
    {
        // Obtener las citas de los últimos 7 días agrupadas por fecha
        $citasPorDia = Cita::select(DB::raw('DATE(fecha_cita) as date'), DB::raw('count(*) as total'))
            ->whereBetween('fecha_cita', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        // Crear un array de fechas y totales
        $fechas = [];
        $totales = [];
    
        // Llenar los arrays con datos de los últimos 7 días
        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i)->format('Y-m-d');
            $fechas[] = $fecha;
    
            // Buscar si hay citas en esta fecha
            $cita = $citasPorDia->firstWhere('date', $fecha);
            $totales[] = $cita ? $cita->total : 0;
        }
    
        // Pasar las variables $fechas y $totales a la vista
        return view('dashboard.index', compact('fechas', 'totales'));
    }
    
    
}
