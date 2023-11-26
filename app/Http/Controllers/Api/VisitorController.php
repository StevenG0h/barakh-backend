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
    public function getVisitor(Request $request){
        $data = $request->all();
        $stat =  Visitor::select( 
          \DB::raw('SUM(count) as total')
        );
        return response($stat->get(), 200);
    }
}
