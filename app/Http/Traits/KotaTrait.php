<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait KotaTrait{
        public function CreateKotaValidator(Array $data){
            $validator = Validator::make($data,[
                'kota'=>'required',
                'provinsiId'=>'required'
            ]);
            return $validator;
        }

        public function UpdateKotaValidator(Array $data){
            $validator = Validator::make($data,[
                'kota'=>'sometimes|string',
                'provinsiId'=>'sometimes',
            ]);
            return $validator;
        }
    }