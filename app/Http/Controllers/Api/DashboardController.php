<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\salesTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function penjualanStat(Request $request){
        $from = date('2018-01-01');
        $to = date('2025-01-01');
        $stat =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as total'), 
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
          )->whereRelation('kelurahan.kecamatan.kota.provinsi','id','4')
          ->whereRelation('product.unitUsaha','id','1')
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('month', 'year')->get();
        return $stat;
    }

    public function totalStat(Request $request){
        $from = date('2018-01-01');
        $to = date('2025-01-01');
        $stat =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as total'),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
          )->whereRelation('kelurahan.kecamatan.kota.provinsi','id','4')
          ->whereRelation('product.unitUsaha','id','1')
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('month')->get();
        return $stat;
    }

    public function ProdukTerlaris(Request $request){
        $from = date('2018-01-01');
        $to = date('2025-01-01');
        $stat =  salesTransaction::select( 
            \DB::raw('COUNT(product_id) as total'),
            'product_id'
          )->with('product.unitUsaha')->whereRelation('kelurahan.kecamatan.kota.provinsi','id','4')
          ->whereRelation('product.unitUsaha','id','1')
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('product_id')->get();
        return $stat;
    }
}
