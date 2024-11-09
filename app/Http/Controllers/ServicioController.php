<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Support\Facades\Storage; // Importa la clase Storage

class ServicioController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Fetch services that do not have an associated promotion
        $servicios = Servicio::where('nomServicio', 'LIKE', "%{$query}%")
            ->whereDoesntHave('promocion')
            ->get();

        return response()->json($servicios);
    }

    // Nuevo método para cargar la vista con todos los servicios
    public function showRegistrarCita()
    {
        // Obtenemos todos los servicios de la base de datos
        $servicios = Servicio::all();

        // Retornamos la vista con los servicios
        return view('registrar_cita', compact('servicios'));
    }

    // Carga la vista de servicios.
    public function verServicios()
    {

        // Obtiene todos los servicios
        $servicios = Servicio::all();

        // Devuelve la vista y pasa los servicios
        return view('VistaServicios.servicios', compact('servicios'));
    }

    // Carga la vista de gestión de servicios.
    public function gestionServicios()
    {

        // Obtiene todos los servicios
        $servicios = Servicio::all();

        // Devuelve la vista y pasa los servicios
        return view('VistaServicios.gestionServicios', compact('servicios'));
    }

    public function eliminarServicio($idServicio)
    {
        // Obtiene el servicio por el ID
        $servicio = Servicio::find($idServicio);

        // Verifica si el servicio existe
        if (!$servicio) {
            // Puedes redirigir con un mensaje de error si no se encuentra el servicio
            return redirect('/servicios/gestion')->with('error', 'Servicio no encontrado.');
        }

        // Elimina la imagen del storage si existe
        if ($servicio->imagen) {
            // Elimina la imagen del sistema de archivos
            Storage::disk('public')->delete($servicio->imagen);
        }

        // Elimina el servicio
        $servicio->delete();

        // Devuelve la vista de gestión de servicios
        return redirect('/servicios/gestion')->with('success', 'Servicio eliminado correctamente.');
    }



    public function guardarServicio(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nomServicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Asegúrate de ajustar según tus necesidades
        ]);

        // Crear una nueva instancia del servicio
        $servicio = new Servicio();
        $servicio->nomServicio = $request->nomServicio;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            // Obtener la extensión de la imagen
            $extension = $request->file('imagen')->getClientOriginalExtension();

            // Crear un nuevo nombre para la imagen con el ID que será asignado después de guardar
            $imagenName = time() . '.' . $extension; // Ejemplo: 1616161616.jpg
            $imagenPath = $request->file('imagen')->storeAs('images/servicios', $imagenName, 'public');

            // Almacenar la ruta de la imagen en el servicio
            $servicio->imagen = $imagenPath;
        }

        // Guardar el servicio
        $servicio->save();

        // Redirigir a la vista de gestión de servicios con un mensaje de éxito
        return redirect('/servicios/gestion')->with('success', 'Servicio creado con éxito.');
    }



    public function actualizarServicio(Request $request, $idServicio)
    {
        // Encontrar el servicio
        $servicio = Servicio::findOrFail($idServicio);

        // Actualizar los campos
        $servicio->nomServicio = $request->nomServicio;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen antigua si existe
            if ($servicio->imagen) {
                Storage::disk('public')->delete($servicio->imagen);
            }

            // Obtener la extensión de la imagen
            $extension = $request->file('imagen')->getClientOriginalExtension();

            // Crear un nuevo nombre para la imagen con el ID del servicio
            $imagenName = $idServicio . '.' . $extension; // Por ejemplo: 1.jpg
            $imagenPath = $request->file('imagen')->storeAs('images/servicios', $imagenName, 'public');

            // Actualizar la ruta de la imagen en el servicio
            $servicio->imagen = $imagenPath;
        }

        // Guardar los cambios
        $servicio->save();

        // Redirigir a la vista de gestión de servicios con un mensaje de éxito
        return redirect('/servicios/gestion')->with('success', 'Servicio actualizado con éxito.');
    }
}
