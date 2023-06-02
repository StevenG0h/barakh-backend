<?php 
    namespace App\Http\Traits;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

    trait KecamatanTrait{
        public function createKecamatanValidator(Array $data){
            $validator = Validator::make($data,[
                'kecamatanName'=>'required',
                'kotaId'=>'required'
            ]);
            return $validator;
        }
    }