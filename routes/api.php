<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GaleriController;
use App\Http\Controllers\Api\KecamatanController;
use App\Http\Controllers\Api\KelurahanController;
use App\Http\Controllers\Api\KotaController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfilUsahaController;
use App\Http\Controllers\Api\ProvinsiController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SalesTransactionController;
use App\Http\Controllers\Api\TestimonyController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UnitUsahaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Ui\Presets\React;

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

Route::middleware(['auth:sanctum'])->group(function (){
    Route::prefix('/admin')->group(function(){
        Route::get('/user',function(Request $request){
            return $request->user();
        });

        

        Route::prefix('/admin')->group(function(){
            Route::get('/',[UserController::class,'index']);
            Route::put('/{id}',[UserController::class,'edit']);
            Route::delete('/{id}',[UserController::class,'destroy']);
        });

        Route::prefix('/galeri')->group(function(){
            Route::get('/',[GaleriController::class,'index']);
            Route::post('/',[GaleriController::class,'store']);
            Route::post('/edit/{id}',[GaleriController::class,'edit']);
            Route::delete('/{id}',[GaleriController::class,'destroy']);
        });

        Route::prefix('unit-usaha')->group(function(){
            Route::post('/{id}',[UnitUsahaController::class, 'update']);
            Route::post('/',[UnitUsahaController::class, 'store']);
            Route::get('/',[UnitUsahaController::class, 'index']);
            Route::delete('/{id}',[UnitUsahaController::class, 'destroy']);
            Route::get('/{id}',[UnitUsahaController::class, 'show']);
            
        });

        
        Route::get('/logout',function(Request $request){
            return $request->user()->currentAccessToken()->delete();
        });

        Route::prefix('client')->group(function(){
            Route::post('/{id}',[ClientController::class, 'update']);
            Route::post('/',[ClientController::class, 'store']);
            Route::get('/',[ClientController::class, 'index']);
            Route::get('/options',[ClientController::class, 'getOptions']);
            Route::delete('/{id}',[ClientController::class, 'destroy']);
            Route::get('/{id}',[ClientController::class, 'show']);
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
            Route::put('/{id}',[TransactionController::class, 'update']);
            Route::post('/',[TransactionController::class, 'store']);
            Route::get('/',[TransactionController::class, 'index']);
            Route::delete('/{id}',[TransactionController::class, 'destroy']);
            Route::get('/show/{id}',[TransactionController::class, 'show']);
            Route::get('/penjualan',[TransactionController::class, 'showPenjualan']);
        });
        
        Route::prefix('provinsi')->group(function(){
            Route::post('/{id}',[ProvinsiController::class, 'update']);
            Route::post('/',[ProvinsiController::class, 'store']);
            Route::get('/',[ProvinsiController::class, 'index']);
            Route::delete('/{id}',[ProvinsiController::class, 'destroy']);
            Route::get('/{id}/all',[ProvinsiController::class, 'showAllById']);
            Route::get('/withFilter/{id}',[ProvinsiController::class, 'showWithFilter']);
        });
        
        Route::prefix('kota')->group(function(){
            Route::post('/{id}',[KotaController::class, 'update']);
            Route::post('/',[KotaController::class, 'store']);
            Route::get('/',[KotaController::class, 'index']);
            Route::delete('/{id}',[KotaController::class, 'destroy']);
            Route::get('/{id}',[KotaController::class, 'show']);
            Route::get('/{id}/all',[KotaController::class, 'showAllById']);
            Route::get('/withFilter/{id}',[KotaController::class, 'showWithFilter']);
        });
        
        Route::prefix('penjualan')->group(function(){
            Route::put('/{id}',[SalesTransactionController::class, 'edit']);
            Route::post('/',[SalesTransactionController::class, 'store']);
            Route::get('/',[SalesTransactionController::class, 'index']);
            Route::delete('/{id}',[SalesTransactionController::class, 'destroy']);
            Route::get('/{id}',[SalesTransactionController::class, 'show']);
            Route::get('/{id}/all',[SalesTransactionController::class, 'showAllById']);
            Route::get('/withFilter/{id}',[SalesTransactionController::class, 'showWithFilter']);
        });
        
        Route::prefix('profil')->group(function(){
            Route::post('/edit/{id}',[ProfilUsahaController::class, 'update']);
            Route::post('/',[ProfilUsahaController::class, 'store']);
            Route::get('/',[ProfilUsahaController::class, 'index']);
            Route::delete('/{id}',[ProfilUsahaController::class, 'destroy']);
            Route::get('/{id}',[ProfilUsahaController::class, 'show']);
        });
        
        Route::prefix('transaksi')->group(function(){
            Route::put('/{id}',[TransactionController::class, 'update']);
            Route::post('/',[TransactionController::class, 'store']);
            Route::get('/',[TransactionController::class, 'index']);
            Route::delete('/{id}',[TransactionController::class, 'destroy']);
            Route::get('/show/{id}',[TransactionController::class, 'show']);
            Route::get('/penjualan',[TransactionController::class, 'showPenjualan']);
            Route::get('/penjualan/{filter}',[TransactionController::class, 'showPenjualanWithFilter']);
            Route::post('/pencatatan',[TransactionController::class, 'showStat']);
        });
        
        Route::prefix('testimoni')->group(function(){
            Route::put('/{id}',[TestimonyController::class, 'update']);
            Route::post('/',[TestimonyController::class, 'store']);
            Route::get('/',[TestimonyController::class, 'index']);
            Route::delete('/{id}',[TestimonyController::class, 'destroy']);
            Route::get('/show/{id}',[TestimonyController::class, 'show']);
        });
    });
});

