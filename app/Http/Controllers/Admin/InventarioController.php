<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Inventario::all();
        
        return view('admin.inventario.index', compact('productos'));
    }
    
    public function create()
    {
        return view('admin.inventario.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:1',
        ]);
        
        DB::beginTransaction();
        try {
            $producto = Inventario::create($request->all());
            
            // Registrar movimiento de entrada inicial
            if ($producto->cantidad > 0) {
                MovimientoInventario::create([
                    'tipo' => 'entrada',
                    'fecha' => now(),
                    'descripcion' => 'Stock inicial',
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $producto->cantidad
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin.inventario.index')
                ->with('success', 'Producto agregado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar el producto: ' . $e->getMessage())->withInput();
        }
    }
    
    public function edit($id)
    {
        $producto = Inventario::findOrFail($id);
        return view('admin.inventario.edit', compact('producto'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:1',
        ]);
        
        DB::beginTransaction();
        try {
            $producto = Inventario::findOrFail($id);
            $cantidadAnterior = $producto->cantidad;
            
            $producto->update($request->all());
            
            // Registrar movimiento si la cantidad cambió
            $diferencia = $producto->cantidad - $cantidadAnterior;
            if ($diferencia != 0) {
                MovimientoInventario::create([
                    'tipo' => $diferencia > 0 ? 'entrada' : 'salida',
                    'fecha' => now(),
                    'descripcion' => 'Ajuste manual de inventario',
                    'id_producto' => $producto->id_producto,
                    'cantidad' => abs($diferencia)
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin.inventario.index')
                ->with('success', 'Producto actualizado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $producto = Inventario::findOrFail($id);
            $producto->delete();
            
            return redirect()->route('admin.inventario.index')
                ->with('success', 'Producto eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
    
   public function movimientoForm($id = null)
    {
        $productos = Inventario::all();
        $productoSeleccionado = null;
    
         if ($id) {
        $productoSeleccionado = Inventario::findOrFail($id);
        }
    
         return view('admin.inventario.movimiento', compact('productos', 'productoSeleccionado'));
    }
    
    public function registrarMovimiento(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:inventarios,id_producto',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'descripcion' => 'required|string|max:255',
        ]);
        
        DB::beginTransaction();
        try {
            $producto = Inventario::findOrFail($request->id_producto);
            
            // Validar stock suficiente para salida
            if ($request->tipo == 'salida' && $producto->cantidad < $request->cantidad) {
                return back()->with('error', 'No hay suficiente stock para realizar esta salida')->withInput();
            }
            
            // Crear el movimiento
            MovimientoInventario::create([
                'tipo' => $request->tipo,
                'fecha' => now(),
                'descripcion' => $request->descripcion,
                'id_producto' => $producto->id_producto,
                'cantidad' => $request->cantidad
            ]);
            
            // Actualizar cantidad en inventario
            if ($request->tipo == 'entrada') {
                $producto->cantidad += $request->cantidad;
            } else {
                $producto->cantidad -= $request->cantidad;
            }
            
            $producto->save();
            
            DB::commit();
            return redirect()->route('admin.inventario.index')
                ->with('success', 'Movimiento registrado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar el movimiento: ' . $e->getMessage())->withInput();
        }
    }
    
    public function verMovimientos($id)
    {
        $producto = Inventario::with('movimientos')->findOrFail($id);
        return view('admin.inventario.ver-movimientos', compact('producto'));
    }
}