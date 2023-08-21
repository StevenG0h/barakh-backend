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
        $provinsi = Product::with(['productImages','unitUsaha','rating'])->paginate(25);
        return response([
            "data"=>$provinsi
        ],200);
    }
    
    public function home()
    {
        $provinsi = Product::with(['productImages'])->orderBy('created_at','desc')->paginate(3);
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
        $provinsi = Product::where('id',$id)->with(['unitUsaha','productImages','rating'])->first();
        return response($provinsi,200);
    }
    
    public function searchWithFilter(Request $request)
    {   
        $product = Product::with(['productImages','unitUsaha','rating']);
        if($request->id != 'all'){
            $product = $product->where('unit_usaha_id',$request->id);
        }
        if($request->keyword != ''){
            $product = $product->where('productName','%Like%',$request->keyword);
        }
        if($request->harga != ''){
            $product = $product->orderBy('productPrice',$request->harga);
        }
        $product = $product->orderBy('created_at',$request->orderBy)->paginate(25);
        return response($product,200);
    }
    
    public function showWithFilter(string $id)
    {
        $provinsi = Product::with(['productImages','unitUsaha','rating'])->where('unit_usaha_id',$id)->paginate(25);
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
