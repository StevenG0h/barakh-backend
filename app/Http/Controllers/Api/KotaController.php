<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Services\KotaService;
use Illuminate\Http\Request;

class KotaController extends Controller
{

    public function index()
    {
        $kota = Kota::all();
        return response($kota,200);
    }

    public function store(Request $request, KotaService $service)
    {
        $kota = $service->createKota($request->all());
        return response($kota,201);
    }

    public function show(string $id)
    {
        $kota = Kota::where('id',$id)->first();
        return response($kota,200);
    }
    
    public function showAllById(string $id)
    {
        $kota = Kota::where('provinsiId',$id)->get();
        return response($kota,200);
    }

    public function update(Request $request, string $id, KotaService $service)
    {
        $kota = $service->updateKota($id,$request->all());
        return $kota;
    }

    public function destroy(string $id, KotaService $service)
    {
        $service = $service->deleteKota($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
