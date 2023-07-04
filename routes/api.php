<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KecamatanController;
use App\Http\Controllers\Api\KelurahanController;
use App\Http\Controllers\Api\KotaController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProvinsiController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UnitUsahaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::prefix('admin')->group(function(){
    Route::get('/',[UserController::class,'index']);
});

Route::prefix('unit-usaha')->group(function(){
    Route::post('/{id}',[UnitUsahaController::class, 'update']);
    Route::post('/',[UnitUsahaController::class, 'store']);
    Route::get('/',[UnitUsahaController::class, 'index']);
    Route::get('/options',[UnitUsahaController::class, 'getOptions']);
    Route::delete('/{id}',[UnitUsahaController::class, 'destroy']);
    Route::get('/{id}',[UnitUsahaController::class, 'show']);
});

Route::prefix('produk')->group(function(){
    Route::post('/edit/{id}',[ProductController::class, 'update']);
    Route::post('/',[ProductController::class, 'store']);
    Route::post('/get-cart',[ProductController::class, 'getCart']);
    Route::get('/',[ProductController::class, 'index']);
    Route::delete('/{id}',[ProductController::class, 'destroy']);
    Route::get('/{id}',[ProductController::class, 'show']);
    Route::get('/withFilter/{id}',[ProductController::class, 'showWithFilter']);
});

Route::prefix('transaksi')->group(function(){
    Route::post('/{id}',[TransactionController::class, 'update']);
    Route::post('/',[TransactionController::class, 'store']);
    Route::get('/',[TransactionController::class, 'index']);
    Route::delete('/{id}',[TransactionController::class, 'destroy']);
    Route::get('/{id}',[TransactionController::class, 'show']);
    Route::get('/withFilter/{id}',[TransactionController::class, 'showWithFilter']);
});

Route::prefix('provinsi')->group(function(){
    Route::post('/{id}',[ProvinsiController::class, 'update']);
    Route::post('/',[ProvinsiController::class, 'store']);
    Route::get('/',[ProvinsiController::class, 'index']);
    Route::delete('/{id}',[ProvinsiController::class, 'destroy']);
    Route::get('/{id}',[ProvinsiController::class, 'show']);
    Route::get('/withFilter/{id}',[ProvinsiController::class, 'showWithFilter']);
});

Route::prefix('kota')->group(function(){
    Route::post('/{id}',[KotaController::class, 'update']);
    Route::post('/',[KotaController::class, 'store']);
    Route::get('/',[KotaController::class, 'index']);
    Route::delete('/{id}',[KotaController::class, 'destroy']);
    Route::get('/{id}',[KotaController::class, 'show']);
    Route::get('/withFilter/{id}',[KotaController::class, 'showWithFilter']);
});

Route::prefix('kecamatan')->group(function(){
    Route::post('/{id}',[KecamatanController::class, 'update']);
    Route::post('/',[KecamatanController::class, 'store']);
    Route::get('/',[KecamatanController::class, 'index']);
    Route::delete('/{id}',[KecamatanController::class, 'destroy']);
    Route::get('/{id}',[KecamatanController::class, 'show']);
    Route::get('/withFilter/{id}',[KecamatanController::class, 'showWithFilter']);
});

Route::prefix('kelurahan')->group(function(){
    Route::post('/{id}',[KelurahanController::class, 'update']);
    Route::post('/',[KelurahanController::class, 'store']);
    Route::get('/',[KelurahanController::class, 'index']);
    Route::delete('/{id}',[KelurahanController::class, 'destroy']);
    Route::get('/{id}',[KelurahanController::class, 'show']);
    Route::get('/withFilter/{id}',[KelurahanController::class, 'showWithFilter']);
});
