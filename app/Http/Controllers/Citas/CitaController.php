<?php

namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Citas\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaController extends Controller
{

    public function misCitas()
    {
        $usuario = Auth::user(); // Obtener usuario autenticado

        // Obtener todas las citas que pertenecen al usuario autenticado, cuya fecha es igual o posterior a la actual, y ordenarlas de la más próxima a la más lejana
        $citas = Cita::with('servicio')
            ->where('id_usuario', $usuario->id_usuario)
            ->where('fecha_cita', '>=', now()->format('Y-m-d')) // Filtrar citas a partir de hoy
            ->orderBy('fecha_cita', 'asc') // Ordenar por fecha, de la más cercana a la más lejana
            ->orderBy('hora_cita', 'asc') // Ordenar adicionalmente por hora si hay varias citas el mismo día
            ->get();

        return view('seguimiento', compact('citas'));
    }



    public function index()
    {
        // Cargar las citas junto con la relación 'servicio'
        $citas = Cita::with('servicio')->get();
        return view('dashboard.citas.index', compact('citas'));
    }

    public function show($id)
    {
        // Cargar la cita con el servicio y usuario relacionado
        $cita = Cita::with(['servicio'])->find($id);

        if (!$cita) {
            return redirect()->back()->withErrors('Cita no encontrada');
        }

        return view('dashboard.citas.show', compact('cita'));
    }

    public function destroy($id)
    {
        $cita = Cita::find($id);

        if ($cita) {
            $cita->delete();
            return redirect()->route('dashboard.citas.index')->with('success', 'Cita eliminada exitosamente.');
        } else {
            return redirect()->route('dashboard.citas.index')->with('error', 'No se pudo encontrar la cita.');
        }
    }

    public function getCitas()
    {
        //eliminamos las citas que no se han pagado
        Cita::where('pagado', 0)->delete();
        // Mapeamos 'id_cita' como 'id' para que FullCalendar lo use como identificador
        $citas = Cita::select('id_cita as id', 'id_usuario', 'id_servicio', 'title', 'start', 'end', 'color')->get();

        // Devolvemos las citas en formato JSON para FullCalendar
        return response()->json($citas);
    }

    public function getHorasOcupadas(Request $request)
    {
        // Obtenemos la fecha seleccionada desde la solicitud AJAX
        $fecha = $request->input('fecha');

        // Consultamos las citas en esa fecha
        $citas = Cita::where('fecha_cita', $fecha)->get();

        // Creamos un array para almacenar las horas ocupadas
        $horasOcupadas = [];

        // Recorremos las citas para agregar las horas ocupadas al array
        foreach ($citas as $cita) {
            $horasOcupadas[] = $cita->hora_cita;
        }

        // Devolvemos las horas ocupadas como JSON
        return response()->json($horasOcupadas);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_usuario' => 'required|string|max:255',
            'id_servicio' => 'required|integer',
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required|string|max:100',
        ]);

        // Obtener el servicio con el id proporcionado
        $servicio = \App\Models\Servicio::find($validatedData['id_servicio']);

        // Verificar si el servicio existe
        if (!$servicio) {
            return redirect()->back()->withErrors(['id_servicio' => 'El servicio seleccionado no es válido.']);
        }

        // Crear una nueva cita con los datos validados
        $cita = new Cita();
        $cita->id_usuario = $validatedData['id_usuario']; // Ajusta esto según cómo se guarde el usuario
        $cita->id_servicio = $validatedData['id_servicio'];
        $cita->fecha_cita = $validatedData['fecha_cita'];
        $cita->hora_cita = $validatedData['hora_cita'];
        $cita->title = $servicio->nomServicio; // Asigna el nombre del servicio como título
        $cita->color = '#FF0000'; // Color opcional
        $cita->estado = 'En proceso';
        $cita->save();

        return response()->json(['success' => true, 'cita_id' => $cita->id_cita]);
    }

    public function getDetalleCitaPago($id)
    {
        // Verificamos que el ID esté presente
        $cita = Cita::select(
            'citas.id_cita',
            'citas.title',
            'citas.fecha_cita',
            'citas.hora_cita',
            'citas.id_usuario',
            'servicios.nomServicio',
            'servicios.descripcion',
            'servicios.precio',
            'promociones.descuento'
        )
            ->join('servicios', 'citas.id_servicio', '=', 'servicios.id')
            ->leftJoin('promociones', 'servicios.id', '=', 'promociones.servicio_id')
            ->where('citas.id_cita', $id)
            ->first();

        // Si no se encuentra la cita, devolvemos un error
        if (!$cita) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        // Si no hay promoción, establecemos el descuento a 0
        $descuento = $cita->descuento ?? 0;

        // Devolvemos los detalles de la cita
        return response()->json([
            'id' => $cita->id_cita,
            'servicio' => $cita->nomServicio,
            'descripcion' => $cita->descripcion,
            'title' => $cita->title,
            'fecha' => $cita->fecha_cita,
            'hora' => $cita->hora_cita,
            'usuario' => $cita->id_usuario,
            'precio' => $cita->precio,
            'descuento' => $descuento
        ]);
    }

    public function getDetalleCita(Request $request)
    {
        $id = $request->input('id');

        if (!$id) {
            return response()->json(['error' => 'No se proporcionó un ID de cita'], 400);
        }

        $cita = Cita::with(['usuario', 'servicio'])->find($id);

        if (!$cita) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        if ($cita->id_usuario !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para ver esta cita.'], 403);
        }

        return response()->json([
            'id' => $cita->id_cita,
            'servicio' => $cita->servicio->nomServicio,
            'title' => $cita->title,
            'fecha' => $cita->fecha_cita,
            'hora' => $cita->hora_cita,
            'usuario' => $cita->usuario->nombre_completo,
            'precio' => $cita->servicio->precio,
            'estado' => $cita->estado
        ]);
    }

    public function deleteCita(Request $request)
    {
        $id = $request->input('id');
        $cita = Cita::find($id);

        if ($cita) {
            $cita->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Cita no encontrada.'], 404);
        }
    }
}
