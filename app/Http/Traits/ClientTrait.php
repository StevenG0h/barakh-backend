<?php 
    namespace App\Http\Traits;
    use Illuminate\Http\Request;

    trait ClientTrait{
        public function CreateClientValidator(Request $data){
            $validator = $data->validate([
                'clientName'=>'required',
                'clientProvinsi'=>'required',
                'clientKota'=>'required',
                'clientKecamatan'=>'required',
                'clientKelurahan'=>'required',
                'clientAddress'=>'required'
            ]);
            return $validator;
        }
    }