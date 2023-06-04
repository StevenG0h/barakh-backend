<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelurahan;
use App\Services\KelurahanService;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{

    public function index()
    {
        $kelurahans = Kelurahan::all();
        return response($kelurahans,200);
    }

    public function store(Request $request, KelurahanService $service)
    {
        $kelurahan = $service->createKelurahan($request->all());
        return response($kelurahan,202);
    }

    public function show(string $id)
    {
        $kelurahan = Kelurahan::where('id',$id)->first();
        return response($kelurahan,200);
    }

    public function update(Request $request, string $id, KelurahanService $service)
    {
        $kelurahan = $service->updateKelurahan($id,$request->all());
        return $kelurahan;
    }

    public function destroy(string $id, KelurahanService $service)
    {
        $service = $service->deleteKelurahan($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
