<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_usuario';
    protected $fillable = ['nombre', 'correo', 'contraseña', 'rol','cambiar_password'];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_usuario');
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'id_usuario');
    }
}