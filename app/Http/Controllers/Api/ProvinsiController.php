<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProvinsiTrait;
use App\Models\Provinsi;
use App\Services\ProvinsiService;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{

    public function index()
    {
        $provinsi = Provinsi::all();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, ProvinsiService $service){
        $provinsi = $service->createProvinsi($request->all());
        return response($provinsi, 201);
    }

    public function show(string $id)
    {
        $provinsi = Provinsi::where('id',$id)->first();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, ProvinsiService $service)
    {
        $provinsi = $service->updateProvinsi($id,$request->all());
        return $provinsi;
    }

    public function destroy(string $id, ProvinsiService $service)
    {
        $service = $service->deleteProvinsi($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
