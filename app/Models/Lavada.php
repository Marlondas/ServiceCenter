<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lavada extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_lavada';
    protected $fillable = [
    'fecha', 'hora', 'id_vehiculo', 'id_empleado', 
    'foto_antes', 'foto_despues', 'calificacion', 'comentario', 'comentario_cliente', 'id_turno'
];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function billeteraEmpleado()
    {
        return $this->hasOne(BilleteraEmpleado::class, 'id_lavada');
    }
    public function turno()    
    {
        return $this->belongsTo(Turno::class, 'id_turno');
    }
    
}