<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $Roles = role::all();
        return response($Roles,200);
    }

    public function getAll()
    {
        $Roles = role::paginate(25);
        return response($Roles,200);
    }

    public function store(Request $request, RoleService $service)
    {
        $Role = $service->createRole($request->all());
        return response($Role,202);
    }

    public function update(Request $request, string $id, RoleService $service)
    {
        $Role = $service->updateRole($id,$request->all());
        return $Role;
    }

    public function destroy(string $id, RoleService $service)
    {
        $service = $service->deleteRole($id);
        return response([
            'msg'=>'success'
        ],200);
    }
}
