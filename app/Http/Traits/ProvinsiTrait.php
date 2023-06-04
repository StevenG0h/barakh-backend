<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait ProvinsiTrait{
        public function createProvinsiValidator(Array $data){
            $validator = Validator::make($data,[
                'provinsiName'=>'required',
            ]);
            return $validator;
        }
        
        public function UpdateProvinsiValidator(Array $data){
            $validator = Validator::make($data,[
                'provinsiName'=>'sometimes|string',
            ]);
            return $validator;
        }
    }