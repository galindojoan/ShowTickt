<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EsdevenimentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\passwordController;
use App\Http\Controllers\PasswordController as ControllersPasswordController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CrearEsdevenimentController;

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
Route::post('/login',[LoginController::class,'login'])->name(('login'));
Route::post('/homePromotor', [LoginController::class,'iniciarSesion'])->name('homePromotor');
Route::get('/homePromotor', [LoginController::class, 'iniciarSesion'])->name('homePromotor');
Route::post('/perfil', [LoginController::class,'iniciarSesion'])->name('perfil');
Route::get('/session', [SessionController::class, 'SessionController'])->name('session');
Route::get('/crear-esdeveniment', [CrearEsdevenimentController::class, 'index'])->name('crear-esdeveniment');
Route::post('/crear-esdeveniment.store', [CrearEsdevenimentController::class, 'store'])->name('crear-esdeveniment.store');
Route::get('/recuperar',[PasswordController::class,'passwordPage'])->name('recuperar');