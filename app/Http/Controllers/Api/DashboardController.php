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
      return response([
      'penjualan'=>$penjualan,
      'produkTerlaris'=>$ProdukTerlaris,
      'totalStok'=>$totalStok,
      'pelangganStat'=>$pelangganStat,
      'pengeluaran'=>$pengeluaran,
      'visitor'=>$visitor
      ],200);
    }

    public function filterLocation($transaction, $data){
      $location = '';
      $locationId ='';
      if(!empty($data['kelurahan'])){
        $location = 'kelurahan';
        $locationId = $data['kelurahan'];
      }else if(!empty($data['kecamatan'])){
        $location = 'kelurahan.kecamatan';
        $locationId = $data['kecamatan'];
      }else if(!empty($data['kota'])){
        $location = 'kelurahan.kecamatan.kota';
        $locationId = $data['kota'];
      } else if(!empty($data['provinsi'])){
        $location = 'kelurahan.kecamatan.kota.provinsi';
        $locationId = $data['provinsi'];
      }

      if($location == '' && $locationId == ''){
        return $transaction;
      }
      $transaction = $transaction->whereRelation($location,'id',$locationId);
      return $transaction;
    }
    
    public function filterDate($transaction, $from, $to){
      $date = date(Carbon::now());
      if(!$from=='' && !$to==''){
        $transaction = $transaction->whereBetween('created_at',[$from,$to]);
      } else if(!$from==''){
        $transaction = $transaction->whereBetween('created_at',[$from,$date]);
      } else if(!$to==''){
        $transaction = $transaction->whereBetween('created_at',['2020-01-01',$to]);
      } else {
        $transaction = $transaction->whereBetween('created_at',['2020-01-01',$date]);
      }
      return $transaction;
    }

    public function filterUnit($transaction, $data){
      if(isset($data['unitUsaha'])){
        return $transaction->whereRelation('product.unitUsaha','id',$data['unitUsaha']);
      }else{
        return $transaction;
      }
    }
    
    public function filterUnitDirect($transaction, $data){
      if(isset($data['unitUsaha'])){
        return $transaction->whereRelation('unitUsaha','id',$data['unitUsaha']);
      }else{
        return $transaction;
      }
    }

    public function penjualanStat(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $stat = salesTransaction::select( 
          \DB::raw('SUM(productPrice * productCount) as total'), 
          \DB::raw('SUM(productCount) as countPenjualan'), 
          \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
          \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
        );
        $stat = $this->filterLocation($stat, $data);
        $stat = $this->filterUnit($stat, $data);
        $stat = $this->filterDate($stat, $from, $to);
        return $stat->groupBy('month', 'year')->get();
    }
    
    public function pengeluaran(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $stat =  SpendingTransaction::select( 
          \DB::raw('SUM(spendingValue) as total'), 
          \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
          \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
        );
        $stat = $this->filterUnitDirect($stat, $data);
        $stat = $this->filterDate($stat, $from, $to);
        return $stat->groupBy('month', 'year')->get();
    }
    
    public function visitor(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);
        
        $stat =  Visitor::select( 
          \DB::raw('SUM(count) as total')
        );
        $stat = $this->filterDate($stat, $from, $to);
        return $stat->get();
    }

    public function ProdukTerlaris(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $stat =  salesTransaction::select( 
          \DB::raw('COUNT(product_id) as total'),
          'product_id'
        )->with('product');
        $stat = $this->filterLocation($stat, $data);
        $stat = $this->filterUnit($stat, $data);
        $stat = $this->filterDate($stat, $from, $to);
        return $stat->groupBy('product_id')->get();
    }

    public function totalStok(Request $request){
        $data = $request->all();
        
        $stat =  Product::select( 
          \DB::raw('SUM(productStock) as total'),
          'unit_usaha_id'
        )->with(['unitUsaha']);
        $stat = $this->filterUnitDirect($stat, $data);
        return $stat->groupBy('unit_usaha_id')->get();
    }

    public function pelangganStat(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $stat = salesTransaction::distinct();
        $stat = $this->filterLocation($stat, $data);
        $stat = $this->filterDate($stat, $from, $to);
        return $stat->count('client_id');
  }
}