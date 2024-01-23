<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EsdevenimentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\passwordController;
use App\Http\Controllers\PasswordController as ControllersPasswordController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CrearEsdevenimentController;
use App\Http\Controllers\AdministrarEsdevenimentsController;
use App\Http\Controllers\EditarEsdevenimentController;
use App\Http\Controllers\LlistatSessionsController;
use App\Http\Controllers\AdministrarEsdevenimentController;
use App\Http\Controllers\DetallsEsdevenimentController;
use App\Http\Controllers\LlistatsEntradesController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cerca', [HomeController::class, 'cerca'])->name('cerca');

Route::get('/resultados', [HomeController::class, 'cerca'])->name('resultados');

Route::get('/esdeveniment/{id}', [EsdevenimentController::class, 'show'])->name('mostrar-esdeveniment');

Route::get('/editarEsdeveniment/{id}', [EditarEsdevenimentController::class, 'editar'])->name('editar-esdeveniment');

Route::post('/login',[LoginController::class,'login'])->name(('login'));
Route::get('/login',[LoginController::class,'login'])->name(('login'));

Route::get('/taullerAdministracio',[LoginController::class,'login'])->name('taullerAdministracio');

Route::post('/homePromotor', [LoginController::class,'iniciarSesion'])->name('homePromotor');
Route::get('/homePromotor', [LoginController::class, 'iniciarSesion'])->name('homePromotor');

Route::post('/perfil', [LoginController::class,'iniciarSesion'])->name('perfil');

Route::get('/session', [SessionController::class, 'SessionController'])->name('session');
Route::post('/session', [SessionController::class, 'SessionController'])->name('session');

Route::get('/crear-esdeveniment', [CrearEsdevenimentController::class, 'index'])->name('crear-esdeveniment');
Route::post('/crear-esdeveniment.store', [CrearEsdevenimentController::class, 'store'])->name('crear-esdeveniment.store');

Route::get('/administrar-esdeveniments', [AdministrarEsdevenimentsController::class, 'index'])->name('administrar-esdeveniments');
Route::post('/administrar-esdeveniments', [AdministrarEsdevenimentsController::class, 'index'])->name('administrar-esdeveniments');

Route::get('/recuperar',[PasswordController::class,'passwordPage'])->name('recuperar');
Route::post('/recuperar',[PasswordController::class,'passwordPage'])->name('recuperar');

Route::get('/recuperar-form',[PasswordController::class,'enviarCorreo'])->name('recuperar-form');
Route::post('/recuperar-form',[PasswordController::class,'enviarCorreo'])->name('recuperar-form');

Route::get('/cambiarPassword',[passwordController::class, 'pagePassword'])->name('cambiarPassword');
Route::post('/cambiarPassword',[passwordController::class, 'pagePassword'])->name('cambiarPassword');


Route::get('/peticionCambiar',[passwordController::class, 'cambiarPassword'])->name('peticionCambiar');
Route::post('/peticionCambiar',[passwordController::class, 'cambiarPassword'])->name('peticionCambiar');

Route::post('/confirmacio',[EsdevenimentController::class, 'compra'])->name('confirmacioCompra');

Route::get('/llistat-sessions', [LlistatSessionsController::class, 'index'])->name('llistat-sessions');
Route::post('/llistat-sessions', [LlistatSessionsController::class, 'index'])->name('llistat-sessions');

Route::get('/detalls-esdeveniment/{id}', [DetallsEsdevenimentController::class, 'show'])->name('detalls-esdeveniment');
Route::get('/administrar-esdeveniment/{id}', [AdministrarEsdevenimentController::class, 'show'])->name('administrar-esdeveniment');
Route::get('/llistats-entrades/{id}', [LlistatsEntradesController::class, 'show'])->name('llistats-entrades');

Route::get('/añadirSession',[EditarEsdevenimentController::class,'newSessionPage'])->name('añadirSession');
Route::post('/añadirSession',[EditarEsdevenimentController::class,'newSessionPage'])->name('añadirSession');

Route::post('/peticionSesion',[EditarEsdevenimentController::class,'newSesion'])->name('peticionSesion');
Route::get('/local/{id}',[EsdevenimentController::class, 'local'])->name('detallesLocal');