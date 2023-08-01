<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\kecamatan;
use App\Services\kecamatanService;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = kecamatan::all();
        return response($kecamatan,200);
    }

    public function store(Request $request, kecamatanService $service)
    {
        $kecamatan = $service->createKecamatan($request->all());
        return $kecamatan;
    }

    public function show(string $id)
    {
        $kecamatan = kecamatan::where('id',$id)->first();
        return response($kecamatan,200);
    }

    public function showAllById(string $id)
    {
        $kota = kecamatan::where('kotaId',$id)->get();
        return response($kota,200);
    }

    public function update(Request $request, string $id, kecamatanService $service)
    {
        $kecamatan = $service->updatekecamatan($id,$request->all());
        return $kecamatan;
    }

    public function destroy(string $id, kecamatanService $service)
    {
        $service = $service->deletekecamatan($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
