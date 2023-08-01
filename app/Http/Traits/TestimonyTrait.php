<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait TestimonyTrait{
        public function CreateTestimonyValidator(Array $data){
            $validator = Validator::make($data,[
                'testimonyDesc'=>'required',
                'clientName'=>'required'
            ]);
            return $validator;
        }
        
        public function UpdateTestimonyValidator(Array $data){
            $validator = Validator::make($data,[
                'testimonyDesc'=>'sometimes',
                'clientName'=>'sometimes'
            ]);
            return $validator;
        }
    }