<?php

use Illuminate\Support\Facades\Route;

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
    //return view('welcome');
   return redirect('/login'); //redireccionamos al login
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//categorias
Route::get('/categorias', [App\Http\Controllers\CategoriasController::class, 'index']);
Route::get('/categorias/registrar', [App\Http\Controllers\CategoriasController::class, 'create']);
Route::post('/categorias/registrar/', [App\Http\Controllers\CategoriasController::class, 'store']);
//actualizar
Route::get('/categorias/actualizar/{id}', [App\Http\Controllers\CategoriasController::class, 'edit']);
//update
Route::put('/categorias/actualizar/{id}', [App\Http\Controllers\CategoriasController::class, 'update']);
//cambiar estado
Route::get('/categorias/estado/{id}', [App\Http\Controllers\CategoriasController::class, 'estado']);





