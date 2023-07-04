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
        $provinsi = UnitUsaha::with('products')->paginate('25');
        return response([
            "data"=>$provinsi
        ],200);
    }
    
    public function getOptions()
    {
        $provinsi = UnitUsaha::get();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, UnitUsahaService $service){
        $provinsi = $service->createUnitUsaha($request->all(), $request->usahaImage);
        return response($provinsi, 201);
    }

    public function show(string $id)
    {
        $provinsi = UnitUsaha::where('id',$id)->with(['products.productImages'])->first();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, UnitUsahaService $service)
    {
        $provinsi = $service->updateUnitUsaha($id,$request->all(),$request->usahaImage);
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
