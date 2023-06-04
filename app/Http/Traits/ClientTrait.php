<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait ClientTrait{
        public function CreateClientValidator(Array $data){
            $validator = Validator::make($data,[
                'clientName'=>'required',
                'clientProvinsi'=>'required',
                'clientKota'=>'required',
                'clientKecamatan'=>'required',
                'clientKelurahan'=>'required',
                'clientAddress'=>'required'
            ]);
            return $validator;
        }
        public function UpdateClientValidator(Array $data){
            $validator = Validator::make($data,[
                'clientName'=>'sometimes',
                'clientProvinsi'=>'sometimes',
                'clientKota'=>'sometimes',
                'clientKecamatan'=>'sometimes',
                'clientKelurahan'=>'sometimes',
                'clientAddress'=>'sometimes'
            ]);
            return $validator;
        }
    }