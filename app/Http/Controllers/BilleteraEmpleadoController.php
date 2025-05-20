<?php

namespace App\Http\Controllers;

use App\Models\BilleteraEmpleado;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class BilleteraEmpleadoController extends Controller
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
    
    // Verificar empleado
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
    
    // Mostrar comisiones para el empleado
    public function misBilletera()
    {
        $empleado = $this->verificarEmpleado();
        
        $comisiones = BilleteraEmpleado::where('id_empleado', $empleado->id_empleado)
            ->with('lavada.vehiculo')
            ->orderBy('fecha', 'desc')
            ->paginate(15);
            
        $saldoTotal = BilleteraEmpleado::saldoActual($empleado->id_empleado);
        
        return view('empleado.billetera.index', compact('comisiones', 'saldoTotal', 'empleado'));
    }
    
    // Admin: Listar todas las billeteras
    public function index()
    {
        $this->verificarAdmin();
        
        $empleados = Empleado::with('usuario')
            ->get();
            
        // Calcular comisiones y pagos para cada empleado
        foreach ($empleados as $empleado) {
            $empleado->comisiones_total = BilleteraEmpleado::comisionesAcumuladas($empleado->id_empleado);
            $empleado->pagos_total = BilleteraEmpleado::pagosAcumulados($empleado->id_empleado);
            $empleado->saldo_actual = $empleado->comisiones_total - $empleado->pagos_total;
        }
        
        return view('admin.billetera.index', compact('empleados'));
    }
    
    // Admin: Ver detalle de billetera de un empleado
    public function show($id_empleado)
    {
        $this->verificarAdmin();
        
        $empleado = Empleado::with('usuario')->findOrFail($id_empleado);
        $transacciones = BilleteraEmpleado::where('id_empleado', $id_empleado)
            ->with('lavada.vehiculo')
            ->orderBy('fecha', 'desc')
            ->paginate(15);
            
        $comisiones = BilleteraEmpleado::comisionesAcumuladas($id_empleado);
        $pagos = BilleteraEmpleado::pagosAcumulados($id_empleado);
        $saldo = $comisiones - $pagos;
        
        return view('admin.billetera.show', compact('empleado', 'transacciones', 'comisiones', 'pagos', 'saldo'));
    }
    
    // Admin: Formulario para registrar pago
    public function createPago($id_empleado)
    {
        $this->verificarAdmin();
        
        $empleado = Empleado::with('usuario')->findOrFail($id_empleado);
        $saldoPendiente = BilleteraEmpleado::saldoActual($id_empleado);
        
        return view('admin.billetera.create-pago', compact('empleado', 'saldoPendiente'));
    }
    
    // Admin: Guardar pago
    public function storePago(Request $request, $id_empleado)
    {
        $this->verificarAdmin();
        
        $empleado = Empleado::findOrFail($id_empleado);
        $saldoPendiente = BilleteraEmpleado::saldoActual($id_empleado);
        
        $request->validate([
            'monto_comision' => "required|numeric|min:0|max:{$saldoPendiente}",
            'fecha' => 'required|date',
            'concepto' => 'nullable|string|max:255',
        ], [
            'monto_comision.max' => 'El monto no puede ser mayor al saldo pendiente de pago.',
        ]);
        
        BilleteraEmpleado::create([
            'id_empleado' => $id_empleado,
            'id_lavada' => null, // Los pagos no están asociados a una lavada específica
            'monto_comision' => $request->monto_comision,
            'fecha' => $request->fecha,
            'tipo' => 'pago',
            'concepto' => $request->concepto ?? 'Pago de comisiones',
        ]);
        
        return redirect()->route('admin.billetera.show', $id_empleado)
                ->with('success', 'Pago registrado correctamente');
    }
}