<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(){
        $visitor = Visitor::whereDate('created_at', Carbon::today())->first();
        if(empty($visitor)){
            $visitor = new Visitor();
            $visitor->count = 1;
            $visitor->save();
            return response('',200);
        }
        $visitor->count = $visitor->count + 1;
        $visitor->save();
        return response('',200);

    }
}
