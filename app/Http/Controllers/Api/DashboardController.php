<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Controllers\Api\Client;
use App\Models\Admin;
use App\Models\Client as ModelsClient;
use App\Models\salesTransaction;
use App\Models\SpendingTransaction;
use App\Models\Visitor;
use App\Exports\DashboardExports;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request){
      #return $request->all();
      if($request->user() != null){
        $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
            $request['unitUsaha'] = $user->unit_usaha_id;
        }
        
      }
        $penjualan = $this->penjualanStat($request);
        $ProdukTerlaris = $this->ProdukTerlaris($request);
        $totalStok = $this->totalStok($request);
        $pelangganStat = $this->pelangganStat($request);
        $pengeluaran = $this->pengeluaran($request);
        $visitor =$this->visitor($request);
        $pelangganDetail =$this->pelangganDetails($request);
        return response([
        'penjualan'=>$penjualan,
        'produkTerlaris'=>$ProdukTerlaris,
        'totalStok'=>$totalStok,
        'pelangganStat'=>$pelangganStat,
        'pengeluaran'=>$pengeluaran,
        'visitor'=>$visitor,
        'pelangganDetail'=>$pelangganDetail
        ],200);
    }

    public function filterLocationPelangganDetail($data){
      $filtered= [];
      if(!empty($data['kelurahan'])){
        $filtered['childLocation'] = 'client_id';
        $filtered['locationId'] = $data['kelurahan'];
        $filtered['relation'] = 'client';
        $filtered['scope'] = 'kelurahan';
        $filtered['location'] = 'kelurahan_id';
      }else if(!empty($data['kecamatan'])){
        $filtered['childLocation'] = 'kelurahan_id';
        $filtered['locationId'] = $data['kecamatan'];
        $filtered['relation'] = 'kelurahan';
        $filtered['scope'] = 'kecamatan';
        $filtered['location'] = 'kecamatan_id';
      }else if(!empty($data['kota'])){
        $filtered['childLocation'] = 'kecamatan_id';
        $filtered['locationId'] = $data['kota'];
        $filtered['relation'] = 'kecamatan';
        $filtered['scope'] = 'kota';
        $filtered['location'] = 'kota_id';
      } else if(!empty($data['provinsi'])){
        $filtered['childLocation'] = 'kota_id';
        $filtered['locationId'] = $data['provinsi'];
        $filtered['relation'] = 'kota';
        $filtered['scope'] = 'provinsi';
        $filtered['location'] = 'provinsi_id';
      }

      if(count($filtered) == 0){
        $filtered['childLocation'] = 'provinsi_id'; 
        $filtered['location'] = '';
        $filtered['locationId'] = '';
        $filtered['relation'] = 'provinsi';
        $filtered['scope'] = 'global';
        return $filtered;
      }

      return $filtered;
    }

    public function downloadExcel(Request $request){
      
      return Excel::download(new DashboardExports($request), 'dashboard.xlsx');
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
    
    public function filterDateDetail($transaction, $from, $to){
      $date = date(Carbon::now());
      if(!$from=='' && !$to==''){
        $transaction = $transaction->whereBetween('sales_transactions.created_at',[$from,$to]);
      } else if(!$from==''){
        $transaction = $transaction->whereBetween('sales_transactions.created_at',[$from,$date]);
      } else if(!$to==''){
        $transaction = $transaction->whereBetween('sales_transactions.created_at',['2020-01-01',$to]);
      } else {
        $transaction = $transaction->whereBetween('sales_transactions.created_at',['2020-01-01',$date]);
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
    
    public function filterUnitDirectDetail($transaction, $data){
      if(isset($data['unitUsaha'])){
        return $transaction->where('unit_usaha_id',$data['unitUsaha'])->with('unitUsaha');
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
        return $stat->whereRelation('transaction','transactionStatus','!=','BATAL')
        ->whereRelation('transaction','transactionStatus','!=','BELUMTERVERIFIKASI')
        ->groupBy('month', 'year')->get();
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
        return $stat->whereRelation('transaction','transactionStatus','!=','BATAL')
        ->whereRelation('transaction','transactionStatus','!=','BELUMTERVERIFIKASI')
        ->groupBy('product_id')->get();
    }

    public function totalStok(Request $request){
        $data = $request->all();
        
        $stat =  Product::select( 
          \DB::raw('SUM(productStock) as total')
        )->where('isActive','=','1');
        $stat = $this->filterUnitDirect($stat, $data);
        return $stat->get();
    }

    public function pelangganStat(Request $request){
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);

        $stat = salesTransaction::distinct();
        $stat = $this->filterLocation($stat, $data);
        $stat = $this->filterDate($stat, $from, $to);
        return $stat->whereRelation('transaction','transactionStatus','!=','BATAL')
        ->whereRelation('transaction','transactionStatus','!=','BELUMTERVERIFIKASI')
        ->count('client_id');
  }
  
  public function pelangganDetails(Request $request){
    $data = $request->all();
    $from = date($data['from']);
    $to = date($data['to']);


    // $detail = salesTransaction::selectRaw("c.clientName as Nama, COUNT(DISTINCT client_id) as Total, u.usahaName as ".'Unit Usaha'.", p.provinsiName as Provinsi, k.kota as Kota, kc.kecamatanName as Kecamatan, kl.kelurahanName as Kelurahan, p.id as ".'ID Provinsi'.", k.id as ".'ID Kota'.", kc.id as ".'ID Kecamatan'.", kl.id as ".'ID Kelurahan'.", st.created_at from sales_transactions st, provinsis p, kotas k, kecamatans kc, kelurahans kl, clients c, unit_usahas u, products pr");
    // $detail = $detail->whereRaw("WHERE st.client_id = c.id AND st.kelurahan_id = kl.id AND kl.kecamatanId = kc.id AND kc.kotaId = k.id AND k.provinsiId = p.id AND pr.id = st.product_id AND pr.unit_usaha_id = u.id AND 2023-08-01 <= st.created_at <= 2023-08-29")->groupByRaw('st.provinsi_id');
    // if($location['location'] != ''){
    //   $detail = $detail->where($location['location'],$location['locationId']);
    // }
    // $detail = $this->filterDate($detail, $from, $to);
    // $detail = $this->filterUnitDirectDetail($detail, $data);

    $location = $this->filterLocationPelangganDetail($data);
    $detail = DB::table('sales_transactions')->selectRaw('COUNT(sales_transactions.client_id) as Total, SUM(sales_transactions.productPrice * sales_transactions.productCount) as TotalTransaksi, unit_usahas.usahaName as UnitUsaha,  unit_usahas.id as UnitUsahaId, provinsis.provinsiName as Provinsi, kotas.kota as Kota, kecamatans.kecamatanName as Kecamatan, kelurahans.kelurahanName as Kelurahan, provinsis.id as IDProvinsi, kotas.id as IDKota, kecamatans.id as IDKecamatan, kelurahans.id as IDKelurahan, sales_transactions.created_at');
    if($location['childLocation'] == 'client_id'){
      $detail = DB::table('sales_transactions')
      ->selectRaw('clients.clientName as Nama, COUNT(sales_transactions.client_id) as Total, SUM(sales_transactions.productPrice * sales_transactions.productCount) as TotalTransaksi, unit_usahas.usahaName as UnitUsaha, unit_usahas.id as UnitUsahaId, provinsis.provinsiName as Provinsi, kotas.kota as Kota, kecamatans.kecamatanName as Kecamatan, kelurahans.kelurahanName as Kelurahan, provinsis.id as IDProvinsi, kotas.id as IDKota, kecamatans.id as IDKecamatan, kelurahans.id as IDKelurahan, sales_transactions.created_at')
      ->join('clients','sales_transactions.client_id', '=', 'clients.id');
    }
    $detail = $detail->join('provinsis','sales_transactions.provinsi_id', '=', 'provinsis.id')
    ->join('kotas','sales_transactions.kota_id', '=', 'kotas.id')
    ->join('kecamatans','sales_transactions.kecamatan_id', '=', 'kecamatans.id')
    ->join('kelurahans','sales_transactions.kelurahan_id', '=', 'kelurahans.id')
    ->join('products','sales_transactions.product_id', '=', 'products.id')
    ->join('unit_usahas','sales_transactions.unit_usaha_id', '=', 'unit_usahas.id')
    ->join('transactions','sales_transactions.transaction_id', '=', 'transactions.id')
    ->whereRaw("transactions.transactionStatus != 'BELUMTERVERIFIKASI' AND transactions.transactionStatus != 'BATAL' AND sales_transactions.kelurahan_id = kelurahans.id AND sales_transactions.kecamatan_id = kecamatans.id AND sales_transactions.kota_id = kotas.id AND sales_transactions.provinsi_id = provinsis.id AND products.id = sales_transactions.product_id AND sales_transactions.unit_usaha_id = unit_usahas.id");
    if($location['locationId'] != ''){
      $detail = $detail->where($location['location'],$location['locationId']);
    }
    if(!empty($data['unitUsaha'])){
      $detail = $detail->where('sales_transactions.unit_usaha_id',$data['unitUsaha']);
    }
    $detail = 
    $this->filterDateDetail($detail,$from,$to)
    ->groupByRaw('sales_transactions.'.$location['childLocation'].', sales_transactions.unit_usaha_id')->get();
    $wrap['scope'] = $location['scope'];
    $wrap['detail'] = $detail;
    return $wrap;
  }
}