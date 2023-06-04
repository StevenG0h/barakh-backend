<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use App\Services\TestimonyService;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index()
    {
        $provinsi = Testimony::all();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, TestimonyService $service){
        $provinsi = $service->createTestimony($request->all());
        return response($provinsi, 201);
    }

    public function show(string $id)
    {
        $provinsi = Testimony::where('id',$id)->first();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, TestimonyService $service)
    {
        $provinsi = $service->updateTestimony($id,$request->all());
        return $provinsi;
    }

    public function destroy(string $id, TestimonyService $service)
    {
        $service = $service->deleteTestimony($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
