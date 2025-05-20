<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_movimiento';
    protected $fillable = ['tipo', 'fecha', 'descripcion', 'id_producto', 'cantidad'];

    public function producto()
    {
        return $this->belongsTo(Inventario::class, 'id_producto');
    }
}