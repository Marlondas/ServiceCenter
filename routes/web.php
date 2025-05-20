<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\LavadaController;
use App\Http\Controllers\ReporteController;

// Página principal - Mostrar el home en lugar de redireccionar
Route::get('/', function () {
    return view('home');
})->name('home');

// Rutas de autenticación
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para administrador
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        if (!Session::has('usuario') || Session::get('rol') !== 'admin') {
            return redirect('/login');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Rutas para empleado
Route::prefix('empleado')->group(function () {
    Route::get('/dashboard', function () {
        if (!Session::has('usuario') || Session::get('rol') !== 'empleado') {
            return redirect('/login');
        }
        return view('empleado.dashboard');
    })->name('empleado.dashboard');
});

// Rutas para cliente
Route::prefix('cliente')->group(function () {
    Route::get('/dashboard', function () {
        if (!Session::has('usuario') || Session::get('rol') !== 'cliente') {
            return redirect('/login');
        }
        return view('cliente.dashboard');
    })->name('cliente.dashboard');
});
// Rutas para Cliente - Vehículos
Route::prefix('cliente')->group(function () {
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('cliente.vehiculos.index');
    Route::get('/vehiculos/create', [VehiculoController::class, 'create'])->name('cliente.vehiculos.create');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('cliente.vehiculos.store');
    Route::get('/vehiculos/{id}/edit', [VehiculoController::class, 'edit'])->name('cliente.vehiculos.edit');
    Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('cliente.vehiculos.update');
    Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy'])->name('cliente.vehiculos.destroy');
});
// Rutas de administración de inventario
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/inventario', 'App\Http\Controllers\Admin\InventarioController@index')->name('inventario.index');
    Route::get('/inventario/crear', 'App\Http\Controllers\Admin\InventarioController@create')->name('inventario.create');
    Route::post('/inventario', 'App\Http\Controllers\Admin\InventarioController@store')->name('inventario.store');
    Route::get('/inventario/{id}/editar', 'App\Http\Controllers\Admin\InventarioController@edit')->name('inventario.edit');
    Route::put('/inventario/{id}', 'App\Http\Controllers\Admin\InventarioController@update')->name('inventario.update');
    Route::delete('/inventario/{id}', 'App\Http\Controllers\Admin\InventarioController@destroy')->name('inventario.destroy');
    
    // Rutas para movimientos de inventario
    Route::get('/inventario/movimiento/{id?}', 'App\Http\Controllers\Admin\InventarioController@movimientoForm')->name('inventario.movimientoForm');
    Route::post('/inventario/movimiento', 'App\Http\Controllers\Admin\InventarioController@registrarMovimiento')->name('inventario.registrarMovimiento');
    Route::get('/inventario/{id}/movimientos', 'App\Http\Controllers\Admin\InventarioController@verMovimientos')->name('inventario.verMovimientos');
});
// Rutas de gestión de empleados
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/empleados', 'App\Http\Controllers\Admin\EmpleadoController@index')->name('empleados.index');
    Route::get('/empleados/crear', 'App\Http\Controllers\Admin\EmpleadoController@create')->name('empleados.create');
    Route::post('/empleados', 'App\Http\Controllers\Admin\EmpleadoController@store')->name('empleados.store');
    Route::get('/empleados/{id}/editar', 'App\Http\Controllers\Admin\EmpleadoController@edit')->name('empleados.edit');
    Route::put('/empleados/{id}', 'App\Http\Controllers\Admin\EmpleadoController@update')->name('empleados.update');
    Route::delete('/empleados/{id}', 'App\Http\Controllers\Admin\EmpleadoController@destroy')->name('empleados.destroy');
});
// Importar el controlador TurnoController
use App\Http\Controllers\TurnoController;

// Rutas para Cliente - Turnos
Route::prefix('cliente')->group(function () {
    Route::get('/turnos', [TurnoController::class, 'clienteTurnos'])->name('cliente.turnos');
    Route::get('/turnos/solicitar', [TurnoController::class, 'solicitarForm'])->name('cliente.turnos.solicitar');
    Route::post('/turnos/solicitar', [TurnoController::class, 'solicitar'])->name('cliente.turnos.store');
    Route::put('/turnos/{id}/cancelar', [TurnoController::class, 'cancelar'])->name('cliente.turnos.cancelar');
});

// Rutas para Empleado - Turnos
Route::prefix('empleado')->group(function () {
    Route::get('/turnos', [TurnoController::class, 'empleadoTurnos'])->name('empleado.turnos');
    Route::put('/turnos/{id}/estado', [TurnoController::class, 'cambiarEstado'])->name('empleado.turnos.estado');
});

