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
        $provinsi = Transaction::all();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, TransactionService $service){
        $provinsi = $service->createTransaction($request->all());
        return response($provinsi, 201);
    }

    public function show(string $id)
    {
        $provinsi = Transaction::where('id',$id)->first();
        return response($provinsi,200);
    }

}
