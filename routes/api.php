<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\KecamatanController;
use App\Http\Controllers\Api\KelurahanController;
use App\Http\Controllers\Api\KotaController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProvinsiController;
use App\Http\Controllers\Api\TestimonyController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UnitUsahaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function (){
    Route::resource('admin', AdminController::class);
    Route::resource('client', ClientController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('kelurahan', KelurahanController::class);
    Route::resource('kota', KotaController::class);
    Route::resource('product', ProductController::class);
    Route::resource('provinsi', ProvinsiController::class);
    Route::resource('testimony', TestimonyController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('unit-usaha', UnitUsahaController::class);
});

Route::post("/login",[AuthController::class,"login"]);
Route::post("/register",[AuthController::class,"register"]);

