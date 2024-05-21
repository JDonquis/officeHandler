<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\BitacoraController;
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

Route::get('/', [AppController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');         

Route::middleware(['auth'])->group(function () 
{
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/bitacora', [BitacoraController::class, 'index']);    
    Route::post('/dashboard/bitacora', [BitacoraController::class, 'store']);    
    Route::put('/dashboard/bitacora/{id}', [BitacoraController::class, 'update']);    
    Route::delete('/dashboard/bitacora/{id}', [BitacoraController::class, 'destroy']); 
    
    
    Route::get('/dashboard/maquinas', [MaquinaController::class, 'index']);
    Route::post('/dashboard/maquinas', [MaquinaController::class, 'store']);
    Route::put('/dashboard/maquinas/{id}', [MaquinaController::class, 'update']);
    Route::delete('/dashboard/maquinas/{id}', [MaquinaController::class, 'destroy']);
});

