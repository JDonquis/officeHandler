<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
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

Route::get('/', [AppController::class, 'index'])->name('login')->middleware('web');
Route::post('/login', [UserController::class, 'login']);

Route::group(['prefix' => 'dashboard','namespace' => 'App\Http\Controllers', 'middleware' => ['web']], function() 
{

    Route::get('', [AppController::class, 'dashboard'])->name('home');
    Route::get('maquinas', [AppController::class, 'maquinas']);
    Route::get('bitacora', [BitacoraController::class, 'index']);


});

