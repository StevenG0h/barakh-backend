<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Controllers\Api\Client;
use App\Models\Client as ModelsClient;
use App\Models\salesTransaction;
use App\Models\SpendingTransaction;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
      #return $request->all();
      $penjualan = $this->penjualanStat($request);
      $ProdukTerlaris = $this->ProdukTerlaris($request);
      $totalStok = $this->totalStok($request);
      $pelangganStat = $this->pelangganStat($request);
      $pengeluaran = $this->pengeluaran($request);
      $visitor =$this->visitor($request);
      return response(['penjualan'=>$penjualan,
      'produkTerlaris'=>$ProdukTerlaris,
      'totalStok'=>$totalStok,
      'pelangganStat'=>$pelangganStat,
      'pengeluaran'=>$pengeluaran,
      'visitor'=>$visitor
      ],200);
    }

    public function penjualanStat(Request $request){
        $data = $request->all();
        $date = date(Carbon::now());
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

        if(!isset($data['unitUsaha'])){
          if(!$from=='' && !$to==''){
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereBetween('created_at',[$from,$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } 
          else if(!$from==''){
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereBetween('created_at',[$from,$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          } else if(!$to==''){
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereBetween('created_at',['2020-01-01',$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } else {
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereBetween('created_at',['2020-01-01',$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          }
        } 
        else {
          if(!$from=="" && !$to==""){
            
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',[$from,$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } 
          else if(!$from==''){
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',[$from,$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          } 
          else if(!$to==''){
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',['2020-01-01',$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } 
          else {
            $stat =  salesTransaction::select( 
              \DB::raw('SUM(productPrice * productCount) as total'), 
              \DB::raw('SUM(productCount) as countPenjualan'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereRelation($location,'id',$locationId)
            ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',['2020-01-01',$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          }
        }

    }
    
    public function pengeluaran(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);
        $date = date(Carbon::now());

        if(!isset($data['unitUsaha'])){
          if(!$from=='' && !$to==''){
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereBetween('created_at',[$from,$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          }
          else if(!$from==''){
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereBetween('created_at',[$from,$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          }
          else if(!$to==''){
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereBetween('created_at',['2020-01-01',$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } else {
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereBetween('created_at',['2020-01-01',$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          }
        }
        else {
          if(!$from=="" && !$to==""){
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereRelation('unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',[$from,$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } else if(!$from="") {
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereRelation('unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',[$from,$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          } else if(!$to="") {
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereRelation('unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',['2020-01-01',$to])
            ->groupBy('month', 'year')->get();
            return $stat;
          } else {
            $stat =  SpendingTransaction::select( 
              \DB::raw('SUM(spendingValue) as total'), 
              \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
              \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereRelation('unitUsaha','id',$data['unitUsaha'])
            ->whereBetween('created_at',['2020-01-01',$date])
            ->groupBy('month', 'year')->get();
            return $stat;
          }
        }
    }
    
    public function visitor(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);
        $date = date(Carbon::now());+-**79++++++++++++++++++++++++++

        $stat =  Visitor::select( 
            \DB::raw('SUM(count) as total')
          )
          ->whereBetween('created_at',[$from,$to])->get();
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

        if($data['unitUsaha'] == '' || !isset($data['unitUsaha'])){
          $stat =  salesTransaction::select( 
            \DB::raw('COUNT(product_id) as total'),
            'product_id'
          )->with('product.unitUsaha')->whereRelation($location,'id',$locationId)
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('product_id')->get();
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
        
        if($data['unitUsaha'] == '' || !isset($data['unitUsaha'])){
          $stat =  Product::select( 
            \DB::raw('SUM(productStock) as total'),
            'unit_usaha_id'
          )->with(['unitUsaha'])
          ->whereBetween('created_at',[$from,$to])
          ->groupBy('unit_usaha_id')
          ->get();
          return $stat;
        }

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

      if($data['unitUsaha'] == '' || !isset($data['unitUsaha'])){
        $stat = salesTransaction::distinct()
          ->whereRelation($location,'id',$locationId)
          ->whereBetween('created_at',[$from,$to])
          ->count('client_id');
        return $stat;
      }

      $stat = salesTransaction::distinct()
      ->whereRelation('product.unitUsaha','id',$data['unitUsaha'])
      ->whereRelation($location,'id',$locationId)
      ->whereBetween('created_at',[$from,$to])
      ->count('client_id');
      return $stat;
  }
}
