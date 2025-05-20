<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_vehiculo';
    protected $fillable = ['placa', 'id_marca', 'modelo', 'color', 'id_cliente', 'tipo_vehiculo'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }
    
    // Método para verificar si es carro
    public function esCarro()
    {
        return $this->tipo_vehiculo === 'carro';
    }
    
    // Método para verificar si es moto
    public function esMoto()
    {
        return $this->tipo_vehiculo === 'moto';
    }
}