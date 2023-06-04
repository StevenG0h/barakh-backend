<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait TestimonyTrait{
        public function CreateTestimonyValidator(Array $data){
            $validator = Validator::make($data,[
                'testimonyDesc'=>'required',
                'testimonyImage'=>'required'
            ]);
            return $validator;
        }
        
        public function UpdateTestimonyValidator(Array $data){
            $validator = Validator::make($data,[
                'testimonyDesc'=>'sometimes',
                'testimonyImage'=>'sometimes'
            ]);
            return $validator;
        }
    }