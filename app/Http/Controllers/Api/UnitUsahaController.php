<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\UnitUsaha;
use App\Services\UnitUsahaService;
use Illuminate\Http\Request;

class UnitUsahaController extends Controller
{
    public function index(Request $request)
    {
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $unitUsaha = UnitUsaha::where('id',$user->unit_usaha_id)->with('products')->where('isActive','=',1)->orderBy('orders','asc')->paginate('25');
                return response([
                    "data"=>$unitUsaha
                ],200);
            }
        }
        $unitUsaha = UnitUsaha::with(['products'=>function($q){
            $q->where('isActive',1);
        }])->where('isActive','=',1)->orderBy('orders','asc')->paginate('25');
        return response([
            "data"=>$unitUsaha
        ],200);
    }
    
    public function getOptions(Request $request)
    {
        
        if($request->user() != null){
            $user = Admin::where('user_id',$request->user()->id)->with(['role'])->first();
            if($user->role->permission == 0){
                $unitUsaha = UnitUsaha::where('id',$user->unit_usaha_id)->where('isActive',1)->orderBy('orders','asc')->get();
                return response([
                    "data"=>$unitUsaha
                ],200);
            }
        }
        $unitUsaha = UnitUsaha::where('isActive',1)->whereHas('products', function($q){
            return $q->where('isActive', 1);
        })->orderBy('orders','asc')->get();
        return response([
            "data"=>$unitUsaha
        ],200);
    }

    public function store(Request $request, UnitUsahaService $service){
        $unitUsaha = $service->createUnitUsaha($request->all(), $request->usahaImage, $request->unitUsahaLogo);
        return response($unitUsaha, 201);
    }

    public function show(string $id)
    {
        $unitUsaha = UnitUsaha::findOrFail($id);
        $product = Product::where('unit_usaha_id',$id)->with('productImages')->where('isActive',1)->paginate(25);
        $data['unitUsaha'] = $unitUsaha;
        $data['product'] = $product;
        return response($data,200);
    }
    
    public function showProductOption(string $id)
    {
        $unitUsaha = Product::where('unit_usaha_id',$id)->where('isActive',1)->where('isActive',1)->get();
        return response($unitUsaha,200);
    }

    public function update(Request $request, string $id, UnitUsahaService $service)
    {
        $unitUsaha = $service->updateUnitUsaha($id,$request->all(),$request->usahaImage,$request->unitUsahaLogo);
        return $unitUsaha;
    }

    public function destroy(string $id, UnitUsahaService $service)
    {
        $service = $service->deleteUnitUsaha($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
