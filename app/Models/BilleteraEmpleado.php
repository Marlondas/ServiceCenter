<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BilleteraEmpleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_billetera';
    protected $fillable = [
        'id_empleado', 
        'id_lavada', 
        'monto_comision', 
        'fecha',
        'tipo',
        'concepto'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function lavada()
    {
        return $this->belongsTo(Lavada::class, 'id_lavada');
    }
    
    // Comisiones acumuladas por empleado
    public static function comisionesAcumuladas($id_empleado)
    {
        return self::where('id_empleado', $id_empleado)
            ->where('tipo', 'comision')
            ->sum('monto_comision');
    }
    
    // Pagos acumulados por empleado
    public static function pagosAcumulados($id_empleado)
    {
        return self::where('id_empleado', $id_empleado)
            ->where('tipo', 'pago')
            ->sum('monto_comision');
    }
    
    // Saldo actual
    public static function saldoActual($id_empleado)
    {
        $comisiones = self::comisionesAcumuladas($id_empleado);
        $pagos = self::pagosAcumulados($id_empleado);
        
        return $comisiones - $pagos;
    }
}