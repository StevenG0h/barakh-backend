<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait unitUsahaTrait{
        public function CreateUnitUsahaValidator(Array $data){
            $validator = Validator::make($data,[
                'usahaName'=>'required',
                'usahaDesc'=>'required'
            ]);
            return $validator;
        }
        
        public function UpdateUnitUsahaValidator(Array $data){
            $validator = Validator::make($data,[
                'usahaName'=>'sometimes',
                'usahaDesc'=>'sometimes'
            ]);
            return $validator;
        }
    }