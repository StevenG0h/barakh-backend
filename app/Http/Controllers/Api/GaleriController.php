<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\galeri;
use App\Services\GaleriService;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    //public function index()
    public function index(){
        $galeri = galeri::paginate(25);
        return response([
            "data"=>$galeri
        ],200);
    }

    public function store(Request $request, GaleriService $service){
        $galeri = $service->createGaleri($request->all(), $request->file());
        return response($galeri, 201);
    }

    public function show(string $id)
    {
        $galeri = galeri::where('id',$id)->with(['unitUsaha.products.productImages','profilUsahaImages'])->first();
        return response($galeri,200);
    }

    public function update(Request $request, string $id, GaleriService $service)
    {
        $galeri = $service->updateGaleri($id,$request->all(),$request->file());
        return $galeri;
    }

    public function destroy(string $id, GaleriService $service)
    {
        $service = $service->deleteGaleri($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
