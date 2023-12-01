<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\salesTransaction;
use App\Models\SpendingTransaction;
use App\Models\Transaction;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->first();
            if($user->adminLevel == 0){
                $provinsi = Transaction::with(['sales.product'=>function($q) use($user){
                    $q->where('unit_usaha_id', $user->unit_usaha_id);
                },'sales.client','sales.kelurahan','spending.unitUsaha','spending'=>function($q) use($user){
                    $q->where('unit_usaha_id', $user->unit_usaha_id);
                }])->where('transactionStatus','!=','BELUMTERVERIFIKASI')->orderBy('updated_at','desc')->paginate(50);
                return response([
                    "data"=>$provinsi
                ],200);
            }
        }
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan','spending.unitUsaha'])->where('transactionStatus','!=','BELUMTERVERIFIKASI')->orderBy('updated_at','desc')->paginate(50);
        return response([
            "data"=>$transaction
        ],200);
    }
    
    public function showPencatatanDetail(Request $request)
    {
        $year = Carbon::now()->format('Y');
        if($request->query('year') != ''){
            $year = $request->query('year');
        }
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->first();
            if($user->adminLevel == 0){
                $provinsi = Transaction::with(['sales.product'=>function($q) use($user){
                    $q->where('unit_usaha_id', $user->unit_usaha_id);
                },'sales.client','sales.kelurahan','spending.unitUsaha','spending'=>function($q) use($user){
                    $q->where('unit_usaha_id', $user->unit_usaha_id);
                }])->where('transactionStatus','!=','BELUMTERVERIFIKASI')->orderBy('updated_at','desc')->whereYear('created_at',$year)->paginate(50);
                return response([
                    "data"=>$provinsi
                ],200);
            }
        }
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan','spending.unitUsaha'])->whereYear('created_at',$year)->where('transactionStatus','!=','BELUMTERVERIFIKASI')->orderBy('updated_at','desc')->paginate(50);
        return response([
            "data"=>$transaction
        ],200);
    }

    public function store(Request $request, TransactionService $service){
        $transaction = $service->createTransaction($request->all());
        return response($transaction, 201);
    }
   
    public function update(String $id, Request $request, TransactionService $service){
        $transaction = $service->updateTransaction($id, $request->all());
        return response($transaction, 201);
    }
    
    public function updateSpending(String $id, Request $request, TransactionService $service){
        $transaction = $service->updateSpendingTransaction($id, $request->all());
        return response($transaction, 201);
    }

    public function show(string $id)
    {
        $transaction = Transaction::where('id',$id)->first();
        return response($transaction,200);
    }

    public function showPenjualan(Request $request)
    {
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->whereRelation('sales.product','unit_usaha_id','=',$user->unit_usaha_id)->where('transactionType','PENJUALAN')->paginate(10);
                return response($transaction,200);
            }
        }
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->where('transactionType','PENJUALAN')->has('sales')->orderBy('updated_at','desc')->paginate(10);
        return response($transaction,200);
    }

    public function showPenjualanWithFilter(String $filter, Request $request)
    {
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $transaction =$transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->where('transactionType','PENJUALAN')->where('transactionStatus',$filter)->whereRelation('sales.product','unit_usaha_id','=',$user->unit_usaha_id)->paginate(50);
                return response($transaction,200);
            }
        }
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->where('transactionType','PENJUALAN')->where('transactionStatus',$filter)->paginate(50);
        return response($transaction,200);
    }
    
    public function showStat(Request $request)
    {
        $data = $request->all();
        $year = Carbon::now()->format('Y');
        if($request['year'] != ''){
            $year = $request['year'];
        }
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $stat['penjualan'] =  salesTransaction::select( 
                    \DB::raw('SUM(productPrice * productCount) as total'), 
                  ) ->whereYear('created_at',$year)->where('unit_usaha_id',$user->unit_usaha_id)->first();
                $stat['pengeluaran'] =  SpendingTransaction::select( 
                    \DB::raw('SUM(spendingValue) as total'), 
                    
                  )->where('unit_usaha_id',$user->unit_usaha_id)
                  ->whereYear('create_time',$year)->first();
                return response(
                    $stat
                ,200);
            }
        }
        $stat['penjualan'] =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as total'), 
          ) ->whereYear('created_at',$year)->first();
        $stat['pengeluaran'] =  SpendingTransaction::select( 
            \DB::raw('SUM(spendingValue) as total'),  
          )->whereYear('create_time', $year)->first();
        return response($stat,200);
    }
    
    public function getYear(){
        $year = Transaction::select(DB::raw('YEAR(created_at) year'))->groupBy('year')->get();
        return response($year,200);
    }
    
    public function showKeuangan(Request $request)
    {
        $data = $request->all();
        $from = $request['from'];
        $to = Carbon::now()->format('YYYY-MM-dd');
        if($request['to'] != ''){
            $to = $request['to'];
        }
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $stat['penjualan'] =  salesTransaction::select( 
                    \DB::raw('SUM(productPrice * productCount) as penjualan'), 
                    \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
                    \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
                  ) ->whereBetween('created_at',[$from,$to])->where('unit_usaha_id',$user->unit_usaha_id)->get();
                $stat['pengeluaran'] =  SpendingTransaction::select( 
                    \DB::raw('SUM(spendingValue) as pengeluaran'), 
                    \DB::raw("EXTRACT(YEAR FROM `create_time`) as year"),
                    \DB::raw("EXTRACT(MONTH FROM `create_time`) as month")
                  )
                  ->whereBetween('create_time',[$from,$to])->where('unit_usaha_id',$user->unit_usaha_id)->get();
                  return response($stat,200);
            }
        }
        $stat['penjualan'] =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as penjualan'), 
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereBetween('created_at',[$from,$to])->whereRelation('transaction','transactionStatus','!=','BATAL')
            ->whereRelation('transaction','transactionStatus','!=','BELUMTERVERIFIKASI')->groupBy('month','year')->get();
        $stat['pengeluaran'] =  SpendingTransaction::select( 
            \DB::raw('SUM(spendingValue) as pengeluaran'), 
            \DB::raw("EXTRACT(YEAR FROM `create_time`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `create_time`) as month")
            )->whereBetween('create_time',[$from,$to])->groupBy('month','year')->get();
        
        
        return response($stat,200);
    }

    public function destroy(String $id, Request $request, TransactionService $service){
        $transaction = $service->deleteSpendingTransaction($id);
        return response($transaction, 201);
    }

}