Route::get('/unit-usahas/options',[UnitUsahaController::class, 'getOptions']);
Route::post('/login',[AuthController::class,'login']);

Route::prefix('testimoni')->group(function(){
    Route::get('/',[TestimonyController::class, 'index']);
});

Route::post('/register',[AuthController::class,'register']);

Route::prefix('/galeri')->group(function(){
    Route::get('/',[GaleriController::class,'index']);
    Route::post('/',[GaleriController::class,'store']);
    Route::post('/edit/{id}',[GaleriController::class,'edit']);
    Route::delete('/{id}',[GaleriController::class,'destroy']);
});

Route::prefix('client')->group(function(){
    Route::post('/{id}',[ClientController::class, 'update']);
    Route::post('/',[ClientController::class, 'store']);
    Route::get('/',[ClientController::class, 'index']);
    Route::get('/options',[ClientController::class, 'getOptions']);
    Route::delete('/{id}',[ClientController::class, 'destroy']);
    Route::get('/{id}',[ClientController::class, 'show']);
});

Route::prefix('profil')->group(function(){
    Route::get('/',[ProfilUsahaController::class, 'index']);
    Route::get('/{id}',[ProfilUsahaController::class, 'show']);
});


Route::prefix('unit-usaha')->group(function(){
    Route::get('/product-option/{id}',[UnitUsahaController::class, 'showProductOption']);
    Route::post('/{id}',[UnitUsahaController::class, 'update']);
    Route::post('/',[UnitUsahaController::class, 'store']);
    Route::get('/',[UnitUsahaController::class, 'index']);
    Route::delete('/{id}',[UnitUsahaController::class, 'destroy']);
    Route::get('/{id}',[UnitUsahaController::class, 'show']);
});
Route::prefix('produk')->group(function(){
    Route::post('/edit/{id}',[ProductController::class, 'update']);
    Route::post('/',[ProductController::class, 'store']);
    Route::put('/rating/{id}',[RatingController::class, 'store']);
    Route::post('/get-cart',[ProductController::class, 'getCart']);
    Route::get('/',[ProductController::class, 'index']);
    Route::get('/home',[ProductController::class, 'home']);
    Route::delete('/{id}',[ProductController::class, 'destroy']);
    Route::get('/{id}',[ProductController::class, 'show']);
    Route::get('/withFilter/{id}',[ProductController::class, 'showWithFilter']);
    Route::post('/search',[ProductController::class, 'searchWithFilter']);
});

Route::prefix('transaksi')->group(function(){
    Route::put('/{id}',[TransactionController::class, 'update']);
    Route::post('/',[TransactionController::class, 'store']);
    Route::get('/',[TransactionController::class, 'index']);
    Route::delete('/{id}',[TransactionController::class, 'destroy']);
    Route::get('/show/{id}',[TransactionController::class, 'show']);
    Route::get('/penjualan',[TransactionController::class, 'showPenjualan']);
    Route::get('/penjualanWithFilter',[TransactionController::class, 'showPenjualanWithFilter']);
});

Route::prefix('provinsi')->group(function(){
    Route::post('/{id}',[ProvinsiController::class, 'update']);
    Route::post('/',[ProvinsiController::class, 'store']);
    Route::get('/',[ProvinsiController::class, 'index']);
    Route::delete('/{id}',[ProvinsiController::class, 'destroy']);
    Route::get('/{id}/all',[ProvinsiController::class, 'showAllById']);
    Route::get('/withFilter/{id}',[ProvinsiController::class, 'showWithFilter']);
});

Route::prefix('kota')->group(function(){
    Route::post('/{id}',[KotaController::class, 'update']);
    Route::post('/',[KotaController::class, 'store']);
    Route::get('/',[KotaController::class, 'index']);
    Route::delete('/{id}',[KotaController::class, 'destroy']);
    Route::get('/{id}',[KotaController::class, 'show']);
    Route::get('/{id}/all',[KotaController::class, 'showAllById']);
    Route::get('/withFilter/{id}',[KotaController::class, 'showWithFilter']);
});

Route::prefix('kecamatan')->group(function(){
    Route::post('/{id}',[KecamatanController::class, 'update']);
    Route::post('/',[KecamatanController::class, 'store']);
    Route::get('/',[KecamatanController::class, 'index']);
    Route::delete('/{id}',[KecamatanController::class, 'destroy']);
    Route::get('/{id}',[KecamatanController::class, 'show']);
    Route::get('/{id}/all',[KecamatanController::class, 'showAllById']);
    Route::get('/withFilter/{id}',[KecamatanController::class, 'showWithFilter']);
});

Route::prefix('kelurahan')->group(function(){
    Route::post('/{id}',[KelurahanController::class, 'update']);
    Route::post('/',[KelurahanController::class, 'store']);
    Route::get('/',[KelurahanController::class, 'index']);
    Route::delete('/{id}',[KelurahanController::class, 'destroy']);
    Route::get('/{id}',[KelurahanController::class, 'show']);
    Route::get('/{id}/all',[KelurahanController::class, 'showAllById']);
    Route::get('/withFilter/{id}',[KelurahanController::class, 'showWithFilter']);
});

Route::prefix('dashboard')->group(function(){
    Route::post('/',[DashboardController::class,'index']);
});

    Route::get('/get-number',[AdminController::class,'getNumber']);


Route::prefix('visitor')->group(function(){
    Route::get('/',[VisitorController::class,'index']);
});