// Rutas para Admin - Turnos
Route::prefix('admin')->group(function () {
    Route::get('/turnos', [TurnoController::class, 'adminTurnos'])->name('admin.turnos');
    Route::get('/turnos/crear', [TurnoController::class, 'adminCreate'])->name('admin.turnos.create');
    Route::post('/turnos', [TurnoController::class, 'adminStore'])->name('admin.turnos.store');
    Route::get('/turnos/{id}/editar', [TurnoController::class, 'adminEdit'])->name('admin.turnos.edit');
    Route::put('/turnos/{id}', [TurnoController::class, 'adminUpdate'])->name('admin.turnos.update');
    Route::delete('/turnos/{id}', [TurnoController::class, 'adminDestroy'])->name('admin.turnos.destroy');
});
// Rutas para lavadas (empleado)
Route::get('/empleado/turnos/{turno}/registrar-lavado', [LavadaController::class, 'create'])->name('empleado.lavadas.create');
Route::post('/empleado/turnos/{turno}/registrar-lavado', [LavadaController::class, 'store'])->name('empleado.lavadas.store');
Route::get('/empleado/lavadas', [LavadaController::class, 'indexEmpleado'])->name('empleado.lavadas.index');
Route::get('/empleado/lavadas/{lavada}', [LavadaController::class, 'show'])->name('empleado.lavadas.show');

// Rutas para lavadas (cliente)
Route::get('/cliente/lavadas', [LavadaController::class, 'indexCliente'])->name('cliente.lavadas.index');
Route::get('/cliente/lavadas/{lavada}', [LavadaController::class, 'showCliente'])->name('cliente.lavadas.show');

// Rutas de administrador para lavadas
Route::get('/admin/lavadas', [LavadaController::class, 'adminIndex'])->name('admin.lavadas.index');
Route::get('/admin/lavadas/{lavada}', [LavadaController::class, 'adminShow'])->name('admin.lavadas.show');
// Rutas para calificar lavadas (cliente)
Route::get('/cliente/lavadas/{lavada}/calificar', [LavadaController::class, 'calificarForm'])->name('cliente.lavadas.calificar');
Route::post('/cliente/lavadas/{lavada}/calificar', [LavadaController::class, 'calificarStore'])->name('cliente.lavadas.calificar.store');

// Rutas para gestión de servicios (admin)
Route::get('/admin/servicios', [ServicioController::class, 'index'])->name('admin.servicios.index');
Route::get('/admin/servicios/create', [ServicioController::class, 'create'])->name('admin.servicios.create');
Route::post('/admin/servicios', [ServicioController::class, 'store'])->name('admin.servicios.store');
Route::get('/admin/servicios/{servicio}/edit', [ServicioController::class, 'edit'])->name('admin.servicios.edit');
Route::put('/admin/servicios/{servicio}', [ServicioController::class, 'update'])->name('admin.servicios.update');
Route::delete('/admin/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('admin.servicios.destroy');
Route::put('/admin/servicios/{servicio}/toggle', [ServicioController::class, 'toggleStatus'])->name('admin.servicios.toggle');
Route::get('/servicios-por-vehiculo/{id_vehiculo}', [TurnoController::class, 'getServiciosPorVehiculo'])->name('servicios-por-vehiculo');
// Importaciones
use App\Http\Controllers\BilleteraEmpleadoController;

// Rutas para el empleado - billetera
Route::get('/empleado/billetera', [BilleteraEmpleadoController::class, 'misBilletera'])
    ->name('empleado.billetera');

// Rutas para administrador - billetera
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/billetera', [BilleteraEmpleadoController::class, 'index'])
        ->name('billetera.index');
    Route::get('/billetera/{id_empleado}', [BilleteraEmpleadoController::class, 'show'])
        ->name('billetera.show');
    Route::get('/billetera/{id_empleado}/crear-pago', [BilleteraEmpleadoController::class, 'createPago'])
        ->name('billetera.create-pago');
    Route::post('/billetera/{id_empleado}/crear-pago', [BilleteraEmpleadoController::class, 'storePago'])
        ->name('billetera.store-pago');
});
// Rutas para reportes y estadísticas
Route::prefix('admin/reportes')->name('admin.reportes.')->group(function () {
    Route::get('/dashboard', [ReporteController::class, 'dashboard'])->name('dashboard');
    Route::get('/empleados', [ReporteController::class, 'empleados'])->name('empleados');
    Route::get('/clientes', [ReporteController::class, 'clientes'])->name('clientes');
    Route::get('/servicios', [ReporteController::class, 'servicios'])->name('servicios');
    Route::post('/exportar', [ReporteController::class, 'exportar'])->name('exportar');
});
Route::get('/cambiar-password', [AuthController::class, 'showCambiarPassword'])->name('cambiar.password');
Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword'])->name('cambiar.password.post');