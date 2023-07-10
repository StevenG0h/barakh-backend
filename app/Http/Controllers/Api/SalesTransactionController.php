<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SalesTransactionService;
use Illuminate\Http\Request;

class SalesTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SalesTransactionService $service)
    {
        $transaction = $service->createTransaction($request->all());
        return $transaction;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request, SalesTransactionService $service)
    {
        $transaction = $service->updateTransaction($id, $request->all());
        return response($transaction,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, SalesTransactionService $service)
    {
        $transcation = $service->deleteTransaction($id);
        return response($transcation,200);
    }
}
