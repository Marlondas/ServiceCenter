<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|string|email|max:100|unique:usuarios',
            'contraseña' => 'required|string|min:6|confirmed',
            'telefono' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]+$/' // Solo números
            ],
            'direccion' => 'required|string|max:200',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'Debe ingresar un correo electrónico válido',
            'correo.unique' => 'Este correo ya está registrado',
            'contraseña.required' => 'La contraseña es obligatoria',
            'contraseña.min' => 'La contraseña debe tener al menos 6 caracteres',
            'contraseña.confirmed' => 'Las contraseñas no coinciden',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.regex' => 'El teléfono debe contener solo números',
            'direccion.required' => 'La dirección es obligatoria',
        ]);

        try {
            // Crear usuario
            $usuario = Usuario::create([
                'nombre' => trim($request->nombre),
                'correo' => strtolower(trim($request->correo)),
                'contraseña' => Hash::make($request->contraseña),
                'rol' => 'cliente', // Por defecto, los registros son clientes
            ]);

            // Crear cliente
            Cliente::create([
                'telefono' => trim($request->telefono),
                'direccion' => trim($request->direccion),
                'id_usuario' => $usuario->id_usuario,
            ]);

            return redirect()->route('login.form')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ha ocurrido un error al registrar el usuario. Inténtalo de nuevo.']);
        }
    }

    // Resto del código sin cambios...
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'correo' => 'required|string|email',
        'contraseña' => 'required|string',
    ], [
        'correo.required' => 'El correo electrónico es obligatorio',
        'correo.email' => 'Debe ingresar un correo electrónico válido',
        'contraseña.required' => 'La contraseña es obligatoria',
    ]);

    try {
        $usuario = Usuario::where('correo', strtolower(trim($request->correo)))->first();

        if (!$usuario || !Hash::check($request->contraseña, $usuario->contraseña)) {
            return back()->withErrors(['correo' => 'Las credenciales no coinciden con nuestros registros.']);
        }

        // Guardar usuario en sesión
        Session::put('usuario', $usuario);
        Session::put('id_usuario', $usuario->id_usuario);
        Session::put('rol', $usuario->rol);

        // Verificar si debe cambiar contraseña
        if ($usuario->cambiar_password) {
            return redirect()->route('cambiar.password');
        }

        // Redireccionar según el rol
        switch ($usuario->rol) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'empleado':
                return redirect()->route('empleado.dashboard');
            case 'cliente':
                return redirect()->route('cliente.dashboard');
            default:
                return redirect('/');
        }
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Ha ocurrido un error al iniciar sesión. Inténtalo de nuevo.']);
    }
}

    public function logout()
    {
        try {
            Session::flush();
            return redirect()->route('login.form')->with('success', 'Sesión cerrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('login.form');
        }
    }
    public function showCambiarPassword()
{
    // Verificar que haya un usuario en sesión
    if (!Session::has('usuario')) {
        return redirect()->route('login.form');
    }
    
    return view('auth.cambiar_password');
}

public function cambiarPassword(Request $request)
{
    // Verificar que haya un usuario en sesión
    if (!Session::has('usuario')) {
        return redirect()->route('login.form');
    }
    
    $request->validate([
        'nueva_contraseña' => 'required|string|min:6|confirmed',
    ], [
        'nueva_contraseña.required' => 'La nueva contraseña es obligatoria',
        'nueva_contraseña.min' => 'La nueva contraseña debe tener al menos 6 caracteres',
        'nueva_contraseña.confirmed' => 'Las contraseñas no coinciden',
    ]);
    
    try {
        $id_usuario = Session::get('id_usuario');
        $usuario = Usuario::findOrFail($id_usuario);
        
        $usuario->contraseña = Hash::make($request->nueva_contraseña);
        $usuario->cambiar_password = false; // Ya no necesita cambiar la contraseña
        $usuario->save();
        
        // Actualizar el usuario en la sesión
        Session::put('usuario', $usuario);
        
        // Redireccionar según el rol
        switch ($usuario->rol) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Contraseña actualizada correctamente');
            case 'empleado':
                return redirect()->route('empleado.dashboard')->with('success', 'Contraseña actualizada correctamente');
            case 'cliente':
                return redirect()->route('cliente.dashboard')->with('success', 'Contraseña actualizada correctamente');
            default:
                return redirect('/')->with('success', 'Contraseña actualizada correctamente');
        }
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Ha ocurrido un error al cambiar la contraseña. Inténtalo de nuevo.']);
    }
}
}