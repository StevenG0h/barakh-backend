<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilUsaha;
use App\Models\UnitUsaha;
use App\Services\ProfilUsahaService;
use Illuminate\Http\Request;

class ProfilUsahaController extends Controller
{
    public function index()
    {
        $profilUsaha = UnitUsaha::with(['profil.profilUsahaImages'])->paginate(25);
        return response([
            "data"=>$profilUsaha
        ],200);
    }

    public function store(Request $request, ProfilUsahaService $service){
        $profilUsaha = $service->createProfilUsaha($request->all());
        return response($request, 201);
    }

    public function show(string $id)
    {
        $profilUsaha = ProfilUsaha::where('id',$id)->with(['unitUsaha.products.productImages','profilUsahaImages'])->first();
        return response($profilUsaha,200);
    }

    public function update(Request $request, string $id, ProfilUsahaService $service)
    {
        $profilUsaha = $service->updateProfilUsaha($id,$request->all());
        return $profilUsaha;
    }

    public function destroy(string $id, ProfilUsahaService $service)
    {
        $service = $service->deleteProfilUsaha($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
