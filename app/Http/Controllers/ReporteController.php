<?php

namespace App\Http\Controllers;

use App\Services\ReporteService;  // Cambiado de App\Models\ReporteService
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ReporteController extends Controller
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
    
    // Dashboard principal
    public function dashboard(Request $request)
    {
        $this->verificarAdmin();
        
        $desde = null;
        $hasta = null;
        
        if ($request->filled('desde') && $request->filled('hasta')) {
            $desde = Carbon::parse($request->desde);
            $hasta = Carbon::parse($request->hasta);
        } elseif ($request->filled('periodo')) {
            // Períodos predefinidos
            switch ($request->periodo) {
                case 'hoy':
                    $desde = Carbon::today();
                    $hasta = Carbon::today()->endOfDay();
                    break;
                case 'semana':
                    $desde = Carbon::now()->startOfWeek();
                    $hasta = Carbon::now()->endOfWeek();
                    break;
                case 'mes':
                    $desde = Carbon::now()->startOfMonth();
                    $hasta = Carbon::now()->endOfMonth();
                    break;
                case 'año':
                    $desde = Carbon::now()->startOfYear();
                    $hasta = Carbon::now()->endOfYear();
                    break;
                default:
                    $desde = Carbon::now()->subDays(30);
                    $hasta = Carbon::now();
            }
        } else {
            // Por defecto: último mes
            $desde = Carbon::now()->subDays(30);
            $hasta = Carbon::now();
        }
        
        $data = ReporteService::getDashboardData($desde, $hasta);
        
        return view('admin.reportes.dashboard', compact('data', 'desde', 'hasta'));
    }
    
    // Reporte de empleados
    public function empleados(Request $request)
    {
        $this->verificarAdmin();
        
        $desde = $request->filled('desde') ? Carbon::parse($request->desde) : Carbon::now()->subDays(30);
        $hasta = $request->filled('hasta') ? Carbon::parse($request->hasta) : Carbon::now();
        
        $empleados = ReporteService::reporteEmpleados($desde, $hasta);
        
        return view('admin.reportes.empleados', compact('empleados', 'desde', 'hasta'));
    }
    
    // Reporte de clientes
    public function clientes(Request $request)
    {
        $this->verificarAdmin();
        
        $desde = $request->filled('desde') ? Carbon::parse($request->desde) : Carbon::now()->subDays(30);
        $hasta = $request->filled('hasta') ? Carbon::parse($request->hasta) : Carbon::now();
        
        $clientes = ReporteService::reporteClientes($desde, $hasta);
        
        return view('admin.reportes.clientes', compact('clientes', 'desde', 'hasta'));
    }
    
    // Reporte de servicios
    public function servicios(Request $request)
    {
        $this->verificarAdmin();
        
        $desde = $request->filled('desde') ? Carbon::parse($request->desde) : Carbon::now()->subDays(30);
        $hasta = $request->filled('hasta') ? Carbon::parse($request->hasta) : Carbon::now();
        
        $serviciosPopulares = ReporteService::serviciosPopulares($desde, $hasta, 10);
        $serviciosPorTipoVehiculo = ReporteService::serviciosPorTipoVehiculo($desde, $hasta);
        
        return view('admin.reportes.servicios', compact('serviciosPopulares', 'serviciosPorTipoVehiculo', 'desde', 'hasta'));
    }
    
    // Exportar reportes a Excel/PDF
    public function exportar(Request $request)
    {
        $this->verificarAdmin();
        
        $tipoReporte = $request->tipo;
        $formato = $request->formato; // excel o pdf
        $desde = $request->filled('desde') ? Carbon::parse($request->desde) : Carbon::now()->subDays(30);
        $hasta = $request->filled('hasta') ? Carbon::parse($request->hasta) : Carbon::now();
        
        // Aquí implementarías la exportación usando una librería como laravel-excel
        // Por ahora, solo redirigimos al dashboard con un mensaje
        
        return redirect()->route('admin.reportes.dashboard')
            ->with('info', 'La funcionalidad de exportación estará disponible próximamente.');
    }
}