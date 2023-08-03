<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, ProductService $service, String $id){
        $rating = $service->addRating($id,$request->all());
        return response($rating, 201);
    }
}
