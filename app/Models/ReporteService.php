<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteService
{
    // Obtener datos para el dashboard
    public static function getDashboardData($desde = null, $hasta = null)
    {
        // Si no se proporcionan fechas, usar el último mes
        $hasta = $hasta ?? now();
        $desde = $desde ?? now()->subDays(30);
        
        $data = [
            'total_ingresos' => self::calcularIngresosPeriodo($desde, $hasta),
            'total_servicios' => self::contarServiciosPeriodo($desde, $hasta),
            'promedio_calificacion' => self::promedioCalificaciones($desde, $hasta),
            'servicios_populares' => self::serviciosPopulares($desde, $hasta, 5),
            'ingresos_por_dia' => self::ingresosPorDia($desde, $hasta),
            'servicios_por_tipo_vehiculo' => self::serviciosPorTipoVehiculo($desde, $hasta),
        ];
        
        return $data;
    }
    
    // Calcular ingresos totales en un período
    public static function calcularIngresosPeriodo($desde, $hasta)
    {
        return Lavada::whereBetween('fecha', [$desde, $hasta])
            ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->sum('servicios.precio');
    }
    
    // Contar servicios en un período
    public static function contarServiciosPeriodo($desde, $hasta)
    {
        return Lavada::whereBetween('fecha', [$desde, $hasta])->count();
    }
    
    // Calcular promedio de calificaciones
    public static function promedioCalificaciones($desde, $hasta)
    {
        return Lavada::whereBetween('fecha', [$desde, $hasta])
            ->whereNotNull('calificacion')
            ->avg('calificacion') ?? 0;
    }
    
    // Obtener servicios más populares
    public static function serviciosPopulares($desde, $hasta, $limit = 5)
    {
        return DB::table('lavadas')
            ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->whereBetween('lavadas.fecha', [$desde, $hasta])
            ->select('servicios.nombre', DB::raw('count(*) as total'))
            ->groupBy('servicios.nombre')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();
    }
    
    // Obtener ingresos por día
    public static function ingresosPorDia($desde, $hasta)
    {
        return DB::table('lavadas')
            ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->whereBetween('lavadas.fecha', [$desde, $hasta])
            ->select('lavadas.fecha', DB::raw('SUM(servicios.precio) as ingreso'))
            ->groupBy('lavadas.fecha')
            ->orderBy('lavadas.fecha')
            ->get();
    }
    
    // Obtener servicios por tipo de vehículo
    public static function serviciosPorTipoVehiculo($desde, $hasta)
    {
        return DB::table('lavadas')
            ->join('vehiculos', 'lavadas.id_vehiculo', '=', 'vehiculos.id_vehiculo')
            ->whereBetween('lavadas.fecha', [$desde, $hasta])
            ->select('vehiculos.tipo_vehiculo', DB::raw('count(*) as total'))
            ->groupBy('vehiculos.tipo_vehiculo')
            ->get();
    }
    
    // Generar reporte de empleados
    public static function reporteEmpleados($desde, $hasta)
    {
        $empleados = Empleado::with('usuario')
            ->withCount(['lavadas as total_servicios' => function($query) use ($desde, $hasta) {
                $query->whereBetween('fecha', [$desde, $hasta]);
            }])
            ->get();
            
        foreach ($empleados as $empleado) {
            // Calcular comisiones generadas en el período
            $empleado->comisiones_generadas = BilleteraEmpleado::where('id_empleado', $empleado->id_empleado)
                ->where('tipo', 'comision')
                ->whereBetween('fecha', [$desde, $hasta])
                ->sum('monto_comision');
                
            // Calcular pagos realizados en el período
            $empleado->pagos_realizados = BilleteraEmpleado::where('id_empleado', $empleado->id_empleado)
                ->where('tipo', 'pago')
                ->whereBetween('fecha', [$desde, $hasta])
                ->sum('monto_comision');
                
            // Calcular calificación promedio
            $empleado->calificacion_promedio = Lavada::where('id_empleado', $empleado->id_empleado)
                ->whereBetween('fecha', [$desde, $hasta])
                ->whereNotNull('calificacion')
                ->avg('calificacion') ?? 0;
        }
        
        return $empleados;
    }
    
    // Generar reporte de clientes
    public static function reporteClientes($desde, $hasta, $limit = 10)
    {
        // Obtener clientes con más lavados
        $clientes_frecuentes = DB::table('lavadas')
            ->join('vehiculos', 'lavadas.id_vehiculo', '=', 'vehiculos.id_vehiculo')
            ->join('clientes', 'vehiculos.id_cliente', '=', 'clientes.id_cliente')
            ->join('usuarios', 'clientes.id_usuario', '=', 'usuarios.id_usuario')
            ->whereBetween('lavadas.fecha', [$desde, $hasta])
            ->select('clientes.id_cliente', 'usuarios.nombre', DB::raw('count(*) as total_visitas'))
            ->groupBy('clientes.id_cliente', 'usuarios.nombre')
            ->orderBy('total_visitas', 'desc')
            ->limit($limit)
            ->get();
            
        // Añadir más métricas a cada cliente
        foreach ($clientes_frecuentes as $cliente) {
            // Calificación promedio dada por este cliente
            $cliente->calificacion_promedio = DB::table('lavadas')
                ->join('vehiculos', 'lavadas.id_vehiculo', '=', 'vehiculos.id_vehiculo')
                ->where('vehiculos.id_cliente', $cliente->id_cliente)
                ->whereBetween('lavadas.fecha', [$desde, $hasta])
                ->whereNotNull('lavadas.calificacion')
                ->avg('lavadas.calificacion') ?? 0;
                
            // Total gastado por este cliente
            $cliente->total_gastado = DB::table('lavadas')
                ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
                ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
                ->join('vehiculos', 'lavadas.id_vehiculo', '=', 'vehiculos.id_vehiculo')
                ->where('vehiculos.id_cliente', $cliente->id_cliente)
                ->whereBetween('lavadas.fecha', [$desde, $hasta])
                ->sum('servicios.precio');
        }
        
        return $clientes_frecuentes;
    }
}