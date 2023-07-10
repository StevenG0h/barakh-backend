<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->paginate(50);
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

    public function showPenjualan()
    {
        $transaction = Transaction::with(['sales.product','sales.client','sales.kelurahan'])->where('transactionType','PENJUALAN')->paginate(50);
        return response($transaction,200);
    }

}
