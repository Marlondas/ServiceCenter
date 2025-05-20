<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index()
    {
        // Obtener todos los empleados con sus usuarios relacionados
        $empleados = Empleado::with('usuario')->get();
        
        return view('admin.empleados.index', compact('empleados'));
    }
    
    public function create()
    {
        return view('admin.empleados.create');
    }
    
   public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|unique:usuarios,correo',
        'contraseña' => 'required|min:6',
        'cargo' => 'required|string|max:100',
        'comision' => 'required|numeric|min:0|max:100',
    ]);
    
    DB::beginTransaction();
    try {
        // Crear el usuario
        $usuario = Usuario::create([
            'nombre' => trim($request->nombre),
            'correo' => strtolower(trim($request->correo)),
            'contraseña' => Hash::make($request->contraseña),
            'rol' => 'empleado',
            'cambiar_password' => true  // Obligar a cambiar la contraseña al primer inicio de sesión
        ]);
        
        // Crear el empleado asociado
        Empleado::create([
            'cargo' => $request->cargo,
            'comision' => $request->comision,
            'id_usuario' => $usuario->id_usuario
        ]);
        
        DB::commit();
        return redirect()->route('admin.empleados.index')
            ->with('success', 'Empleado creado exitosamente');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error al crear el empleado: ' . $e->getMessage())->withInput();
    }
}
    
    public function edit($id)
    {
        $empleado = Empleado::with('usuario')->findOrFail($id);
        return view('admin.empleados.edit', compact('empleado'));
    }
    
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo,' . $empleado->id_usuario . ',id_usuario',
            'cargo' => 'required|string|max:100',
            'comision' => 'required|numeric|min:0|max:100',
        ]);
        
        DB::beginTransaction();
        try {
            // Actualizar usuario
            $usuario = Usuario::findOrFail($empleado->id_usuario);
            $usuario->update([
                'nombre' => $request->nombre,
                'correo' => $request->correo
            ]);
            
            // Si se proporcionó nueva contraseña, actualizarla
            if ($request->filled('contraseña')) {
                $usuario->contraseña = Hash::make($request->contraseña);
                $usuario->save();
            }
            
            // Actualizar empleado
            $empleado->update([
                'cargo' => $request->cargo,
                'comision' => $request->comision
            ]);
            
            DB::commit();
            return redirect()->route('admin.empleados.index')
                ->with('success', 'Empleado actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el empleado: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            
            // Eliminar el empleado y el usuario asociado (por la restricción ON DELETE CASCADE)
            $empleado->delete();
            
            return redirect()->route('admin.empleados.index')
                ->with('success', 'Empleado eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }
}