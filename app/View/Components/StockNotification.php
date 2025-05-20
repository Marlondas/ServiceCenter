<?php

namespace App\View\Components;

use App\Models\Inventario;
use Illuminate\View\Component;

class StockNotification extends Component
{
    public $productosAlerta;
    
    public function __construct()
    {
        // Obtener los productos con stock bajo
        $this->productosAlerta = Inventario::whereRaw('cantidad <= stock_minimo')->get();
    }

    public function render()
    {
        return view('components.stock-notification');
    }
}