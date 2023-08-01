<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Controllers\Api\Client;
use App\Models\Client as ModelsClient;
use App\Models\salesTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function penjualanStat(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $location = 'kelurahan.kecamatan.kota.provinsi';
        $locationId = '';
        if(!empty($data['kelurahan'])){
          $location = 'kelurahan';
          $locationId = $data['kelurahan'];
        }else if(!empty($data['kecamatan'])){
          $location = 'kecamatan';
          $locationId = $data['kecamatan'];
        }else if(!empty($data['kota'])){
          $location = 'kota';
          $locationId = $data['kota'];
        } else if(!empty($data['provinsi'])){
          $location = 'provinsi';
          $locationId = $data['provinsi'];
        }

        $stat =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as total'), 
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
          )->whereRelation($location,'id',$locationId)
          ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('month', 'year')->get();
        return $stat;
    }

    public function ProdukTerlaris(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $location = 'kelurahan.kecamatan.kota.provinsi';
        $locationId = '';
        if(!empty($data['kelurahan'])){
          $location = 'kelurahan';
          $locationId = $data['kelurahan'];
        }else if(!empty($data['kecamatan'])){
          $location = 'kecamatan';
          $locationId = $data['kecamatan'];
        }else if(!empty($data['kota'])){
          $location = 'kota';
          $locationId = $data['kota'];
        } else if(!empty($data['provinsi'])){
          $location = 'provinsi';
          $locationId = $data['provinsi'];
        }

        $stat =  salesTransaction::select( 
            \DB::raw('COUNT(product_id) as total'),
            'product_id'
          )->with('product.unitUsaha')->whereRelation($location,'id',$locationId)
          ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('product_id')->get();
        return $stat;
    }

    public function totalStok(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);
        $stat =  Product::select( 
          \DB::raw('SUM(productStock) as total'),
          'unit_usaha_id'
        )->with(['unitUsaha'])
        ->where('unit_usaha_id','=',$data['unitUsaha'])
        ->whereBetween('created_at',[$from,$to])
        ->groupBy('unit_usaha_id')
        ->get();
        return $stat;
    }

    public function pelangganStat(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $location = 'kelurahan.kecamatan.kota.provinsi';
        $locationId = '';
        if(!empty($data['kelurahan'])){
          $location = 'kelurahan';
          $locationId = $data['kelurahan'];
        }else if(!empty($data['kecamatan'])){
          $location = 'kecamatan';
          $locationId = $data['kecamatan'];
        }else if(!empty($data['kota'])){
          $location = 'kota';
          $locationId = $data['kota'];
        } else if(!empty($data['provinsi'])){
          $location = 'provinsi';
          $locationId = $data['provinsi'];
        }

      // $stat =  ModelsClient::select( 
      //   \DB::raw('COUNT(client_id) as total')
      // )->with(['salesTransaction'])
      // ->where('unit_usaha_id','=','1')
      // ->whereBetween('created_at',[$from,$to])
      // ->groupBy('unit_usaha_id')
      // ->get();
      $stat = salesTransaction::distinct()
      ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
      ->whereRelation($location,'id',$locationId)
      ->whereBetween('created_at',[$from,$to])
      ->count('client_id');
      return $stat;
  }
}
