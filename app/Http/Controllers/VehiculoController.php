<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Cliente;
use App\Models\Marca;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    // Otros métodos...

    public function create()
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'cliente') {
            return redirect('/login');
        }

        $marcas = Marca::orderBy('nombre')->get();
        // Definir los tipos de vehículo disponibles
        $tipos_vehiculo = ['carro', 'moto'];
        
        return view('cliente.vehiculos.create', compact('marcas', 'tipos_vehiculo'));
    }

    public function store(Request $request)
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'cliente') {
            return redirect('/login');
        }

        $request->validate([
            'placa' => [
                'required',
                'string',
                'max:10',
                'unique:vehiculos',
                'regex:/^[A-Za-z0-9]+$/' // Solo letras y números
            ],
            'marca' => 'required',
            'nueva_marca' => 'required_if:marca,nueva',
            'modelo' => 'required|numeric', // Solo números
            'color' => 'required|string|max:30',
            'tipo_vehiculo' => 'required|in:carro,moto', // Validación para tipo_vehiculo
        ], [
            'placa.required' => 'La placa es obligatoria',
            'placa.unique' => 'Esta placa ya está registrada',
            'placa.regex' => 'La placa solo puede contener letras y números',
            'marca.required' => 'La marca es obligatoria',
            'nueva_marca.required_if' => 'Debe ingresar el nombre de la nueva marca',
            'modelo.required' => 'El modelo es obligatorio',
            'modelo.numeric' => 'El modelo debe contener solo números',
            'color.required' => 'El color es obligatorio',
            'tipo_vehiculo.required' => 'El tipo de vehículo es obligatorio',
            'tipo_vehiculo.in' => 'El tipo de vehículo debe ser carro o moto',
        ]);

        try {
            $idUsuario = Session::get('id_usuario');
            $cliente = Cliente::where('id_usuario', $idUsuario)->first();
            
            if (!$cliente) {
                return back()->withInput()->withErrors(['error' => 'No se encontró información de cliente.']);
            }

            // Determinar la marca
            $idMarca = null;
            if ($request->marca === 'nueva' && $request->has('nueva_marca')) {
                // Crear nueva marca
                $marca = Marca::firstOrCreate(
                    ['nombre' => trim($request->nueva_marca)]
                );
                $idMarca = $marca->id_marca;
            } else {
                $idMarca = $request->marca;
            }

            Vehiculo::create([
                'placa' => strtoupper(trim($request->placa)),
                'id_marca' => $idMarca,
                'modelo' => trim($request->modelo),
                'color' => trim($request->color),
                'id_cliente' => $cliente->id_cliente,
                'tipo_vehiculo' => $request->tipo_vehiculo, // Guardar el tipo de vehículo
            ]);

            return redirect()->route('cliente.vehiculos.index')
                ->with('success', 'Vehículo registrado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ha ocurrido un error al registrar el vehículo: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'cliente') {
            return redirect('/login');
        }

        $idUsuario = Session::get('id_usuario');
        $cliente = Cliente::where('id_usuario', $idUsuario)->first();
        
        if (!$cliente) {
            return redirect()->route('cliente.dashboard')
                ->withErrors(['error' => 'No se encontró información de cliente.']);
        }

        $vehiculo = Vehiculo::where('id_vehiculo', $id)
                          ->where('id_cliente', $cliente->id_cliente)
                          ->first();
        
        if (!$vehiculo) {
            return redirect()->route('cliente.vehiculos.index')
                ->withErrors(['error' => 'No se encontró el vehículo o no tienes permiso para editarlo.']);
        }

        $marcas = Marca::orderBy('nombre')->get();
        // Definir los tipos de vehículo disponibles
        $tipos_vehiculo = ['carro', 'moto'];
        
        return view('cliente.vehiculos.edit', compact('vehiculo', 'marcas', 'tipos_vehiculo'));
    }

    public function update(Request $request, $id)
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'cliente') {
            return redirect('/login');
        }

        $request->validate([
            'marca' => 'required',
            'nueva_marca' => 'required_if:marca,nueva',
            'modelo' => 'required|numeric', // Solo números
            'color' => 'required|string|max:30',
            'tipo_vehiculo' => 'required|in:carro,moto', // Validación para tipo_vehiculo
        ], [
            'marca.required' => 'La marca es obligatoria',
            'nueva_marca.required_if' => 'Debe ingresar el nombre de la nueva marca',
            'modelo.required' => 'El modelo es obligatorio',
            'modelo.numeric' => 'El modelo debe contener solo números',
            'color.required' => 'El color es obligatorio',
            'tipo_vehiculo.required' => 'El tipo de vehículo es obligatorio',
            'tipo_vehiculo.in' => 'El tipo de vehículo debe ser carro o moto',
        ]);

        try {
            $idUsuario = Session::get('id_usuario');
            $cliente = Cliente::where('id_usuario', $idUsuario)->first();
            
            if (!$cliente) {
                return back()->withInput()->withErrors(['error' => 'No se encontró información de cliente.']);
            }

            $vehiculo = Vehiculo::where('id_vehiculo', $id)
                              ->where('id_cliente', $cliente->id_cliente)
                              ->first();
            
            if (!$vehiculo) {
                return redirect()->route('cliente.vehiculos.index')
                    ->withErrors(['error' => 'No se encontró el vehículo o no tienes permiso para editarlo.']);
            }

            // Determinar la marca
            $idMarca = null;
            if ($request->marca === 'nueva' && $request->has('nueva_marca')) {
                // Crear nueva marca
                $marca = Marca::firstOrCreate(
                    ['nombre' => trim($request->nueva_marca)]
                );
                $idMarca = $marca->id_marca;
            } else {
                $idMarca = $request->marca;
            }

            $vehiculo->update([
                'id_marca' => $idMarca,
                'modelo' => trim($request->modelo),
                'color' => trim($request->color),
                'tipo_vehiculo' => $request->tipo_vehiculo, // Actualizar el tipo de vehículo
            ]);

            return redirect()->route('cliente.vehiculos.index')
                ->with('success', 'Vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ha ocurrido un error al actualizar el vehículo: ' . $e->getMessage()]);
        }
    }

    // Método index permanece igual
    public function index()
    {
        if (!Session::has('usuario') || Session::get('rol') !== 'cliente') {
            return redirect('/login');
        }

        $idUsuario = Session::get('id_usuario');
        $cliente = Cliente::where('id_usuario', $idUsuario)->first();
        
        if (!$cliente) {
            return redirect()->route('cliente.dashboard')
                ->withErrors(['error' => 'No se encontró información de cliente.']);
        }

        $vehiculos = Vehiculo::with('marca')->where('id_cliente', $cliente->id_cliente)->get();
        return view('cliente.vehiculos.index', compact('vehiculos'));
    }
}       