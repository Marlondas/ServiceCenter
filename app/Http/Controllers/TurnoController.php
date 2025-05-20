<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Empleado;
use App\Models\Vehiculo;
use App\Models\Cliente;
use App\Models\Servicio; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class TurnoController extends Controller
{
    // Métodos privados para verificación de roles
    private function verificarCliente()
    {
        $id_usuario = Session::get('id_usuario');
        $cliente = Cliente::where('id_usuario', $id_usuario)->first();
        
        if (!$cliente) {
            redirect()->route('cliente.dashboard')
                    ->with('error', 'No se encontró el perfil de cliente asociado a su cuenta')
                    ->send();
            exit;
        }
        
        return $cliente;
    }

    private function verificarEmpleado()
    {
        $id_usuario = Session::get('id_usuario');
        $empleado = Empleado::where('id_usuario', $id_usuario)->first();
        
        if (!$empleado) {
            redirect()->route('empleado.dashboard')
                    ->with('error', 'No tiene acceso a esta sección')
                    ->send();
            exit;
        }
        
        return $empleado;
    }

    private function verificarAdmin()
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'admin') {
            redirect()->route('login.form')
                    ->with('error', 'Acceso no autorizado')
                    ->send();
            exit;
        }
    }

    // NUEVO MÉTODO: Obtener servicios según el tipo de vehículo
    public function getServiciosPorVehiculo($id_vehiculo)
    {
        try {
            $vehiculo = Vehiculo::findOrFail($id_vehiculo);
            
            // Determinar el tipo de vehículo (con valor por defecto si no existe)
            $tipoVehiculo = $vehiculo->tipo_vehiculo ?? 'carro';
            
            // Obtener servicios que coincidan con el tipo de vehículo o sean para ambos
            $servicios = Servicio::where('activo', true)
                        ->where(function($query) use ($tipoVehiculo) {
                            $query->where('tipo_vehiculo', $tipoVehiculo)
                                ->orWhere('tipo_vehiculo', 'ambos');
                        })
                        ->orderBy('nombre')
                        ->get();
            
            return response()->json($servicios);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener servicios: ' . $e->getMessage()], 500);
        }
    }

    // Vista para que el cliente solicite un turno
    public function solicitarForm()
    {
        $cliente = $this->verificarCliente();
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get(); // Obtener servicios activos
        $vehiculos = Vehiculo::where('id_cliente', $cliente->id_cliente)->get();
        
        // Si no tiene vehículos registrados, redirigir a la página para registrar uno
        if ($vehiculos->isEmpty()) {
            return redirect()->route('cliente.vehiculos.create')->with('info', 'Debe registrar un vehículo antes de solicitar un turno');
        }
        
        return view('cliente.turnos.create', compact('vehiculos', 'servicios'));
    }
    
    // Procesar la solicitud de turno
    public function solicitar(Request $request)
    {
        $cliente = $this->verificarCliente();
        
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'id_servicio' => 'required|exists:servicios,id_servicio', // Validar id_servicio
        ], [
            'id_vehiculo.required' => 'Debe seleccionar un vehículo',
            'id_vehiculo.exists' => 'El vehículo seleccionado no existe',
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.after_or_equal' => 'La fecha debe ser igual o posterior a hoy',
            'hora.required' => 'La hora es obligatoria',
            'id_servicio.required' => 'Debe seleccionar un servicio',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Verificar que el vehículo pertenezca al cliente
            $vehiculo = Vehiculo::where('id_cliente', $cliente->id_cliente)
                ->where('id_vehiculo', $request->id_vehiculo)
                ->first();
            
            if (!$vehiculo) {
                return back()->with('error', 'El vehículo seleccionado no le pertenece')->withInput();
            }
            
            // Verificar si el vehículo ya tiene un turno pendiente o confirmado
            $turnoExistente = Turno::where('id_vehiculo', $request->id_vehiculo)
                ->whereIn('estado', ['pendiente', 'confirmado'])
                ->first();
                
            if ($turnoExistente) {
                return back()->with('error', 'Este vehículo ya tiene un turno pendiente o confirmado. No puede agendar otro turno hasta que el actual sea completado o cancelado.')->withInput();
            }
            
            // Verificar que el servicio sea compatible con el tipo de vehículo
            $servicio = Servicio::findOrFail($request->id_servicio);
            $tipoVehiculo = $vehiculo->tipo_vehiculo ?? 'carro';
            
            if ($servicio->tipo_vehiculo !== 'ambos' && $servicio->tipo_vehiculo !== $tipoVehiculo) {
                return back()->with('error', 'El servicio seleccionado no es compatible con este tipo de vehículo')->withInput();
            }
            
            // Buscar un empleado disponible para la fecha y hora seleccionada
            $empleado = $this->buscarEmpleadoDisponible($request->fecha, $request->hora);
            
            if (!$empleado) {
                return back()->with('error', 'No hay empleados disponibles para la fecha y hora seleccionada. Por favor, elija otro horario.')->withInput();
            }
            
            // Crear el turno
            Turno::create([
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => 'pendiente',
                'id_vehiculo' => $request->id_vehiculo,
                'id_empleado' => $empleado->id_empleado,
                'id_servicio' => $request->id_servicio,
                'tipo_servicio' => $servicio->nombre, // Usar el nombre del servicio
                'comentarios' => $request->comentarios,
            ]);
            
            DB::commit();
            return redirect()->route('cliente.turnos')->with('success', 'Turno solicitado correctamente. Se le ha asignado un empleado para atenderlo.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al solicitar el turno: ' . $e->getMessage())->withInput();
        }
    }
    
    // Método para buscar un empleado disponible
    private function buscarEmpleadoDisponible($fecha, $hora)
    {
        // Obtener IDs de empleados que ya tienen turno a esa hora y fecha
        $empleadosOcupados = Turno::where('fecha', $fecha)
            ->where('hora', $hora)
            ->where('estado', '!=', 'cancelado')
            ->pluck('id_empleado')
            ->toArray();
        
        // Buscar un empleado que no esté ocupado
        return Empleado::whereNotIn('id_empleado', $empleadosOcupados)
            ->inRandomOrder() // Seleccionar aleatoriamente para balancear la carga
            ->first();
    }
    
    // Ver turnos del cliente
    public function clienteTurnos()
    {
        $cliente = $this->verificarCliente();
        
        $turnos = Turno::whereHas('vehiculo', function($query) use ($cliente) {
            $query->where('id_cliente', $cliente->id_cliente);
        })->with(['vehiculo', 'empleado.usuario'])
        ->orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->get();
        
        return view('cliente.turnos.index', compact('turnos'));
    }
    
    // Cancelar turno (cliente)
    public function cancelar($id)
    {
        try {
            $cliente = $this->verificarCliente();
            
            $turno = Turno::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })->findOrFail($id);
            
            // Solo se puede cancelar si está pendiente (no confirmado, completado o ya cancelado)
            if ($turno->estado != 'pendiente') {
                return back()->with('error', 'No se puede cancelar un turno que ya ha sido confirmado, completado o cancelado');
            }
            
            // Cancelar el turno
            $turno->update(['estado' => 'cancelado']);
            
            return redirect()->route('cliente.turnos')->with('success', 'Turno cancelado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cancelar el turno: ' . $e->getMessage());
        }
    }
    
    // Ver turnos del empleado
    public function empleadoTurnos()
    {
        $empleado = $this->verificarEmpleado();
        
        $turnos = Turno::where('id_empleado', $empleado->id_empleado)
            ->with(['vehiculo.cliente.usuario'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();
        
        // Agrupar por fecha para mejor visualización
        $turnosPorFecha = $turnos->groupBy('fecha');
        
        return view('empleado.turnos.index', compact('turnosPorFecha'));
    }
    
    // Cambiar estado de turno (empleado)
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:confirmado,completado,cancelado',
        ]);
        
        try {
            $empleado = $this->verificarEmpleado();
            
            // Si está tratando de confirmar un turno, verificar que no tenga otros confirmados sin completar
            if ($request->estado == 'confirmado') {
                $turnosConfirmados = Turno::where('id_empleado', $empleado->id_empleado)
                    ->where('estado', 'confirmado')
                    ->count();
                    
                if ($turnosConfirmados > 0) {
                    return back()->with('error', 'No puedes confirmar un nuevo turno hasta completar los actuales');
                }
            }
            
            $turno = Turno::where('id_empleado', $empleado->id_empleado)
                ->findOrFail($id);
            
            // Actualizar estado
            $turno->update(['estado' => $request->estado]);
            
            return redirect()->route('empleado.turnos')->with('success', 'Estado del turno actualizado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el estado del turno: ' . $e->getMessage());
        }
    }
    
    // Admin: Listar todos los turnos
    public function adminTurnos(Request $request)
    {
        $this->verificarAdmin();
        
        $query = Turno::with(['vehiculo.cliente.usuario', 'empleado.usuario']);
        
        // Filtros
        if ($request->filled('fecha')) {
            $query->where('fecha', $request->fecha);
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('empleado')) {
            $query->whereHas('empleado.usuario', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->empleado . '%');
            });
        }
        
        $turnos = $query->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();
        
        $empleados = Empleado::with('usuario')->get();
        
        return view('admin.turnos.index', compact('turnos', 'empleados'));
    }
    
    // Admin: Mostrar formulario para crear un turno
    public function adminCreate()
    {
        $this->verificarAdmin();
        
        $vehiculos = Vehiculo::with('cliente.usuario')->get();
        $empleados = Empleado::with('usuario')->get();
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        
        return view('admin.turnos.create', compact('vehiculos', 'empleados', 'servicios'));
    }
    
    // Admin: Guardar un nuevo turno
    public function adminStore(Request $request)
    {
        $this->verificarAdmin();
        
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|in:pendiente,confirmado,completado,cancelado',
        ]);
        
        try {
            // Verificar si el vehículo ya tiene un turno pendiente o confirmado
            $turnoExistente = Turno::where('id_vehiculo', $request->id_vehiculo)
                ->whereIn('estado', ['pendiente', 'confirmado'])
                ->first();
                
            if ($turnoExistente && !in_array($request->estado, ['completado', 'cancelado'])) {
                return back()->with('error', 'Este vehículo ya tiene un turno pendiente o confirmado. No puede agendar otro turno hasta que el actual sea completado o cancelado.')->withInput();
            }
            
            // Verificar si el empleado está disponible
            $empleadoOcupado = Turno::where('id_empleado', $request->id_empleado)
                ->where('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->where('estado', '!=', 'cancelado')
                ->exists();
                
            if ($empleadoOcupado) {
                return back()->with('error', 'El empleado seleccionado ya tiene un turno asignado en esa fecha y hora')->withInput();
            }
            
            // Verificar compatibilidad entre servicio y vehículo
            $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
            $servicio = Servicio::findOrFail($request->id_servicio);
            $tipoVehiculo = $vehiculo->tipo_vehiculo ?? 'carro';
            
            if ($servicio->tipo_vehiculo !== 'ambos' && $servicio->tipo_vehiculo !== $tipoVehiculo) {
                return back()->with('error', 'El servicio seleccionado no es compatible con este tipo de vehículo')->withInput();
            }
            
            // Crear el turno
            Turno::create([
                'id_vehiculo' => $request->id_vehiculo,
                'id_empleado' => $request->id_empleado,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => $request->estado,
                'id_servicio' => $request->id_servicio,
                'tipo_servicio' => $servicio->nombre,
                'comentarios' => $request->comentarios,
            ]);
            
            return redirect()->route('admin.turnos')->with('success', 'Turno creado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el turno: ' . $e->getMessage())->withInput();
        }
    }
    
    // Admin: Editar turno
    public function adminEdit($id)
    {
        $this->verificarAdmin();
        
        $turno = Turno::with(['vehiculo.cliente.usuario', 'empleado.usuario'])->findOrFail($id);
        $vehiculos = Vehiculo::with('cliente.usuario')->get();
        $empleados = Empleado::with('usuario')->get();
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        $tiposServicio = $servicios->pluck('nombre')->unique()->toArray();
    
        return view('admin.turnos.edit', compact('turno', 'vehiculos', 'empleados', 'servicios', 'tiposServicio'));
    }
      
    
    // Admin: Actualizar turno
    public function adminUpdate(Request $request, $id)
    {
        $this->verificarAdmin();
        
        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|in:pendiente,confirmado,completado,cancelado',
        ]);
        
        try {
            $turno = Turno::findOrFail($id);
            
            // Si se cambia el vehículo o el estado a pendiente/confirmado, verificar que no tenga otro turno activo
            if (($turno->id_vehiculo != $request->id_vehiculo || 
                (in_array($request->estado, ['pendiente', 'confirmado']) && !in_array($turno->estado, ['pendiente', 'confirmado']))) &&
                in_array($request->estado, ['pendiente', 'confirmado'])) {
                
                $turnoExistente = Turno::where('id_vehiculo', $request->id_vehiculo)
                    ->whereIn('estado', ['pendiente', 'confirmado'])
                    ->where('id_turno', '!=', $id)
                    ->first();
                    
                if ($turnoExistente) {
                    return back()->with('error', 'Este vehículo ya tiene un turno pendiente o confirmado. No puede agendar otro turno hasta que el actual sea completado o cancelado.')->withInput();
                }
            }
            
            // Verificar si el empleado está disponible (solo si se cambia el empleado, la fecha o la hora)
            if ($turno->id_empleado != $request->id_empleado || 
                $turno->fecha != $request->fecha || 
                $turno->hora != $request->hora) {
                
                $empleadoOcupado = Turno::where('id_empleado', $request->id_empleado)
                    ->where('fecha', $request->fecha)
                    ->where('hora', $request->hora)
                    ->where('estado', '!=', 'cancelado')
                    ->where('id_turno', '!=', $id)
                    ->exists();
                    
                if ($empleadoOcupado) {
                    return back()->with('error', 'El empleado seleccionado ya tiene un turno asignado en esa fecha y hora')->withInput();
                }
            }
            
            // Verificar compatibilidad entre servicio y vehículo
            $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
            $servicio = Servicio::findOrFail($request->id_servicio);
            $tipoVehiculo = $vehiculo->tipo_vehiculo ?? 'carro';
            
            if ($servicio->tipo_vehiculo !== 'ambos' && $servicio->tipo_vehiculo !== $tipoVehiculo) {
                return back()->with('error', 'El servicio seleccionado no es compatible con este tipo de vehículo')->withInput();
            }
            
            // Actualizar turno
            $turno->update([
                'id_vehiculo' => $request->id_vehiculo,
                'id_empleado' => $request->id_empleado,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => $request->estado,
                'id_servicio' => $request->id_servicio,
                'tipo_servicio' => $servicio->nombre,
                'comentarios' => $request->comentarios,
            ]);
            
            return redirect()->route('admin.turnos')->with('success', 'Turno actualizado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el turno: ' . $e->getMessage())->withInput();
        }
    }
    
    // Admin: Eliminar turno
    public function adminDestroy($id)
    {
        $this->verificarAdmin();
        
        try {
            $turno = Turno::findOrFail($id);
            $turno->delete();
            
            return redirect()->route('admin.turnos')->with('success', 'Turno eliminado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el turno: ' . $e->getMessage());
        }
    }
}