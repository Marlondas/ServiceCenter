<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_turno';
    protected $fillable = ['fecha', 'hora', 'estado', 'id_vehiculo', 'id_empleado', 'tipo_servicio', 'comentarios'];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function lavada()
    {
        return $this->hasOne(Lavada::class, 'id_turno');
    }
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }
}