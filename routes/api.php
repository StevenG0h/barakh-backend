<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UnitUsahaController;
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

Route::prefix('unit-usaha')->group(function(){
    Route::post('/{id}',[UnitUsahaController::class, 'update']);
    Route::post('/',[UnitUsahaController::class, 'store']);
    Route::get('/',[UnitUsahaController::class, 'index']);
    Route::delete('/{id}',[UnitUsahaController::class, 'destroy']);
    Route::get('/{id}',[UnitUsahaController::class, 'show']);
});

Route::prefix('produk')->group(function(){
    Route::post('/{id}',[ProductController::class, 'update']);
    Route::post('/',[ProductController::class, 'store']);
    Route::get('/',[ProductController::class, 'index']);
    Route::delete('/{id}',[ProductController::class, 'destroy']);
    Route::get('/{id}',[ProductController::class, 'show']);
});
