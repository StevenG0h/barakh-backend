<?php 
    namespace App\Http\Traits;
    use Illuminate\Http\Request;

    trait TestimonyTrait{
        public function CreateTestimonyValidator(Request $data){
            $validator = $data->validate([
                'testimonyDesc'=>'required',
                'testimonyImage'=>'required'
            ]);
            return $validator;
        }
    }