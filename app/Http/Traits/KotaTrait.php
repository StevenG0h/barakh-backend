<?php 
    namespace App\Http\Traits;
    use Illuminate\Support\Facades\Validator;

    trait KotaTrait{
        public function CreateKotaValidator(Array $data){
            $validator = Validator::make($data,[
                'kotaName'=>'required',
                'provinsiId'=>'required'
            ]);
            return $validator;
        }
    }