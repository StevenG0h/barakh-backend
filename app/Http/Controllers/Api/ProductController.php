<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $provinsi = Product::with(['productImages','unitUsaha'=>function($query){
                    return $query->where('isActive',1);
                },'rating'])->where('isActive',1)->whereRelation('unitUsaha','unit_usaha_id','=',$user->unit_usaha_id)->orderBy('updated_at','desc')->paginate(50);
                return response([
                    "data"=>$provinsi
                ],200);
            }
        }
        $provinsi = Product::with(['productImages','unitUsaha'=>function($query){
            return $query->where('isActive',1);
        },'rating'])->whereRelation('unitUsaha','isActive','=','1')->where('isActive',1)->orderBy('updated_at','desc')->paginate(25);
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function katalog()
    {
        $provinsi = Product::with(['productImages','unitUsaha'=>function($query){
            return $query->where('isActive',1);
        },'rating'])->whereRelation('unitUsaha','isActive','=','1')->where('isActive',1)->orderBy('updated_at','desc')->paginate(12);
        return response([
            "data"=>$provinsi
        ],200);
    }
    
    public function home()
    {
        $provinsi = Product::with(['productImages'])->orderBy('updated_at','desc')->whereRelation('unitUsaha','isActive','=','1')->where('isActive',1)->paginate(3);
        return response([
            "data"=>$provinsi
        ],200);
    }
    
    public function getCart(Request $request)
    {
        $data = $request->all();
        $provinsi = Product::with(['productImages','unitUsaha'])->whereIn('id',$data['data'])->where('isActive',1)->get();
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

    public function getInCartProduct(Request $request)
    {
        $provinsi = Product::findMany($request->productIds);
        return response($provinsi,200);
    }
    
    public function searchWithFilter(Request $request)
    {   
        
        $product = Product::with(['productImages','unitUsaha'=>function($query){
            return $query->where('isActive',1);
        },'rating']);
        if($request->id != 'all'){
            $product = $product->where('unit_usaha_id',$request->id);
        }
        if($request->keyword != ''){
            $product = $product->where('productName','Like','%'.$request->keyword.'%');
        }
        if($request->harga != ''){
            $product = $product->orderBy('productPrice',$request->harga);
        }
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $product = $product->whereRelation('unitUsaha','unit_usaha_id','=',$user->unit_usaha_id);
            }
        }
        $product = $product->whereRelation('unitUsaha','isActive','=','1')->orderBy('updated_at','desc')->where('isActive',1)->paginate(25);
        return response($product,200);
    }
    
    public function showWithFilter(string $id)
    {
        $provinsi = Product::with(['productImages','unitUsaha'=>function($query){
            return $query->where('isActive',1);
        },'rating'])->where('unit_usaha_id',$id)->where('isActive',1)->orderBy('updated_at','desc')->paginate(25);
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
