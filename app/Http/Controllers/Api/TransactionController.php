<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\salesTransaction;
use App\Models\SpendingTransaction;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan','spending.unitUsaha'])->where('transactionStatus','!=','BELUMTERVERIFIKASI')->orderBy('updated_at','desc')->paginate(50);
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

    public function show(string $id)
    {
        $transaction = Transaction::where('id',$id)->first();
        return response($transaction,200);
    }

    public function showPenjualan(Request $request)
    {
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->first();
            if($user->adminLevel == 0){
                $provinsi = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->whereRelation('sales.product','unit_usaha_id','=',$user->unit_usaha_id)->where('transactionType','PENJUALAN')->paginate(50);
                return response([
                    "data"=>$provinsi
                ],200);
            }
        }
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->where('transactionType','PENJUALAN')->paginate(50);
        return response($transaction,200);
    }

    public function showPenjualanWithFilter(String $filter)
    {
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->where('transactionType','PENJUALAN')->where('transactionStatus',$filter)->paginate(50);
        return response($transaction,200);
    }
    
    public function showStat(Request $request)
    {
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);
        $stat['penjualan'] =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as total'), 
          ) ->whereBetween('created_at',[$from,$to])->first();
        $stat['pengeluaran'] =  SpendingTransaction::select( 
            \DB::raw('SUM(spendingValue) as total'), 
            
          )
          ->whereBetween('created_at',[$from,$to])->first();
        return response($stat,200);
    }
    
    public function showKeuangan(Request $request)
    {
        $data = $request->all();
        $from = date($data['from']);
        $to = date($data['to']);
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->first();
            if($user->adminLevel == 0){
                $stat['penjualan'] =  salesTransaction::select( 
                    \DB::raw('SUM(productPrice * productCount) as penjualan'), 
                    \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
                    \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
                  ) ->whereBetween('created_at',[$from,$to])->where('unit_usaha_id',$user->unit_usaha_id)->get();
                $stat['pengeluaran'] =  SpendingTransaction::select( 
                    \DB::raw('SUM(spendingValue) as pengeluaran'), 
                    \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
                    \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
                  )
                  ->whereBetween('created_at',[$from,$to])->where('unit_usaha_id',$user->unit_usaha_id)->get();
                  return response($stat,200);
            }
        }
        $stat['penjualan'] =  salesTransaction::select( 
            \DB::raw('SUM(productPrice * productCount) as penjualan'), 
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            ) ->whereBetween('created_at',[$from,$to])->get();
        $stat['pengeluaran'] =  SpendingTransaction::select( 
            \DB::raw('SUM(spendingValue) as pengeluaran'), 
            \DB::raw("EXTRACT(YEAR FROM `created_at`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )
            ->whereBetween('created_at',[$from,$to])->get();
        
        
        return response($stat,200);
    }

}
