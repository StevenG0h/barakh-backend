<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

    trait unitUsahaTrait{
        public function CreateUnitUsahaValidator(Array $data){
            $validator = Validator::make($data,[
                'usahaName'=>'required',
                'usahaDesc'=>'required',
                'usahaImage'=>['required',File::image()],
                'unitUsahaLogo'=>['required',File::image()],
            ]);
            return $validator;
        }
        
        public function UpdateUnitUsahaValidator(Array $data){
            $validator = Validator::make($data,[
                'usahaName'=>'sometimes',
                'usahaDesc'=>'sometimes',
                'usahaImage'=>['sometimes'],
                'unitUsahaLogo'=>['sometimes'],
                'orders'=>'sometimes'
            ]);
            return $validator;
        }
    }