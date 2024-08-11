<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KategoriController;

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
Route::get('/', [HomeController::class,'home']);
Route::get('/kategori', [KategoriController::class,'index']);
Route::post('/submit-kategori', [KategoriController::class,'submit']);
Route::put('/update-kategori/{id}', [KategoriController::class,'update']);
Route::delete('/delete-kategori/{id}', [KategoriController::class,'delete']);

Route::get('/menu', [MenuController::class,'index']);
Route::post('/submit-menu', [MenuController::class,'submit']);
Route::put('/update-menu/{id}', [MenuController::class,'update']);
Route::delete('/delete-menu/{id}', [MenuController::class,'delete']);

Route::post('/cetak-bill', [HomeController::class,'cetak']);
