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

        public function UpdateKecamatanValidator(Array $data){
            $validator = Validator::make($data,[
                'kecamatanName'=>'sometimes|string',
                'kotaId'=>'sometimes',
            ]);
            return $validator;
        }
    }