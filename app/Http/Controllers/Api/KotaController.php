<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Services\KotaService;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kota = Kota::all();
        return response($kota,200);
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
    public function store(Request $request, KotaService $service)
    {
        $kota = $service->createKota($request->all());
        return response($kota,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kota = Kota::where('id',$id)->first();
        return response($kota,200);
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
    public function update(Request $request, string $id, KotaService $service)
    {
        $kota = $service->updateKota($id,$request->all());
        return $kota;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, KotaService $service)
    {
        $service = $service->deleteKota($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
