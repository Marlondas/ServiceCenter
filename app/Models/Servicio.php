<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_servicio';
    protected $fillable = ['nombre', 'descripcion', 'precio', 'duracion_estimada', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación con turnos
    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_servicio');
    }
}