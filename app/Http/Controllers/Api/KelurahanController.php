<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelurahan;
use App\Services\KelurahanService;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelurahans = Kelurahan::all();
        return response($kelurahans,200);
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
    public function store(Request $request, KelurahanService $service)
    {
        $kelurahan = $service->createKelurahan($request->all());
        return response($kelurahan,202);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelurahan = Kelurahan::where('id',$id)->first();
        return response($kelurahan,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, KelurahanService $service)
    {
        $kelurahan = $service->updateKelurahan($id,$request->all());
        return $kelurahan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, KelurahanService $service)
    {
        $service = $service->deleteKelurahan($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
