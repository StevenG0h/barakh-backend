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
        $client = Client::all();
        return response([
            "data"=>$client
        ],200);
    }

    public function store(Request $request, ClientService $service){
        $client = $service->createClient($request->all());
        return response($client, 201);
    }
    
    public function show(string $id)
    {
        $client = Client::where('id',$id)->first();
        return response($client,200);
    }

    public function update(Request $request, Client $id, ClientService $service)
    {
        $client = $service->updateClient($id,$request->all());
        return $client;
    }

    public function destroy(string $id, ClientService $service)
    {
        $service = $service->deleteClient($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
