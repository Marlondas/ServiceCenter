<?php

namespace App\Http\Controllers;

use App\Models\Lavada;
use App\Models\Turno;
use App\Models\Empleado;
use App\Models\Cliente;
use App\Models\Servicio; // Nueva importación
use App\Models\BilleteraEmpleado; // Nueva importación
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LavadaController extends Controller
{
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

    // Formulario para registrar el lavado
    public function create($id_turno)
    {
        $empleado = $this->verificarEmpleado();
        
        $turno = Turno::where('id_empleado', $empleado->id_empleado)
                ->where('id_turno', $id_turno)
                ->where('estado', 'confirmado')
                ->with(['vehiculo.cliente.usuario'])
                ->firstOrFail();
        
        return view('empleado.lavadas.create', compact('turno'));
    }

    // Guardar el registro de lavado
    public function store(Request $request, $id_turno)
    {
        $empleado = $this->verificarEmpleado();
        
        $request->validate([
            'comentario' => 'nullable|string|max:500',
            'foto_antes' => 'nullable|image|max:2048', // Máximo 2MB
            'foto_despues' => 'nullable|image|max:2048',
        ]);

        // Buscar el turno
        $turno = Turno::where('id_empleado', $empleado->id_empleado)
                ->where('id_turno', $id_turno)
                ->where('estado', 'confirmado')
                ->firstOrFail();
        
        // Guardar las fotos si existen
        $foto_antes_path = null;
        if ($request->hasFile('foto_antes')) {
            $foto_antes_path = $request->file('foto_antes')->store('lavadas', 'public');
        }
        
        $foto_despues_path = null;
        if ($request->hasFile('foto_despues')) {
            $foto_despues_path = $request->file('foto_despues')->store('lavadas', 'public');
        }
        
        // Crear el registro de lavada
        $lavada = Lavada::create([
            'fecha' => now()->format('Y-m-d'),
            'hora' => now()->format('H:i:s'),
            'id_vehiculo' => $turno->id_vehiculo,
            'id_empleado' => $empleado->id_empleado,
            'id_turno' => $turno->id_turno,
            'foto_antes' => $foto_antes_path,
            'foto_despues' => $foto_despues_path,
            'comentario' => $request->comentario,
        ]);
        
        // Cambiar estado del turno a completado
        $turno->update(['estado' => 'completado']);
        
        // NUEVO CÓDIGO: Cálculo de comisiones
        // Obtener información del servicio
        $servicio = null;
        if ($turno->id_servicio) {
            $servicio = Servicio::find($turno->id_servicio);
        }
        
        if (!$servicio && !empty($turno->tipo_servicio)) {
            // Buscar servicio por nombre si no hay relación directa (para turnos antiguos)
            $servicio = Servicio::where('nombre', $turno->tipo_servicio)->first();
        }
        
        // Determinar precio del servicio
        $precioServicio = $servicio ? $servicio->precio : 25000; // Precio por defecto
        
        // Calcular comisión del empleado
        $porcentajeComision = $empleado->comision ?? 10; // Porcentaje por defecto si no está definido
        $montoComision = ($precioServicio * $porcentajeComision) / 100;
        
        // Registrar en la billetera del empleado
        BilleteraEmpleado::create([
            'id_empleado' => $empleado->id_empleado,
            'id_lavada' => $lavada->id_lavada,
            'monto_comision' => $montoComision,
            'fecha' => now()->format('Y-m-d'),
             'tipo' => 'comision'
        ]);
        
        // Redirigir al listado de turnos
        return redirect()->route('empleado.turnos')
                ->with('success', 'Lavado registrado correctamente y turno completado');
    }

    // Ver detalle de un lavado
    public function show($id_lavada)
    {
        $empleado = $this->verificarEmpleado();
        
        $lavada = Lavada::where('id_empleado', $empleado->id_empleado)
                ->where('id_lavada', $id_lavada)
                ->with(['vehiculo.cliente.usuario', 'turno'])
                ->firstOrFail();
        
        return view('empleado.lavadas.show', compact('lavada'));
    }
    // En LavadaController, agregar estos métodos:

    // Listar lavadas para el empleado
    public function indexEmpleado()
    {
        $empleado = $this->verificarEmpleado();
        
        $lavadas = Lavada::where('id_empleado', $empleado->id_empleado)
                ->with(['vehiculo', 'turno'])
                ->orderBy('fecha', 'desc')
                ->orderBy('hora', 'desc')
                ->paginate(10);
        
        return view('empleado.lavadas.index', compact('lavadas'));
    }

    // Método para verificar cliente (para las rutas del cliente)
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

    // Listar lavadas para el cliente
    public function indexCliente()
    {
        $cliente = $this->verificarCliente();
        
        $lavadas = Lavada::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })
            ->with(['vehiculo', 'turno', 'empleado.usuario'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(10);
        
        return view('cliente.lavadas.index', compact('lavadas'));
    }

    // Ver detalle de lavada para el cliente
    public function showCliente($id_lavada)
    {
        $cliente = $this->verificarCliente();
        
        $lavada = Lavada::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })
            ->with(['vehiculo', 'turno', 'empleado.usuario'])
            ->where('id_lavada', $id_lavada)
            ->firstOrFail();
        
        return view('cliente.lavadas.show', compact('lavada'));
    }
    // Método para verificar admin
    private function verificarAdmin()
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'admin') {
            redirect()->route('login.form')
                    ->with('error', 'Acceso no autorizado')
                    ->send();
            exit;
        }
    }

    // Listar todas las lavadas para el administrador
    public function adminIndex(Request $request)
    {
        $this->verificarAdmin();
        
        $query = Lavada::with(['vehiculo.cliente.usuario', 'empleado.usuario', 'turno']);
        
        // Aplicar filtros si existen
        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }
        
        if ($request->filled('cliente')) {
            $query->whereHas('vehiculo.cliente.usuario', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }
        
        if ($request->filled('empleado')) {
            $query->whereHas('empleado.usuario', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->empleado . '%');
            });
        }
        
        if ($request->filled('placa')) {
            $query->whereHas('vehiculo', function($q) use ($request) {
                $q->where('placa', 'like', '%' . $request->placa . '%');
            });
        }
        
        // Ordenar por fecha y hora, más reciente primero
        $lavadas = $query->orderBy('fecha', 'desc')
                         ->orderBy('hora', 'desc')
                         ->paginate(15);
        
        return view('admin.lavadas.index', compact('lavadas'));
    }

    // Ver detalle de lavada (admin)
    public function adminShow($id_lavada)
    {
        $this->verificarAdmin();
        
        $lavada = Lavada::with(['vehiculo.cliente.usuario', 'empleado.usuario', 'turno'])
                        ->findOrFail($id_lavada);
        
        return view('admin.lavadas.show', compact('lavada'));
    }
    // Mostrar formulario para calificar
    public function calificar($id_lavada)
    {
        $cliente = $this->verificarCliente();
        
        $lavada = Lavada::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })
            ->with(['vehiculo.marca', 'turno', 'empleado.usuario'])
            ->where('id_lavada', $id_lavada)
            ->firstOrFail();
        
        return view('cliente.lavadas.calificar', compact('lavada'));
    }

    // Guardar la calificación
    public function guardarCalificacion(Request $request, $id_lavada)
    {
        $cliente = $this->verificarCliente();
        
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);
        
        $lavada = Lavada::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })
            ->where('id_lavada', $id_lavada)
            ->firstOrFail();
        
        $lavada->update([
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario
        ]);
        
        return redirect()->route('cliente.lavadas.show', $lavada->id_lavada)
                    ->with('success', 'Tu calificación ha sido guardada. ¡Gracias por tus comentarios!');
    }

    // Mostrar formulario para calificar lavada
    public function calificarForm($id_lavada)
    {
        $cliente = $this->verificarCliente();
        
        // Buscar la lavada y asegurarse que pertenezca al cliente
        $lavada = Lavada::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })
            ->where('id_lavada', $id_lavada)
            ->with(['vehiculo', 'turno', 'empleado.usuario'])
            ->firstOrFail();
        
        // Verificar si ya está calificada
        if ($lavada->calificacion !== null) {
            return redirect()->route('cliente.lavadas.show', $lavada->id_lavada)
                    ->with('info', 'Este servicio ya ha sido calificado anteriormente.');
        }
        
        return view('cliente.lavadas.calificar', compact('lavada'));
    }

    // Procesar la calificación
    public function calificarStore(Request $request, $id_lavada)
    {
        $cliente = $this->verificarCliente();
        
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario_cliente' => 'nullable|string|max:500',
        ]);
        
        // Buscar la lavada y asegurarse que pertenezca al cliente
        $lavada = Lavada::whereHas('vehiculo', function($query) use ($cliente) {
                $query->where('id_cliente', $cliente->id_cliente);
            })
            ->where('id_lavada', $id_lavada)
            ->firstOrFail();
        
        // Verificar si ya está calificada
        if ($lavada->calificacion !== null) {
            return redirect()->route('cliente.lavadas.show', $lavada->id_lavada)
                    ->with('info', 'Este servicio ya ha sido calificado anteriormente.');
        }
        
        // Actualizar la calificación
        $lavada->update([
            'calificacion' => $request->calificacion,
            'comentario_cliente' => $request->comentario_cliente,
        ]);
        
        return redirect()->route('cliente.lavadas.show', $lavada->id_lavada)
                ->with('success', '¡Gracias por calificar nuestro servicio!');
    }
}