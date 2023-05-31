<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculosIngresadosController;
use App\Http\Controllers\TarifasController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\VehiculosNoPagadosController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpresoraController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\FacturaController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified', 'soloadmin'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware([
    'auth:sanctum', 
    config('jetstream.auth_session'),
    'verified', 'solouser'
    ])->get('/user', function () { 
        return view('User'); 
    })->name('user');


Route::middleware([
       'auth:sanctum',
       config('jetstream.auth_session'),
      'verified',
       'soloadmin'
])->group(function () {
    //Servicios administracion
    Route::resource('servicios', ServiciosController::class);
    //Empresas administracion 
    Route::resource('empresas', EmpresasController::class);
    //Tarifas administracion 
    Route::resource('tarifas', TarifasController::class);
    //Facturas administracion
    Route::resource('facturas', FacturaController::class);
    //Establecer rol de administracion
    Route::resource('admin', AdministracionController::class);

});

//config publico
Route::get('/configuraciones', [ConfiguracionController::class, 'index'])->name('configuraciones.index');

//tarifas user
Route::resource('tarifas', TarifasController::class)->only(['index']);

//Empresa user
Route::resource('empresas', EmpresasController::class)->only(['index']);

//Servicios user
Route::resource('servicios', ServiciosController::class)->only(['index']);
    
//resoluciones user
Route::resource('facturas', FacturaController::class)->only(['index']);
Route::put('facturas/{id}/activar', [FacturaController::class, 'activarFactura'])->name('facturas.activar');

//impresoras user y admin
Route::resource('impresoras', ImpresoraController::class);
Route::put('impresoras/{id}/activar', [ImpresoraController::class, 'activarImpresora'])->name('impresoras.activar');

//Ingresos user y admin
Route::get('/ingresos', [VehiculosIngresadosController::class, 'index'])->name('vehiculos_ingresados.ingresos');
Route::post('/ingresos', [VehiculosIngresadosController::class, 'store'])->name('vehiculos_ingresados.store');
Route::get('/ingresos/create', [VehiculosIngresadosController::class, 'create'])->name('vehiculos_ingresados.create');
Route::match(['get', 'post'], '/vehiculos_ingresados/imprimir/{id}', [VehiculosIngresadosController::class, 'imprimirPDF'])->name('vehiculos_ingresados.imprimir');
Route::get('/vehiculos_ingresados/filtroPlaca', [VehiculosIngresadosController::class, 'filtroPlaca'])->name('vehiculos_ingresados.filtroPlaca');

//no_pagados y funciones de user y admin
Route::get('/vehiculos_no_pagados', [VehiculosNoPagadosController::class, 'index'])->name('vehiculos_no_pagados.index');
Route::get('/vehiculos_no_pagados/filtroPlacaNoPagado', [VehiculosNoPagadosController::class, 'filtroPlacaNoPagado'])->name('vehiculos_no_pagados.filtroPlacaNoPagado');
Route::get('/vehiculos_no_pagados/{id}', [VehiculosNoPagadosController::class, 'show'])->name('vehiculos_no_pagados.show');

//pagar user y admin
Route::get('/pagos/recibo/{placa}', [PagoController::class, 'pagar'])->name('pagos.recibo');
Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
//formulario de pago user y admin
Route::get('/pagos/create', [PagoController::class, 'create'])->name('pagos.create');
Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');
Route::get('/pagos/{id}', [PagoController::class, 'show'])->name('pagos.show');
// Route::resource('pagos', PagoController::class);
