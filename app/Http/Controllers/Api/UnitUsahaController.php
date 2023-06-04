<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnitUsaha;
use App\Services\UnitUsahaService;
use Illuminate\Http\Request;

class UnitUsahaController extends Controller
{
    public function index()
    {
        $provinsi = UnitUsaha::all();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, UnitUsahaService $service){
        $provinsi = $service->createUnitUsaha($request->all());
        return response($provinsi, 201);
    }

    public function show(string $id)
    {
        $provinsi = UnitUsaha::where('id',$id)->first();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, UnitUsahaService $service)
    {
        $provinsi = $service->updateUnitUsaha($id,$request->all());
        return $provinsi;
    }

    public function destroy(string $id, UnitUsahaService $service)
    {
        $service = $service->deleteUnitUsaha($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
