<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\kecamatan;
use App\Services\kecamatanService;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $kecamatan = kecamatan::all();
        return response($kecamatan,200);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, kecamatanService $service)
    {
        $kecamatan = $service->createKecamatan($request->all());
        return $kecamatan;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kecamatan = kecamatan::where('id',$id)->first();
        return response($kecamatan,200);
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
    public function update(Request $request, string $id, kecamatanService $service)
    {
        $kecamatan = $service->updatekecamatan($id,$request->all());
        return $kecamatan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, kecamatanService $service)
    {
        $service = $service->deletekecamatan($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
