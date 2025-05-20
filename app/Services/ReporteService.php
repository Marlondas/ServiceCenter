<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteService
{
    /**
     * Obtiene datos para el dashboard
     */
    public static function getDashboardData($desde, $hasta)
    {
        // Asumiendo que la columna fecha está en la tabla lavadas
        
        $ingresos = DB::table('lavadas')
            ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->sum('servicios.precio');
            
        $totalServicios = DB::table('lavadas')
            ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->count();
            
        // Reemplazamos 'fecha_registro' por el nombre correcto de la columna
        // Asumiendo que la columna se llama 'created_at' (estándar en Laravel)
        $clientesNuevos = DB::table('clientes')
            ->where('created_at', '>=', $desde)
            ->where('created_at', '<=', $hasta)
            ->count();
            
        $serviciosPorDia = DB::table('lavadas')
            ->join('turnos', 'lavadas.id_turno', '=', 'turnos.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->select(
                DB::raw('DATE(lavadas.fecha) as dia'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(servicios.precio) as ingresos')
            )
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
            
        // Obtenemos los servicios populares
        $serviciosPopulares = self::serviciosPopulares($desde, $hasta, 5);
        
        // Obtenemos los servicios por tipo de vehículo
        $serviciosPorTipoVehiculo = self::serviciosPorTipoVehiculo($desde, $hasta);
        
        // Calculamos o asignamos un valor para el promedio de calificación
        // Esto es temporal, idealmente deberías calcularlo desde la base de datos
        $promedioCalificacion = DB::table('lavadas')
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->avg('calificacion') ?? 0; // Asumiendo que existe una columna 'calificacion'
            
        return [
            'ingresos' => $ingresos,
            'totalServicios' => $totalServicios,
            'clientesNuevos' => $clientesNuevos,
            'serviciosPorDia' => $serviciosPorDia,
            'promedio_calificacion' => $promedioCalificacion,
            'servicios_populares' => $serviciosPopulares,
            'servicios_por_tipo_vehiculo' => $serviciosPorTipoVehiculo
        ];
    }
    
    /**
     * Reporte de empleados
     * Modificado para unir con la tabla usuarios
     */
    public static function reporteEmpleados($desde, $hasta)
    {
        return DB::table('empleados')
            ->join('usuarios', 'empleados.id_usuario', '=', 'usuarios.id_usuario')
            ->join('turnos', 'empleados.id_empleado', '=', 'turnos.id_empleado')
            ->join('lavadas', 'turnos.id_turno', '=', 'lavadas.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->select(
                'empleados.id_empleado',
                'usuarios.nombre',
                DB::raw('COUNT(lavadas.id_lavada) as total_servicios'),
                DB::raw('SUM(servicios.precio) as total_ventas')
            )
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->groupBy('empleados.id_empleado', 'usuarios.nombre')
            ->orderBy('total_ventas', 'desc')
            ->get();
    }
    
    /**
     * Reporte de clientes
     * Modificado para unir con la tabla usuarios
     */
    public static function reporteClientes($desde, $hasta)
    {
        return DB::table('clientes')
            ->join('usuarios', 'clientes.id_usuario', '=', 'usuarios.id_usuario')
            ->join('vehiculos', 'clientes.id_cliente', '=', 'vehiculos.id_cliente')
            ->join('turnos', 'vehiculos.id_vehiculo', '=', 'turnos.id_vehiculo')
            ->join('lavadas', 'turnos.id_turno', '=', 'lavadas.id_turno')
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id_servicio')
            ->select(
                'clientes.id_cliente',
                'usuarios.nombre',
                'usuarios.correo as email',
                'clientes.telefono',
                DB::raw('COUNT(lavadas.id_lavada) as visitas'),
                DB::raw('SUM(servicios.precio) as total_gastado')
            )
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->groupBy('clientes.id_cliente', 'usuarios.nombre', 'usuarios.correo', 'clientes.telefono')
            ->orderBy('total_gastado', 'desc')
            ->get();
    }
    
    /**
     * Servicios más populares
     */
    public static function serviciosPopulares($desde, $hasta, $limit = 10)
    {
        return DB::table('servicios')
            ->join('turnos', 'servicios.id_servicio', '=', 'turnos.id_servicio')
            ->join('lavadas', 'turnos.id_turno', '=', 'lavadas.id_turno')
            ->select(
                'servicios.id_servicio',
                'servicios.nombre',
                'servicios.precio',
                DB::raw('COUNT(lavadas.id_lavada) as total')
            )
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->groupBy('servicios.id_servicio', 'servicios.nombre', 'servicios.precio')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Servicios por tipo de vehículo
     */
    public static function serviciosPorTipoVehiculo($desde, $hasta)
    {
        return DB::table('vehiculos')
            ->join('turnos', 'vehiculos.id_vehiculo', '=', 'turnos.id_vehiculo')
            ->join('lavadas', 'turnos.id_turno', '=', 'lavadas.id_turno')
            ->select(
                'vehiculos.tipo_vehiculo as tipo',
                DB::raw('COUNT(lavadas.id_lavada) as total')
            )
            ->where('lavadas.fecha', '>=', $desde)
            ->where('lavadas.fecha', '<=', $hasta)
            ->groupBy('vehiculos.tipo_vehiculo')
            ->orderBy('total', 'desc')
            ->get();
    }
}