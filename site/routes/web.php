<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EsdevenimentController;
use App\Http\Controllers\LoginController;

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
Route::get('/login',[LoginController::class,'login'])->name(('login'));