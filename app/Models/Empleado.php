<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_empleado';
    protected $fillable = ['cargo', 'comision', 'id_usuario'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function lavadas()
    {
        return $this->hasMany(Lavada::class, 'id_empleado');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_empleado');
    }

    public function billeteraEmpleado()
    {
        return $this->hasMany(BilleteraEmpleado::class, 'id_empleado');
    }

    public function billetera()
    {
        return $this->hasMany(BilleteraEmpleado::class, 'id_empleado');
    }

// Método para calcular saldo actual
    public function saldoActual()
    {
        return BilleteraEmpleado::saldoActual($this->id_empleado);
    }
}