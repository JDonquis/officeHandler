<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
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

Route::get('/', [AppController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/dashboard', [AppController::class, 'dashboard']);
Route::get('/dashboard/maquinas', [AppController::class, 'maquinas']);
Route::get('/dashboard/bitacora', [AppController::class, 'bitacora']);

