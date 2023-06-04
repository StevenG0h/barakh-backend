<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $provinsi = Client::all();
        return response([
            "data"=>$provinsi
        ],200);
    }

    public function store(Request $request, ClientService $service){
        $provinsi = $service->createClient($request->all());
        return response($provinsi, 201);
    }
    public function show(string $id)
    {
        $provinsi = Client::where('id',$id)->first();
        return response($provinsi,200);
    }

    public function update(Request $request, string $id, ClientService $service)
    {
        $provinsi = $service->updateClient($id,$request->all());
        return $provinsi;
    }

    public function destroy(string $id, ClientService $service)
    {
        $service = $service->deleteClient($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
