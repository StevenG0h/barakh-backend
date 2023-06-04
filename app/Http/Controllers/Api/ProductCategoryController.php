<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Services\ProductCategoryService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $provinsi = ProductCategory::all();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, ProductCategoryService $service){
        $provinsi = $service->createProductCategory($request->all());
        return response($provinsi, 201);
    }

    public function show(string $id)
    {
        $provinsi = ProductCategory::where('id',$id)->first();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, ProductCategoryService $service)
    {
        $provinsi = $service->updateProductCategory($id,$request->all());
        return $provinsi;
    }

    public function destroy(string $id, ProductCategoryService $service)
    {
        $service = $service->deleteProductCategory($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
