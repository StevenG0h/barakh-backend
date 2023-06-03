<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait KelurahanTrait{
        public function CreateKelurahanValidator(Array $data){
            $validator = Validator::make($data,[
                'kelurahanName'=>'required|string',
                'kecamatanId'=>'required',
                'kodePos'=>'required|string'
            ]);
            return $validator;
        }
    }