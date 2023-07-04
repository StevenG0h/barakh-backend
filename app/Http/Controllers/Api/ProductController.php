<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $provinsi = Product::with(['productImages','unitUsaha'])->get();
        return response([
            "data"=>$provinsi
        ],200);
    }
    
    public function getCart(Request $request)
    {
        $data = $request->all();
        $provinsi = Product::with(['productImages','unitUsaha'])->whereIn('id',$data['data'])->get();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, ProductService $service){
        $provinsi = $service->createProduct($request->all());
        return response($request, 201);
    }

    public function show(string $id)
    {
        $provinsi = Product::where('id',$id)->with(['unitUsaha'])->first();
        return response($provinsi,200);
    }
    
    public function showWithFilter(string $id)
    {
        $provinsi = Product::where('unit_usaha_id',$id)->get();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, ProductService $service)
    {
        $provinsi = $service->updateProduct($id,$request->all());
        return $provinsi;
    }

    public function destroy(string $id, ProductService $service)
    {
        $service = $service->deleteProduct($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
