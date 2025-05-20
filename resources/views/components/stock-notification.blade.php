@if(count($productosAlerta) > 0)
    <div style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        <h4 style="margin-top: 0;">¡Alerta de Stock!</h4>
        <ul style="margin-bottom: 0; padding-left: 20px;">
            @foreach($productosAlerta as $producto)
                <li>
                    {{ $producto->nombre }} - Cantidad: {{ $producto->cantidad }} 
                    (Mínimo requerido: {{ $producto->stock_minimo }})
                    @if($producto->sinStock())
                        <strong style="color: #dc3545;">[CRÍTICO]</strong>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif