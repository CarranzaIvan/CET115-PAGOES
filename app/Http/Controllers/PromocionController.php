<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::with('servicio')->get();
        return view('dashboard.promociones.index', compact('promociones'));
    }
    // Método para mostrar el formulario de creación de promociones
    public function edit($id)
    {
        $promocion = Promocion::findOrFail($id);
        return view('dashboard.promociones.edit', compact('promocion'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descuento' => 'required|numeric|min:0|max:100',
            'descripcion' => 'nullable|string',
            'servicio_id' => 'required|string|max:255',
            'fecha_expiracion' => 'required|date',
        ]);

        Promocion::create([
            'nombrePromocion' => $request->nombre,
            'descuento' => $request->descuento,
            'descripcion' => $request->descripcion,
            'servicio_id' => $request->servicio_id,
            'fecha_expiracion' => $request->fecha_expiracion,
        ]);

        return redirect()->route('promociones')->with('success', 'Promoción creada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descuento' => 'required|numeric|min:0|max:100',
            'descripcion' => 'nullable|string',
            'servicio_id' => 'required|string|max:255',
            'fecha_expiracion' => 'required|date',
        ]);

        $promocion = Promocion::findOrFail($id);
        $promocion->update([
            'nombrePromocion' => $request->nombre,
            'descuento' => $request->descuento,
            'descripcion' => $request->descripcion,
            'servicio_id' => $request->servicio_id,
            'fecha_expiracion' => $request->fecha_expiracion,
        ]);

        return redirect()->route('promociones')->with('success', 'Promoción actualizada exitosamente');
    }
    public function destroy($id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->delete();
        return redirect()->route('promociones')->with('success', 'Promoción eliminada exitosamente');
    }
    public function show($id)
    {
        $promocion = Promocion::with('servicio')->findOrFail($id);
        return view('dashboard.promociones.show', compact('promocion'));
    }
}
