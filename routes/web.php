<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatosController;

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

// Las siguientes rutas retornan a la vista inicio
Route::get('/', function () { return view('inicio'); })->name('inicio');
Route::get('/inicio', function () { return view('inicio'); });
// La siguiente ruta retorna a la vista datos
Route::get('/datos', function () { return view('datos'); });
// La siguiente ruta retorna la vista CRUD de los indicadores
Route::resource('crud', DatosController::class);
// La siguiente ruta genera un token de acceso con mis credenciales
Route::get('token', [DatosController::class, 'tokn']);
// La siguiente ruta carga los datos obtenidos a la base de datos
Route::get('/cargardatos', [DatosController::class, 'cargar']);
// La siguiente ruta retorna a la vista grafico
Route::get('grafico', [DatosController::class, 'mostrarGrafico'])->name('grafico');;
