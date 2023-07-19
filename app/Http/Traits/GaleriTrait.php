<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

    trait GaleriTrait{
        public function CreateGaleriValidator(Array $data){
            $validator = Validator::make($data,[
                'galeriTitle'=>'required',
                'galeriDate'=>'required',
                'path'=>'required',
            ]);
            return $validator;
        }
        
        public function UpdateGaleriValidator(Array $data){
            $validator = Validator::make($data,[
                'galeriTitle'=>'sometimes',
                'galeriDate'=>'sometimes',
                'path'=>'sometimes',
            ]);
            return $validator;
        }
    }