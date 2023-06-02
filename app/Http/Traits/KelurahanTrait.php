<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait KecamatanTrait{
        public function CreateKelurahanValidator(Array $data){
            $validator = Validator::make($data,[
                'kelurahanName'=>'required',
                'kecamatanId'=>'required'
            ]);
            return $validator;
        }
    }