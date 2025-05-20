<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServicioController extends Controller
{
    // Verificar admin
    private function verificarAdmin()
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'admin') {
            redirect()->route('login.form')
                    ->with('error', 'Acceso no autorizado')
                    ->send();
            exit;
        }
    }
    
    // Listar servicios
    public function index()
    {
        $this->verificarAdmin();
        
        $servicios = Servicio::orderBy('nombre')->get();
        
        return view('admin.servicios.index', compact('servicios'));
    }
    
    // Mostrar formulario para crear servicio
    public function create()
{
    $this->verificarAdmin();
    
    // Definir tipos de vehículo para el servicio
    $tipos_vehiculo = ['carro', 'moto', 'ambos'];
    
    // Crear un objeto servicio con valor predeterminado para tipo_vehiculo
    $servicio = new Servicio();
    $servicio->tipo_vehiculo = null; // Ninguna opción seleccionada por defecto
    
    return view('admin.servicios.create', compact('tipos_vehiculo', 'servicio'));
}
    
    // Guardar servicio
    public function store(Request $request)
    {
        $this->verificarAdmin();
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:servicios',
            'precio' => 'required|numeric|min:0',
            'duracion_estimada' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'tipo_vehiculo' => 'required|in:carro,moto,ambos', // Validación para tipo_vehiculo
        ], [
            'nombre.required' => 'El nombre del servicio es obligatorio',
            'nombre.unique' => 'Ya existe un servicio con este nombre',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un valor numérico',
            'precio.min' => 'El precio no puede ser negativo',
            'tipo_vehiculo.required' => 'El tipo de vehículo es obligatorio',
            'tipo_vehiculo.in' => 'El tipo de vehículo debe ser carro, moto o ambos',
        ]);
        
        Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'duracion_estimada' => $request->duracion_estimada,
            'activo' => $request->has('activo') ? true : false, // Explícitamente convertir a booleano
            'tipo_vehiculo' => $request->tipo_vehiculo, // Guardar el tipo de vehículo
        ]);
        
        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio creado correctamente');
    }
    
    // Mostrar formulario para editar servicio
    public function edit($id)
    {
        $this->verificarAdmin();
        
        $servicio = Servicio::findOrFail($id);
        $tipos_vehiculo = ['carro', 'moto', 'ambos']; // Definir tipos de vehículo
        
        return view('admin.servicios.edit', compact('servicio', 'tipos_vehiculo'));
    }
    
    // Actualizar servicio
   public function update(Request $request, $id)
{
    $this->verificarAdmin();
    
    // Muestra los datos recibidos para depuración
    // dd($request->all());
    
    $servicio = Servicio::findOrFail($id);
    
    $validated = $request->validate([
        'nombre' => 'required|string|max:100|unique:servicios,nombre,' . $id . ',id_servicio',
        'precio' => 'required|numeric|min:0',
        'duracion_estimada' => 'nullable|string|max:50',
        'descripcion' => 'nullable|string',
        'tipo_vehiculo' => 'required|in:carro,moto,ambos',
    ], /* mensajes de error */);
    
    // Actualizar campos por separado para asegurar que se actualicen
    $servicio->nombre = $request->nombre;
    $servicio->descripcion = $request->descripcion;
    $servicio->precio = $request->precio;
    $servicio->duracion_estimada = $request->duracion_estimada;
    $servicio->activo = $request->has('activo') ? true : false;
    $servicio->tipo_vehiculo = $request->tipo_vehiculo; // Asegurar que este campo se actualice
    
    // Guardar los cambios
    $servicio->save();
    
    return redirect()->route('admin.servicios.index')
        ->with('success', 'Servicio actualizado correctamente');
}
    
    // Eliminar servicio
    public function destroy($id)
    {
        $this->verificarAdmin();
        
        $servicio = Servicio::findOrFail($id);
        
        // Verificar si hay turnos asociados
        if ($servicio->turnos()->exists()) {
            return back()->with('error', 'No se puede eliminar este servicio porque existen turnos asociados');
        }
        
        $servicio->delete();
        
        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio eliminado correctamente');
    }
    
    // Cambiar estado (activar/desactivar)
    public function toggleStatus($id)
    {
        $this->verificarAdmin();
        
        $servicio = Servicio::findOrFail($id);
        $servicio->activo = !$servicio->activo;
        $servicio->save();
        
        $estado = $servicio->activo ? 'activado' : 'desactivado';
        
        return redirect()->route('admin.servicios.index')
            ->with('success', "Servicio {$estado} correctamente");
    }
}