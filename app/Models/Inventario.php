<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';
    protected $primaryKey = 'id_producto';
    protected $fillable = ['nombre', 'cantidad', 'stock_minimo'];

    // Método para verificar si el producto tiene stock bajo
    public function tieneStockBajo()
    {
        return $this->cantidad <= $this->stock_minimo;
    }

    // Método para verificar si el producto está sin stock
    public function sinStock()
    {
        return $this->cantidad <= 0;
    }

    // Relación con MovimientoInventario
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_producto');
    }
}